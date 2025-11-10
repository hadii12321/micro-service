<?php

namespace App\Services\Tools;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Validator;

final class ValidationService
{
    public function validateData(array $data, array $rules, array $messages = [], array $attributes = []): ?JsonResponse
    {
        $validator = Validator::make($data, $rules, $messages, $attributes);

        if ($validator->fails()) {
            $errors = $validator->errors();

            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal',
                'errors' => $errors->messages(),
            ], 400);
        }

        return null;
    }

    public function validateDataView(array $data, array $rules, array $messages = [], array $attributes = []): ?RedirectResponse
    {
        $validator = Validator::make($data, $rules, $messages, $attributes);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        return null;
    }
}
