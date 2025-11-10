<?php

namespace App\Services\Tools;

use Illuminate\Http\JsonResponse;

final class ResponseService
{
    public function errorResponse(string $message, int $statusCode = 400): JsonResponse
    {
        return response()->json(['success' => false, 'message' => $message], $statusCode);
    }

    public function successResponse(string $message, $data = null, int $statusCode = 200): JsonResponse
    {
        return response()->json(['success' => true, 'message' => $message, 'data' => $data], $statusCode);
    }
}
