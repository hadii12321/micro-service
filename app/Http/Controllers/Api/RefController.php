<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\Ref\RefEselonService;
use App\Services\Ref\RefHubunganKeluargaService;
use App\Services\Ref\RefJenisAsuransiService;
use App\Services\Ref\RefJenjangPendidikanService;
use App\Services\Tools\ResponseService;
use App\Services\Tools\TransactionService;
use Illuminate\Http\JsonResponse;

final class RefController extends Controller
{
    public function __construct(
        private readonly RefJenjangPendidikanService $refJenjangPendidikanService,
        private readonly RefHubunganKeluargaService  $refHubunganKeluargaService,
        private readonly RefJenisAsuransiService     $refJenisAsuransiService,
        private readonly RefEselonService            $refEselonService,
        private readonly TransactionService          $transactionService,
        private readonly ResponseService             $responseService,
    ) {}

    public function hubunganKeluarga(): JsonResponse
    {
        return $this->transactionService->handleWithShow(function () {
            $data = $this->refHubunganKeluargaService->getListDataOrdered('id_hubungan_keluarga');

            return $this->responseService->successResponse('Data berhasil diambil', $data);
        });
    }
    public function jenjangPendidikan(): JsonResponse
    {
        return $this->transactionService->handleWithShow(function () {
            $data = $this->refJenjangPendidikanService->getListDataOrdered('id_jenjang_pendidikan');

            return $this->responseService->successResponse('Data berhasil diambil', $data);
        });
    }

    public function jenisAsuransi(): JsonResponse
    {
        return $this->transactionService->handleWithShow(function () {
            $data = $this->refJenisAsuransiService->getListDataOrdered('id_jenis_asuransi');

            $data->transform(function ($item) {
                $item->setAttribute('jenis_asuransi', $item->nama_produk . ' (' . $item->jenis_asuransi . ')');
                return $item;
            });

            return $this->responseService->successResponse('Data berhasil diambil', $data);
        });
    }

    public function eselon(): JsonResponse
    {
        return $this->transactionService->handleWithShow(function () {
            $data = $this->refEselonService->getListDataOrdered('id_eselon');

            return $this->responseService->successResponse('Data berhasil diambil', $data);
        });
    }
}
