<?php

namespace App\Http\Controllers\Admin\Person;

use App\Http\Controllers\Controller;
use App\Http\Requests\Person\PersonAsuransiStoreRequest;
use App\Http\Requests\Person\PersonAsuransiUpdateRequest;
use App\Services\Person\PersonAsuransiService;
use App\Services\Tools\ResponseService;
use App\Services\Tools\TransactionService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

final class PersonAsuransiController extends Controller
{
    public function __construct(
        private readonly PersonAsuransiService $personAsuransiService,
        private readonly TransactionService    $transactionService,
        private readonly ResponseService       $responseService,
    )
    {
    }

    public function index(string $uuid): View
    {
        $person = $this->personAsuransiService->getPersonDetailByUuid($uuid);

        return view('admin.sdm.asuransi.index', ['person' => $person, 'id' => $uuid]);
    }

    public function list(string $uuid, Request $request): JsonResponse
    {
        return $this->transactionService->handleWithDataTable(
            function () use ($uuid, $request) {
                return $this->personAsuransiService->getListData($uuid, $request);
            },
            [
                'action' => fn($row) => implode(' ', [
                    $this->transactionService->actionButton($row->id_person_asuransi, 'detail'),
                    $this->transactionService->actionButton($row->id_person_asuransi, 'edit'),
                    $this->transactionService->actionButton($row->id_person_asuransi, 'delete'),
                ]),
            ]
        );
    }

    public function listApi(string $uuid, Request $request): JsonResponse
    {
        return $this->transactionService->handleWithDataTable(
            function () use ($uuid, $request) {
                return $this->personAsuransiService->getListData($uuid, $request);
            }
        );
    }

    public function store(PersonAsuransiStoreRequest $request): JsonResponse
    {
        $idPerson = $this->personAsuransiService->resolvePersonId($request->id_person ?? null, $request->uuid_person ?? null);
        if (!$idPerson) {
            return $this->responseService->errorResponse('Person tidak ditemukan', 404);
        }

        $status = $request->input('status_aktif', 'Aktif');

        if ($status === 'Aktif') {
            if ($this->personAsuransiService->checkActivePolisExists($idPerson, $request->id_jenis_asuransi)) {
                return $this->responseService->errorResponse('Sudah ada polis Aktif untuk jenis asuransi ini pada person tersebut.');
            }
        }

        return $this->transactionService->handleWithTransaction(function () use ($request, $idPerson, $status) {
            $payload = $request->only([
                'id_jenis_asuransi', 'nomor_registrasi', 'kartu_anggota',
                'tanggal_mulai', 'tanggal_berakhir', 'keterangan',
            ]);
            $payload['id_person'] = $idPerson;
            $payload['status_aktif'] = $status;

            $data = $this->personAsuransiService->create($payload);

            return $this->responseService->successResponse('Data berhasil dibuat', $data, 201);
        });
    }

    public function show(string $id): JsonResponse
    {
        return $this->transactionService->handleWithShow(function () use ($id) {
            $data = $this->personAsuransiService->getDetailData($id);

            return $this->responseService->successResponse('Data berhasil diambil', $data);
        });
    }

    public function update(PersonAsuransiUpdateRequest $request, string $id): JsonResponse
    {
        $data = $this->personAsuransiService->findById($id);
        if (!$data) {
            return $this->responseService->errorResponse('Data tidak ditemukan');
        }

        $nextJenis = $request->filled('id_jenis_asuransi') ? (int)$request->id_jenis_asuransi : $data->id_jenis_asuransi;
        $nextStatus = $request->input('status_aktif', $data->status_aktif);

        if ($nextStatus === 'Aktif') {
            if ($this->personAsuransiService->checkActivePolisExistsForUpdate($data, $nextJenis)) {
                return $this->responseService->errorResponse('Sudah ada polis Aktif untuk jenis asuransi ini pada person tersebut.');
            }
        }

        return $this->transactionService->handleWithTransaction(function () use ($request, $data) {
            $payload = $request->only([
                'id_jenis_asuransi', 'id_person', 'nomor_registrasi', 'kartu_anggota',
                'status_aktif', 'tanggal_mulai', 'tanggal_berakhir', 'keterangan',
            ]);
            $updatedData = $this->personAsuransiService->update($data, $payload);

            return $this->responseService->successResponse('Data berhasil diperbarui', $updatedData);
        });
    }

    public function destroy(string $id): JsonResponse
    {
        $data = $this->personAsuransiService->findById($id);
        if (!$data) {
            return $this->responseService->errorResponse('Data tidak ditemukan');
        }

        return $this->transactionService->handleWithTransaction(function () use ($data) {
            $this->personAsuransiService->delete($data);

            return $this->responseService->successResponse('Data berhasil dihapus');
        });
    }

    public function find_by_nik(string $nik): JsonResponse
    {
        return $this->transactionService->handleWithShow(function () use ($nik) {
            $data = $this->personAsuransiService->findByNik($nik);
            if (!$data) {
                return $this->responseService->errorResponse('Data tidak ditemukan');
            }

            return $this->responseService->successResponse('Data berhasil diambil', $data);
        });
    }
}
