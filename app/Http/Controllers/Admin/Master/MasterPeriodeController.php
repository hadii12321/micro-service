<?php

namespace App\Http\Controllers\Admin\Master;

use App\Http\Controllers\Controller;
use App\Http\Requests\Master\MasterPeriodeRequest;
use App\Services\Master\MasterPeriodeService;
use App\Services\Tools\ResponseService;
use App\Services\Tools\TransactionService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;

final class MasterPeriodeController extends Controller
{
    public function __construct(
        private readonly MasterPeriodeService $periodeService,
        private readonly TransactionService   $transactionService,
        private readonly ResponseService      $responseService,
    )
    {
    }

    public function index(): View
    {
        return view('admin.master.periode.index');
    }

    public function list(): JsonResponse
    {
        return $this->transactionService->handleWithDataTable(
            function () {
                return $this->periodeService->getListData();
            },
            [
                'action' => function ($row) {
                    $rowId = $row->id_periode;

                    return implode(' ', [
                        $this->transactionService->actionButton($rowId, 'detail'),
                        $this->transactionService->actionButton($rowId, 'edit'),
                    ]);
                },
            ]
        );
    }

    public function store(MasterPeriodeRequest $request): JsonResponse
    {
        return $this->transactionService->handleWithTransaction(function () use ($request) {
            $data = $this->periodeService->create($request->only([
                'periode',
                'tanggal_awal',
                'tanggal_akhir',
                'status',
            ]));
            return $this->responseService->successResponse('Data berhasil dibuat', $data, 201);
        });
    }

    public function show(string $id): JsonResponse
    {
        return $this->transactionService->handleWithShow(function () use ($id) {
            $data = $this->periodeService->getDetailData($id);

            return $this->responseService->successResponse('Data berhasil diambil', $data);
        });
    }

    public function update(MasterPeriodeRequest $request, string $id): JsonResponse
    {
        $data = $this->periodeService->findById($id);
        if (!$data) {
            return $this->responseService->errorResponse('Data tidak ditemukan');
        }
        return $this->transactionService->handleWithTransaction(function () use ($request, $data) {
            $updatedData = $this->periodeService->update($data, $request->only([
                'periode',
                'tanggal_awal',
                'tanggal_akhir',
                'status',
            ]));
            return $this->responseService->successResponse('Data berhasil diperbarui', $updatedData);
        });
    }
}
