<?php

namespace App\Http\Controllers\Admin\Ref;

use App\Http\Controllers\Controller;
use App\Http\Requests\Ref\RefHubunganKeluargaRequest;
use App\Services\Ref\RefHubunganKeluargaService;
use App\Services\Tools\ResponseService;
use App\Services\Tools\TransactionService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;

final class RefHubunganKeluargaController extends Controller
{
    public function __construct(
        private readonly RefHubunganKeluargaService $refHubunganKeluargaService,
        private readonly TransactionService         $transactionService,
        private readonly ResponseService            $responseService,
    )
    {
    }

    public function index(): View
    {
        return view('admin.ref.hubungan_keluarga.index');
    }

    public function list(): JsonResponse
    {
        return $this->transactionService->handleWithDataTable(
            function () {
                return $this->refHubunganKeluargaService->getListData();
            },
            [
                'action' => function ($row) {
                    $rowId = $row->id_hubungan_keluarga;

                    return implode(' ', [
                        $this->transactionService->actionButton($rowId, 'detail'),
                        $this->transactionService->actionButton($rowId, 'edit'),
                    ]);
                },
            ]
        );
    }

    public function store(RefHubunganKeluargaRequest $request): JsonResponse
    {
        return $this->transactionService->handleWithTransaction(function () use ($request) {
            $data = $this->refHubunganKeluargaService->create($request->only([
                'hubungan_keluarga',
                'jk',
            ]));
            return $this->responseService->successResponse('Data berhasil dibuat', $data, 201);
        });
    }

    public function show(string $id): JsonResponse
    {
        return $this->transactionService->handleWithShow(function () use ($id) {
            $data = $this->refHubunganKeluargaService->getDetailData($id);

            return $this->responseService->successResponse('Data berhasil diambil', $data);
        });
    }

    public function update(RefHubunganKeluargaRequest $request, string $id): JsonResponse
    {
        $data = $this->refHubunganKeluargaService->findById($id);
        if (!$data) {
            return $this->responseService->errorResponse('Data tidak ditemukan');
        }
        return $this->transactionService->handleWithTransaction(function () use ($request, $data) {
            $updatedData = $this->refHubunganKeluargaService->update($data, $request->only([
                'hubungan_keluarga',
                'jk',
            ]));
            return $this->responseService->successResponse('Data berhasil diperbarui', $updatedData);
        });
    }

    public function destroy(string $id): JsonResponse
    {
        $data = $this->refHubunganKeluargaService->findById($id);
        if (!$data) {
            return $this->responseService->errorResponse('Data tidak ditemukan');
        }

        return $this->transactionService->handleWithTransaction(function () use ($data) {
            $this->refHubunganKeluargaService->delete($data);

            return $this->responseService->successResponse('Data berhasil dihapus');
        });
    }
}
