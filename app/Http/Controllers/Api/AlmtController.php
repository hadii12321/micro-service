<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\Ref\RefAlmtService;
use App\Services\Tools\ResponseService;
use App\Services\Tools\TransactionService;
use Illuminate\Http\JsonResponse;

final class AlmtController extends Controller
{
    public function __construct(
        private readonly TransactionService $transactionService,
        private readonly RefAlmtService     $refAlmtService,
        private readonly ResponseService    $responseService,
    )
    {
    }

    public function provinsi(): JsonResponse
    {
        return $this->transactionService->handleWithShow(function () {
            $data = $this->refAlmtService->getProvinsi();

            return $this->responseService->successResponse('Data berhasil diambil', $data);
        });
    }

    public function kabupaten(string $id): JsonResponse
    {
        return $this->transactionService->handleWithShow(function () use ($id) {
            $data = $this->refAlmtService->getKabupaten($id);

            return $this->responseService->successResponse('Data berhasil diambil', $data);
        });
    }

    public function kecamatan(string $id): JsonResponse
    {
        return $this->transactionService->handleWithShow(function () use ($id) {
            $data = $this->refAlmtService->getKecamatan($id);

            return $this->responseService->successResponse('Data berhasil diambil', $data);
        });
    }

    public function desa(string $id): JsonResponse
    {
        return $this->transactionService->handleWithShow(function () use ($id) {
            $data = $this->refAlmtService->getDesa($id);

            return $this->responseService->successResponse('Data berhasil diambil', $data);
        });
    }
}
