<?php

namespace App\Http\Controllers\Admin\Sdm;

use App\Http\Controllers\Controller;
use App\Http\Requests\Sdm\SdmKeluargaStoreRequest;
use App\Http\Requests\Sdm\SdmKeluargaUpdateRequest;
use App\Services\Sdm\SdmKeluargaService;
use App\Services\Tools\ResponseService;
use App\Services\Tools\TransactionService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

final class SdmKeluargaController extends Controller
{
    public function __construct(
        private readonly SdmKeluargaService $sdmKeluargaService,
        private readonly TransactionService $transactionService,
        private readonly ResponseService    $responseService,
    )
    {
    }

    public function index(string $uuid): View
    {
        $person = $this->sdmKeluargaService->getPersonDetailByUuid($uuid);

        return view('admin.sdm.keluarga.index', ['person' => $person, 'id' => $uuid]);
    }

    public function list(string $uuid, Request $request): JsonResponse
    {
        return $this->transactionService->handleWithDataTable(
            function () use ($uuid, $request) {
                return $this->sdmKeluargaService->getListData($uuid, $request);
            },
            [
                'action' => fn($row) => implode(' ', [
                    $this->transactionService->actionButton($row->id_keluarga, 'detail'),
                    $this->transactionService->actionButton($row->id_keluarga, 'edit'),
                    $this->transactionService->actionButton($row->id_keluarga, 'delete'),
                ]),
            ]
        );
    }

    public function listApi(string $uuid, Request $request): JsonResponse
    {
        return $this->transactionService->handleWithDataTable(
            function () use ($uuid, $request) {
                return $this->sdmKeluargaService->getListData($uuid, $request);
            }
        );
    }

    public function store(SdmKeluargaStoreRequest $request): JsonResponse
    {
        $idSdm = $this->sdmKeluargaService->resolveIdSdmFromUuid($request->uuid_person);
        if (!$idSdm) {
            return $this->responseService->errorResponse('SDM tidak ditemukan');
        }
        if ($this->sdmKeluargaService->checkDuplicate($idSdm, $request->id_person)) {
            return $this->responseService->errorResponse('Anggota keluarga ini sudah terdaftar untuk SDM tersebut.', 422);
        }
        return $this->transactionService->handleWithTransaction(function () use ($request, $idSdm) {
            $payload = $request->only([
                'id_person', 'id_hubungan_keluarga', 'status_tanggungan',
                'pekerjaan', 'pendidikan_terakhir', 'penghasilan',
            ]);
            $payload['id_sdm'] = $idSdm;
            $data = $this->sdmKeluargaService->create($payload);
            return $this->responseService->successResponse('Data berhasil dibuat', $data, 201);
        });
    }

    public function show(string $id): JsonResponse
    {
        return $this->transactionService->handleWithShow(function () use ($id) {
            $data = $this->sdmKeluargaService->getDetailData($id);

            return $this->responseService->successResponse('Data berhasil diambil', $data);
        });
    }

    public function update(SdmKeluargaUpdateRequest $request, string $id): JsonResponse
    {
        $data = $this->sdmKeluargaService->findById($id);
        if (!$data) {
            return $this->responseService->errorResponse('Data tidak ditemukan');
        }
        if ($request->filled('id_person')) {
            if ($this->sdmKeluargaService->checkDuplicateForUpdate($data, $request->id_person)) {
                return $this->responseService->errorResponse('Anggota keluarga ini sudah terdaftar untuk SDM tersebut.', 422);
            }
        }
        return $this->transactionService->handleWithTransaction(function () use ($request, $data) {
            $payload = $request->only([
                'id_person', 'id_hubungan_keluarga', 'status_tanggungan',
                'pekerjaan', 'pendidikan_terakhir', 'penghasilan',
            ]);
            $updatedData = $this->sdmKeluargaService->update($data, $payload);
            return $this->responseService->successResponse('Data berhasil diperbarui', $updatedData);
        });
    }

    public function destroy(string $id): JsonResponse
    {
        $data = $this->sdmKeluargaService->findById($id);
        if (!$data) {
            return $this->responseService->errorResponse('Data tidak ditemukan');
        }

        return $this->transactionService->handleWithTransaction(function () use ($data) {
            $this->sdmKeluargaService->delete($data);

            return $this->responseService->successResponse('Data berhasil dihapus');
        });
    }

    public function find_by_nik(string $nik): JsonResponse
    {
        return $this->transactionService->handleWithShow(function () use ($nik) {
            $data = $this->sdmKeluargaService->findByNik($nik);
            if (!$data) {
                return $this->responseService->errorResponse('Data tidak ditemukan');
            }

            return $this->responseService->successResponse('Data berhasil diambil', $data);
        });
    }
}
