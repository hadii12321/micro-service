<?php

namespace App\Http\Controllers\Admin\Sdm;

use App\Http\Controllers\Controller;
use App\Http\Requests\Sdm\SdmRiwayatPendidikanStoreRequest;
use App\Http\Requests\Sdm\SdmRiwayatPendidikanUpdateRequest;
use App\Services\Sdm\SdmRiwayatPendidikanService;
use App\Services\Tools\FileUploadService;
use App\Services\Tools\ResponseService;
use App\Services\Tools\TransactionService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use InvalidArgumentException;

final class SdmRiwayatPendidikanController extends Controller
{
    public function __construct(
        private readonly SdmRiwayatPendidikanService $sdmRiwayatPendidikanService,
        private readonly TransactionService          $transactionService,
        private readonly ResponseService             $responseService,
        private readonly FileUploadService           $fileUploadService,
    )
    {
    }

    public function index(string $uuid): View
    {
        $person = $this->sdmRiwayatPendidikanService->getPersonDetailByUuid($uuid);

        return view('admin.sdm.riwayat_pendidikan.index', ['person' => $person, 'id' => $uuid]);
    }

    public function list(string $uuid, Request $request): JsonResponse
    {
        return $this->transactionService->handleWithDataTable(
            function () use ($uuid, $request) {
                return $this->sdmRiwayatPendidikanService->getListData($uuid, $request);
            },
            [
                'action' => fn($row) => implode(' ', [
                    $this->transactionService->actionButton($row->id_riwayat_pendidikan, 'detail'),
                    $this->transactionService->actionButton($row->id_riwayat_pendidikan, 'edit'),
                    $this->transactionService->actionButton($row->id_riwayat_pendidikan, 'delete'),
                ]),
            ]
        );
    }

    public function listApi(string $uuid, Request $request): JsonResponse
    {
        return $this->transactionService->handleWithDataTable(
            function () use ($uuid, $request) {
                return $this->sdmRiwayatPendidikanService->getListData($uuid, $request);
            }
        );
    }

    public function store(SdmRiwayatPendidikanStoreRequest $request): JsonResponse
    {
        $idSdm = $this->sdmRiwayatPendidikanService->resolveIdSdmFromUuid($request->uuid_person);
        if (!$idSdm) {
            return $this->responseService->errorResponse('SDM tidak ditemukan');
        }
        $fileIjazah = $request->file('file_ijazah');
        $fileTranskip = $request->file('file_transkip');
        if ($fileIjazah) {
            try {
                $this->fileUploadService->validateFileForUpload($fileIjazah);
            } catch (InvalidArgumentException $e) {
                return $this->responseService->errorResponse($e->getMessage(), 422);
            }
        }
        if ($fileTranskip) {
            try {
                $this->fileUploadService->validateFileForUpload($fileTranskip);
            } catch (InvalidArgumentException $e) {
                return $this->responseService->errorResponse($e->getMessage(), 422);
            }
        }
        return $this->transactionService->handleWithTransaction(function () use ($request, $idSdm, $fileIjazah, $fileTranskip) {
            $payload = $request->only([
                'id_jenjang_pendidikan', 'nama_sekolah', 'negara', 'status_sekolah', 'jurusan', 'nomor_induk',
                'tahun_masuk', 'tahun_lulus', 'gelar_akademik', 'bidang_studi', 'ipk', 'tanggal_lulus',
                'jumlah_semester', 'jumlah_sks', 'nomor_ijazah', 'judul_tugas_akhir', 'sumber_biaya', 'nama_pembimbing',
            ]);
            $payload['id_sdm'] = $idSdm;
            $data = $this->sdmRiwayatPendidikanService->create($payload);
            if ($fileIjazah) {
                $uploadResult = $this->sdmRiwayatPendidikanService->handleFileUpload($fileIjazah, $idSdm, 'ijazah');
                $data->update([
                    'file_ijazah' => $uploadResult['file_name'],
                ]);
            }
            if ($fileTranskip) {
                $uploadResult = $this->sdmRiwayatPendidikanService->handleFileUpload($fileTranskip, $idSdm, 'transkip');
                $data->update([
                    'file_transkip' => $uploadResult['file_name'],
                ]);
            }
            return $this->responseService->successResponse('Data berhasil dibuat', $data, 201);
        });
    }

    public function update(SdmRiwayatPendidikanUpdateRequest $request, string $id): JsonResponse
    {
        $data = $this->sdmRiwayatPendidikanService->findById($id);
        if (!$data) {
            return $this->responseService->errorResponse('Data tidak ditemukan');
        }
        $fileIjazah = $request->file('file_ijazah');
        $fileTranskip = $request->file('file_transkip');
        if ($fileIjazah) {
            try {
                $this->fileUploadService->validateFileForUpload($fileIjazah);
            } catch (InvalidArgumentException$e) {
                return $this->responseService->errorResponse($e->getMessage(), 422);
            }
        }
        if ($fileTranskip) {
            try {
                $this->fileUploadService->validateFileForUpload($fileTranskip);
            } catch (InvalidArgumentException $e) {
                return $this->responseService->errorResponse($e->getMessage(), 422);
            }
        }
        return $this->transactionService->handleWithTransaction(function () use ($request, $data, $fileIjazah, $fileTranskip) {
            $payload = $request->only([
                'id_jenjang_pendidikan', 'nama_sekolah', 'negara', 'status_sekolah', 'jurusan', 'nomor_induk',
                'tahun_masuk', 'tahun_lulus', 'gelar_akademik', 'bidang_studi', 'ipk', 'tanggal_lulus',
                'jumlah_semester', 'jumlah_sks', 'nomor_ijazah', 'judul_tugas_akhir', 'sumber_biaya', 'nama_pembimbing',
            ]);
            $updatedData = $this->sdmRiwayatPendidikanService->update($data, $payload);
            if ($fileIjazah) {
                $uploadResult = $this->sdmRiwayatPendidikanService->updateFileUpload(
                    $fileIjazah,
                    $data->file_ijazah,
                    $data->id_sdm,
                    'ijazah'
                );
                $updatedData->update([
                    'file_ijazah' => $uploadResult['file_name'],
                ]);
            }
            if ($fileTranskip) {
                $uploadResult = $this->sdmRiwayatPendidikanService->updateFileUpload(
                    $fileTranskip,
                    $data->file_transkip,
                    $data->id_sdm,
                    'transkip'
                );
                $updatedData->update([
                    'file_transkip' => $uploadResult['file_name'],
                ]);
            }
            return $this->responseService->successResponse('Data berhasil diperbarui', $updatedData);
        });
    }

    public function show(string $id): JsonResponse
    {
        return $this->transactionService->handleWithShow(function () use ($id) {
            $data = $this->sdmRiwayatPendidikanService->getDetailData($id);

            return $this->responseService->successResponse('Data berhasil diambil', $data);
        });
    }

    public function destroy(string $id): JsonResponse
    {
        $data = $this->sdmRiwayatPendidikanService->findById($id);
        if (!$data) {
            return $this->responseService->errorResponse('Data tidak ditemukan');
        }

        return $this->transactionService->handleWithTransaction(function () use ($data) {
            $this->sdmRiwayatPendidikanService->delete($data);

            return $this->responseService->successResponse('Data berhasil dihapus');
        });
    }
}
