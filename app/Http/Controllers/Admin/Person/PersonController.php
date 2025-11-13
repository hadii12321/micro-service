<?php

namespace App\Http\Controllers\Admin\Person;

use App\Http\Controllers\Controller;
use App\Http\Requests\Person\PersonStoreRequest;
use App\Http\Requests\Person\PersonUpdateRequest;
use App\Services\Person\PersonService;
use App\Services\Tools\ResponseService;
use App\Services\Tools\TransactionService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Exception;
use Illuminate\Database\QueryException;

final class PersonController extends Controller
{
    public function __construct(
        private readonly PersonService      $personService,
        private readonly TransactionService $transactionService,
        private readonly ResponseService    $responseService,
    )
    {
    }

    public function index(): View
    {
        return view('admin.person.index');
    }

    public function list(): JsonResponse
    {
        return $this->transactionService->handleWithDataTable(
            fn() => $this->personService->getListData(),
            [
                'action' => fn($row) => implode(' ', [
                    $this->transactionService->actionButton($row->id_person, 'detail'),
                    $this->transactionService->actionButton($row->id_person, 'edit'),
                    $this->transactionService->actionButton($row->id_person, 'delete'),
                ]),
            ]
        );
    }

    public function listApi(): JsonResponse
    {
        return $this->transactionService->handleWithDataTable(
            fn() => $this->personService->getListData()
        );
    }

    public function store(PersonStoreRequest $request): JsonResponse
    {
        $foto = $request->file('foto');

        // MANUAL TRANSACTION IMPLEMENTATION
        DB::beginTransaction(); // EXPLICIT BEGIN TRANSACTION

        try {
            $payload = $request->only([
                'nama',
                'jk',
                'tempat_lahir',
                'tanggal_lahir',
                'kewarganegaraan',
                'golongan_darah',
                'nik',
                'nomor_kk',
                'alamat',
                'rt',
                'rw',
                'id_desa',
                'npwp',
                'nomor_hp',
                'email',
            ]);

            $created = $this->personService->create($payload);

            if ($foto) {
                $uploadResult = $this->personService->handleFileUpload($foto);
                if ($uploadResult) {
                    $created->update(['foto' => $uploadResult['file_name']]);
                }
            }

            DB::commit(); // EXPLICIT COMMIT

            return $this->responseService->successResponse('Data berhasil dibuat', $created, 201);

        } catch (QueryException $e) {
            DB::rollBack(); // EXPLICIT ROLLBACK
            
            return $this->responseService->errorResponse(
                'Terjadi kesalahan database: ' . $e->getMessage(), 
                500
            );
        } catch (Exception $e) {
            DB::rollBack(); // EXPLICIT ROLLBACK
            
            return $this->responseService->errorResponse(
                'Terjadi kesalahan: ' . $e->getMessage(), 
                500
            );
        }
    }

    public function update(PersonUpdateRequest $request, string $id): JsonResponse
    {
        $data = $this->personService->findById($id);
        if (!$data) {
            return $this->responseService->errorResponse('Data tidak ditemukan', 404);
        }

        $foto = $request->file('foto');

        // MANUAL TRANSACTION IMPLEMENTATION
        DB::beginTransaction(); // EXPLICIT BEGIN TRANSACTION

        try {
            $payload = $request->only([
                'nama',
                'jk',
                'tempat_lahir',
                'tanggal_lahir',
                'kewarganegaraan',
                'golongan_darah',
                'nik',
                'nomor_kk',
                'alamat',
                'rt',
                'rw',
                'id_desa',
                'npwp',
                'nomor_hp',
                'email',
            ]);

            $updatedData = $this->personService->update($data, $payload);

            if ($foto) {
                $uploadResult = $this->personService->handleFileUpload($foto, $updatedData);
                if ($uploadResult) {
                    $updatedData->update(['foto' => $uploadResult['file_name']]);
                }
            }

            DB::commit(); // EXPLICIT COMMIT

            return $this->responseService->successResponse('Data berhasil diperbarui', $updatedData);

        } catch (QueryException $e) {
            DB::rollBack(); // EXPLICIT ROLLBACK
            
            return $this->responseService->errorResponse(
                'Terjadi kesalahan database: ' . $e->getMessage(), 
                500
            );
        } catch (Exception $e) {
            DB::rollBack(); // EXPLICIT ROLLBACK
            
            return $this->responseService->errorResponse(
                'Terjadi kesalahan: ' . $e->getMessage(), 
                500
            );
        }
    }

    public function show(string $id): JsonResponse
    {
        return $this->transactionService->handleWithShow(function () use ($id) {
            $data = $this->personService->getDetailData($id);

            if (!$data) {
                return $this->responseService->errorResponse('Data tidak ditemukan', 404);
            }

            return $this->responseService->successResponse('Data berhasil diambil', $data);
        });
    }

    public function destroy(string $id): JsonResponse
    {
        $data = $this->personService->findById($id);
        if (!$data) {
            return $this->responseService->errorResponse('Data tidak ditemukan', 404);
        }

        // MANUAL TRANSACTION IMPLEMENTATION
        DB::beginTransaction(); // EXPLICIT BEGIN TRANSACTION

        try {
            // Jika ada file foto, handle delete file melalui FileUploadService
            if ($data->foto) {
                // Anda perlu menambahkan method deleteFile di PersonService atau FileUploadService
                // $this->personService->deleteFile($data->foto);
            }

            $data->delete();

            DB::commit(); // EXPLICIT COMMIT

            return $this->responseService->successResponse('Data berhasil dihapus');

        } catch (QueryException $e) {
            DB::rollBack(); // EXPLICIT ROLLBACK
            
            return $this->responseService->errorResponse(
                'Terjadi kesalahan database: ' . $e->getMessage(), 
                500
            );
        } catch (Exception $e) {
            DB::rollBack(); // EXPLICIT ROLLBACK
            
            return $this->responseService->errorResponse(
                'Terjadi kesalahan: ' . $e->getMessage(), 
                500
            );
        }
    }

    public function findByNik(Request $request): JsonResponse
    {
        $request->validate([
            'nik' => 'required|string|max:16'
        ]);

        return $this->transactionService->handleWithShow(function () use ($request) {
            $person = $this->personService->findByNik($request->nik);

            if (!$person) {
                return $this->responseService->errorResponse('Data dengan NIK tersebut tidak ditemukan', 404);
            }

            return $this->responseService->successResponse('Data berhasil ditemukan', $person);
        });
    }

    public function getByUuid(string $uuid): JsonResponse
    {
        return $this->transactionService->handleWithShow(function () use ($uuid) {
            $person = $this->personService->getPersonDetailByUuid($uuid);

            if (!$person) {
                return $this->responseService->errorResponse('Data tidak ditemukan', 404);
            }

            return $this->responseService->successResponse('Data berhasil diambil', $person);
        });
    }
}