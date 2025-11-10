<?php

namespace App\Http\Controllers\Admin\Sdm;

use App\Http\Controllers\Controller;
use App\Http\Requests\Sdm\SdmRekeningStoreRequest;
use App\Http\Requests\Sdm\SdmRekeningUpdateRequest;
use App\Services\Sdm\SdmRekeningService;
use App\Services\Tools\ResponseService;
use App\Services\Tools\TransactionService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

final class SdmRekeningController extends Controller
{
    public function __construct(
        private readonly SdmRekeningService $sdmRekeningService,
        private readonly TransactionService $transactionService,
        private readonly ResponseService    $responseService,
    )
    {
    }

    public function index(string $uuid): View
    {
        $person = $this->sdmRekeningService->getPersonDetailByUuid($uuid);

        return view('admin.sdm.rekening.index', ['person' => $person, 'id' => $uuid]);
    }

    public function list(string $uuid, Request $request): JsonResponse
    {
        return $this->transactionService->handleWithDataTable(
            function () use ($uuid, $request) {
                return $this->sdmRekeningService->getListData($uuid, $request);
            },
            [
                'action' => fn($row) => implode(' ', [
                    $this->transactionService->actionButton($row->id_rekening, 'detail'),
                    $this->transactionService->actionButton($row->id_rekening, 'edit'),
                    $this->transactionService->actionButton($row->id_rekening, 'delete'),
                ]),
            ]
        );
    }

    public function listApi(string $uuid, Request $request): JsonResponse
    {
        return $this->transactionService->handleWithDataTable(
            function () use ($uuid, $request) {
                return $this->sdmRekeningService->getListData($uuid, $request);
            }
        );
    }

    public function store(SdmRekeningStoreRequest $request): JsonResponse
    {
        $idSdm = $this->sdmRekeningService->resolveIdSdmFromUuid($request->uuid_person);
        if (!$idSdm) {
            return $this->responseService->errorResponse('SDM tidak ditemukan');
        }
        if ($this->sdmRekeningService->checkDuplicate($idSdm, $request->no_rekening)) {
            return $this->responseService->errorResponse('Nomor rekening sudah ada untuk SDM ini.', 422);
        }
        return $this->transactionService->handleWithTransaction(function () use ($request, $idSdm) {
            $payload = $request->only([
                'no_rekening', 'bank', 'nama_pemilik', 'kode_bank', 'cabang_bank',
                'rekening_utama', 'jenis_rekening', 'status_aktif',
            ]);
            $payload['id_sdm'] = $idSdm;
            $payload['rekening_utama'] = ($payload['rekening_utama'] ?? 'n') === 'y' ? 'y' : 'n';
            $payload['jenis_rekening'] = $payload['jenis_rekening'] ?? 'Tabungan';
            $payload['status_aktif'] = $payload['status_aktif'] ?? 'Aktif';
            if ($payload['rekening_utama'] === 'y') {
                $this->sdmRekeningService->unsetOtherMainAccounts($idSdm);
            }
            $data = $this->sdmRekeningService->create($payload);
            return $this->responseService->successResponse('Data berhasil dibuat', $data, 201);
        });
    }

    public function update(SdmRekeningUpdateRequest $request, string $id): JsonResponse
    {
        $data = $this->sdmRekeningService->findById($id);
        if (!$data) {
            return $this->responseService->errorResponse('Data tidak ditemukan');
        }
        if ($request->filled('no_rekening')) {
            if ($this->sdmRekeningService->checkDuplicateForUpdate($data, $request->no_rekening)) {
                return $this->responseService->errorResponse('Nomor rekening sudah ada untuk SDM ini.', 422);
            }
        }
        return $this->transactionService->handleWithTransaction(function () use ($request, $data) {
            $payload = $request->only([
                'no_rekening', 'bank', 'nama_pemilik', 'kode_bank', 'cabang_bank',
                'rekening_utama', 'jenis_rekening', 'status_aktif',
            ]);
            if (array_key_exists('rekening_utama', $payload) && $payload['rekening_utama'] === 'y') {
                $this->sdmRekeningService->unsetOtherMainAccounts($data->id_sdm, $data->id_rekening);
            }
            $updatedData = $this->sdmRekeningService->update($data, $payload);
            return $this->responseService->successResponse('Data berhasil diperbarui', $updatedData);
        });
    }

    public function show(string $id): JsonResponse
    {
        return $this->transactionService->handleWithShow(function () use ($id) {
            $data = $this->sdmRekeningService->getDetailData($id);

            return $this->responseService->successResponse('Data berhasil diambil', $data);
        });
    }

    public function destroy(string $id): JsonResponse
    {
        $data = $this->sdmRekeningService->findById($id);
        if (!$data) {
            return $this->responseService->errorResponse('Data tidak ditemukan');
        }

        return $this->transactionService->handleWithTransaction(function () use ($data) {
            $this->sdmRekeningService->delete($data);

            return $this->responseService->successResponse('Data berhasil dihapus');
        });
    }
}
