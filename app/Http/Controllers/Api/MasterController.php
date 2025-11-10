<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\Master\MasterJabatanService;
use App\Services\Master\MasterPeriodeService;
use App\Services\Master\MasterUnitService;
use App\Services\Tools\ResponseService;
use App\Services\Tools\TransactionService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

final class MasterController extends Controller
{
    public function __construct(
        private readonly TransactionService   $transactionService,
        private readonly MasterPeriodeService $peroideService,
        private readonly MasterUnitService    $unitService,
        private readonly MasterJabatanService $jabatanService,
        private readonly ResponseService      $responseService,
    ) {}

    
    public function jabatan(Request $request): JsonResponse
    {
        return $this->transactionService->handleWithShow(function () use ($request) {
            $data = $this->jabatanService->getApiData($request);

            return $this->responseService->successResponse('Data berhasil diambil', $data);
        });
    }
    
    public function unit(): JsonResponse
    {
        return $this->transactionService->handleWithShow(function () {
            $data = $this->unitService->getListData();

            return $this->responseService->successResponse('Data berhasil diambil', $data);
        });
    }

    public function periode(): JsonResponse
    {
        return $this->transactionService->handleWithShow(function () {
            $data = $this->peroideService->getListDataOrdered('id_periode');

            return $this->responseService->successResponse('Data berhasil diambil', $data);
        });
    }
}
