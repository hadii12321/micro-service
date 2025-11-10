<?php

namespace App\Http\Controllers\Admin\Sdm;

use App\Http\Controllers\Controller;
use App\Http\Requests\Sdm\SdmStrukturalStoreRequest;
use App\Http\Requests\Sdm\SdmStrukturalUpdateRequest;
use App\Services\Sdm\SdmStrukturalService;
use App\Services\Tools\FileUploadService;
use App\Services\Tools\ResponseService;
use App\Services\Tools\TransactionService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use InvalidArgumentException;

final class SdmStrukturalController extends Controller
{
    public function __construct(
        private readonly SdmStrukturalService $sdmStrukturalService,
        private readonly TransactionService   $transactionService,
        private readonly ResponseService      $responseService,
        private readonly FileUploadService    $fileUploadService,
    )
    {
    }

    public function index(string $uuid): View
    {
        $person = $this->sdmStrukturalService->getPersonDetailByUuid($uuid);

        return view('admin.sdm.struktural.index', ['person' => $person, 'id' => $uuid]);
    }

    public function list(string $uuid): JsonResponse
    {
        return $this->transactionService->handleWithDataTable(
            function () use ($uuid) {
                return $this->sdmStrukturalService->getListData($uuid);
            },
            [
                'action' => function ($row) {
                    $btns = [
                        $this->transactionService->actionButton($row->id_struktural, 'detail'),
                    ];
                    if (!empty($row->is_latest)) {
                        $btns[] = $this->transactionService->actionButton($row->id_struktural, 'edit');
                        $btns[] = $this->transactionService->actionButton($row->id_struktural, 'delete');
                    }

                    return implode(' ', $btns);
                },
            ]
        );
    }

    public function listApi(string $uuid): JsonResponse
    {
        return $this->transactionService->handleWithDataTable(
            function () use ($uuid) {
                return $this->sdmStrukturalService->getListData($uuid);
            }
        );
    }

    public function store(SdmStrukturalStoreRequest $request): JsonResponse
    {
        $idSdm = $this->sdmStrukturalService->resolveIdSdmFromUuid($request->uuid_person);
        if (!$idSdm) {
            return $this->responseService->errorResponse('SDM tidak ditemukan');
        }
        $fileSkMasuk = $request->file('file_sk_masuk');
        $fileSkKeluar = $request->file('file_sk_keluar');
        if ($fileSkMasuk) {
            try {
                $this->fileUploadService->validateFileForUpload($fileSkMasuk);
            } catch (InvalidArgumentException $e) {
                return $this->responseService->errorResponse($e->getMessage(), 422);
            }
        }
        if ($fileSkKeluar) {
            try {
                $this->fileUploadService->validateFileForUpload($fileSkKeluar);
            } catch (InvalidArgumentException $e) {
                return $this->responseService->errorResponse($e->getMessage(), 422);
            }
        }
        return $this->transactionService->handleWithTransaction(function () use ($request, $idSdm, $fileSkMasuk, $fileSkKeluar) {
            $payload = $request->only([
                'id_unit', 'id_jabatan', 'nomor_sk', 'tanggal_sk', 'tanggal_masuk',
                'masa_jabatan', 'tanggal_keluar', 'sk_pemberhentian',
                'alasan_keluar', 'keterangan',
            ]);
            $payload['id_sdm'] = $idSdm;
            $this->sdmStrukturalService->updatePreviousStructuralRecords($idSdm);
            $data = $this->sdmStrukturalService->create($payload);
            if ($fileSkMasuk) {
                $uploadResult = $this->sdmStrukturalService->handleFileUpload($fileSkMasuk, $idSdm, 'sk_masuk');
                $data->update([
                    'file_sk_masuk' => $uploadResult['file_name'],
                ]);
            }
            if ($fileSkKeluar) {
                $uploadResult = $this->sdmStrukturalService->handleFileUpload($fileSkKeluar, $idSdm, 'sk_keluar');
                $data->update([
                    'file_sk_keluar' => $uploadResult['file_name'],
                ]);
            }
            return $this->responseService->successResponse('Data berhasil dibuat', $data, 201);
        });
    }

    public function update(SdmStrukturalUpdateRequest $request, string $id): JsonResponse
    {
        $data = $this->sdmStrukturalService->findById($id);
        if (!$data) {
            return $this->responseService->errorResponse('Data tidak ditemukan');
        }
        if (!$this->sdmStrukturalService->isLatestRecord($data)) {
            return $this->responseService->errorResponse('Hanya data terbaru yang bisa diubah', 422);
        }
        $fileSkMasuk = $request->file('file_sk_masuk');
        $fileSkKeluar = $request->file('file_sk_keluar');
        if ($fileSkMasuk) {
            try {
                $this->fileUploadService->validateFileForUpload($fileSkMasuk);
            } catch (InvalidArgumentException $e) {
                return $this->responseService->errorResponse($e->getMessage(), 422);
            }
        }
        if ($fileSkKeluar) {
            try {
                $this->fileUploadService->validateFileForUpload($fileSkKeluar);
            } catch (InvalidArgumentException $e) {
                return $this->responseService->errorResponse($e->getMessage(), 422);
            }
        }
        return $this->transactionService->handleWithTransaction(function () use ($request, $data, $fileSkMasuk, $fileSkKeluar) {
            $payload = $request->only([
                'id_unit', 'id_jabatan', 'nomor_sk', 'tanggal_sk', 'tanggal_masuk',
                'masa_jabatan', 'tanggal_keluar', 'sk_pemberhentian',
                'alasan_keluar', 'keterangan',
            ]);
            $updatedData = $this->sdmStrukturalService->update($data, $payload);
            if ($fileSkMasuk) {
                $uploadResult = $this->sdmStrukturalService->updateFileUpload(
                    $fileSkMasuk,
                    $data->file_sk_masuk,
                    $data->id_sdm,
                    'sk_masuk'
                );
                $updatedData->update([
                    'file_sk_masuk' => $uploadResult['file_name'],
                ]);
            }
            if ($fileSkKeluar) {
                $uploadResult = $this->sdmStrukturalService->updateFileUpload(
                    $fileSkKeluar,
                    $data->file_sk_keluar,
                    $data->id_sdm,
                    'sk_keluar'
                );
                $updatedData->update([
                    'file_sk_keluar' => $uploadResult['file_name'],
                ]);
            }
            return $this->responseService->successResponse('Data berhasil diperbarui', $updatedData);
        });
    }

    public function show(string $id): JsonResponse
    {
        return $this->transactionService->handleWithShow(function () use ($id) {
            $data = $this->sdmStrukturalService->getDetailData($id);

            return $this->responseService->successResponse('Data berhasil diambil', $data);
        });
    }

    public function destroy(string $id): JsonResponse
    {
        $data = $this->sdmStrukturalService->findById($id);
        if (!$data) {
            return $this->responseService->errorResponse('Data tidak ditemukan');
        }

        if (!$this->sdmStrukturalService->isLatestRecord($data)) {
            return $this->responseService->errorResponse('Hanya data terbaru yang bisa dihapus', 422);
        }

        return $this->transactionService->handleWithTransaction(function () use ($data) {
            $this->sdmStrukturalService->delete($data);

            return $this->responseService->successResponse('Data berhasil dihapus');
        });
    }
}
