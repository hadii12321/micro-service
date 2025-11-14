<?php

namespace App\Http\Controllers\Content;

use App\Http\Controllers\Controller;
use App\Services\Tools\FileUploadService;
use App\Services\Tools\ResponseService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Http; // <- untuk verifikasi reCAPTCHA
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\StreamedResponse;

final class PortalController extends Controller
{
    public function __construct(
        private readonly ResponseService   $responseService,
        private readonly FileUploadService $fileUploadService
    ) {}

    public function login(): View
    {
        if (Auth::guard('admin')->check()) {
            return view('admin.dashboard');
        }

        return view('portal');
    }

    public function logindb(Request $request): RedirectResponse
    {
        $username = $request->input('username');
        $password = $request->input('password');

        // Validasi input + reCAPTCHA v2 (g-recaptcha-response)
        $validationRules = [
            'username' => 'required',
            'password' => 'required',
            'g-recaptcha-response' => 'required|string',
        ];

        $customMessages = [
            'username.required' => 'Nama Pengguna harus diisi.',
            'password.required' => 'Kata Kunci harus diisi.',
            'g-recaptcha-response.required' => 'Harap menyelesaikan reCAPTCHA.',
        ];

        $validator = Validator::make($request->all(), $validationRules, $customMessages);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Verifikasi reCAPTCHA v2 ke Google
        try {
            $response = Http::asForm()->post('https://www.google.com/recaptcha/api/siteverify', [
                'secret' => config('services.recaptcha.secret'),
                'response' => $request->input('g-recaptcha-response'),
                'remoteip' => $request->ip(),
            ]);
        } catch (\Throwable $e) {
            Log::error('recaptcha.request.failed', ['error' => $e->getMessage(), 'username' => $username]);
            return redirect()->back()->with('error', 'Gagal memverifikasi reCAPTCHA. Silakan coba lagi.')->withInput();
        }

        if (! $response->ok()) {
            Log::warning('recaptcha.response_not_ok', ['status' => $response->status(), 'body' => $response->body(), 'username' => $username]);
            return redirect()->back()->with('error', 'Gagal memverifikasi reCAPTCHA (response error).')->withInput();
        }

        $body = $response->json();

        // Untuk v2 cukup cek "success"
        if (! isset($body['success']) || $body['success'] !== true) {
            Log::warning('recaptcha.invalid', ['body' => $body, 'username' => $username]);
            return redirect()->back()->with('error', 'reCAPTCHA tidak valid atau terdeteksi bot.')->withInput();
        }

        // Lanjutkan autentikasi (kamu menggunakan email sebagai field)
        if (Auth::guard('admin')->attempt(['email' => $username, 'password' => $password])) {
            return redirect()->intended();
        } else {
            return redirect()->back()->with('error', 'nama pengguna dan kata kunci salah')->withInput();
        }
    }

    public function logout(): RedirectResponse
    {
        Auth::guard('admin')->logout();

        return redirect()->route('index')->with('success', 'Anda telah berhasil keluar.');
    }

    public function error(Request $request): JsonResponse
    {
        $csrfToken = $request->header('X-CSRF-TOKEN');

        if ($csrfToken !== csrf_token()) {
            return $this->responseService->errorResponse('Token CSRF tidak valid.');
        }

        Log::channel('daily')->error('client-error', ['data' => $request->all()]);

        return $this->responseService->successResponse('Error berhasil dicatat.');
    }

    public function viewFile(Request $request, string $dir, string $filename): BinaryFileResponse|StreamedResponse
    {
        return $this->fileUploadService->viewFile($request, $dir, $filename);
    }
}
