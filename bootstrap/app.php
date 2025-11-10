<?php

use App\Http\Middleware\AttandanceMiddleware;
use App\Http\Middleware\SdmMiddleware;
use App\Http\Middleware\ThreatDetectionMiddleware;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;
use Illuminate\Session\TokenMismatchException;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;
use Illuminate\Validation\UnauthorizedException;
use Psr\Log\LogLevel;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Exception\RouteNotFoundException;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        using: static function (): void {
            Route::middleware('web')->group(base_path('routes/web.php'));
            Route::middleware(['web', 'auth:admin'])->prefix('admin')->name('admin.')->group(base_path('routes/admin.php'));
            Route::middleware(['api'])->prefix('api')->group(base_path('routes/api.php'));
        },
    )
    ->withMiddleware(static function (Middleware $middleware): void {
        $middleware->trustProxies(at: '*');
        $middleware->append([
            ThreatDetectionMiddleware::class,
        ]);
    })
    ->withExceptions(static function (Exceptions $exceptions): void {
        $exceptions->reportable(static function (Throwable $e) {
            Log::log(
                match (true) {
                    $e instanceof NotFoundHttpException, $e instanceof ModelNotFoundException => LogLevel::WARNING,
                    $e instanceof AuthenticationException => LogLevel::NOTICE,
                    default => LogLevel::ERROR,
                },
                $e->getMessage(),
                ['exception' => $e, 'file' => $e->getFile(), 'line' => $e->getLine()],
            );
        });

        $exceptions->render(static function (Throwable $e, Request $request) {
            $status = 500;
            $message = 'Terjadi kesalahan pada server.';
            if ($e instanceof NotFoundHttpException || $e instanceof RouteNotFoundException || $e instanceof ModelNotFoundException) {
                $status = 404;
                $message = 'Halaman tidak ditemukan.';
            } elseif ($e instanceof MethodNotAllowedHttpException) {
                $status = 405;
                $message = 'Metode tidak diperbolehkan.';
            } elseif ($e instanceof TokenMismatchException || $e instanceof AuthenticationException) {
                session()->invalidate();
                session()->regenerateToken();
                $redirect = redirect()->route('index')->with('error', $e instanceof TokenMismatchException ? 'Sesi Anda telah berakhir. Silakan login kembali.' : 'Anda harus login untuk mengakses halaman ini.');

                return $request->wantsJson() ? response()->json(['message' => $e instanceof TokenMismatchException ? 'Token mismatch.' : 'Unauthenticated.'], $e instanceof TokenMismatchException ? 419 : 401) : $redirect;
            } elseif ($e instanceof AccessDeniedHttpException || $e instanceof AuthorizationException || $e instanceof UnauthorizedException) {
                $status = 403;
                $message = 'Akses ditolak. Anda tidak memiliki izin untuk melakukan tindakan ini.';
            } elseif ($e instanceof HttpExceptionInterface) {
                $status = $e->getStatusCode();
                $message = $e->getMessage();
            }

            if (app()->isProduction() && $status === 500) {
                $message = 'Terjadi kesalahan pada server.';
            }

            return $request->wantsJson() ? response()->json(['success' => false, 'message' => $message], $status) : response()->view("errors.$status", ['message' => $message], $status);
        });
    })
    ->create();
