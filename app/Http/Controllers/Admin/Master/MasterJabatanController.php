<?php

namespace App\Http\Controllers\Admin\Master;

use App\Http\Controllers\Controller;
use App\Http\Requests\Master\MasterJabatanRequest;
use App\Services\Master\MasterJabatanService;
use App\Services\Tools\ResponseService;
use App\Services\Tools\TransactionService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

final class MasterJabatanController extends Controller
{
    public function __construct(
        private readonly MasterJabatanService $jabatanService,
        private readonly TransactionService   $transactionService,
        private readonly ResponseService      $responseService,
    )
    {
    }

    public function index(): View
    {
        return view('admin.master.jabatan.index');
    }

    public function list(Request $request): JsonResponse
    {
        return $this->transactionService->handleWithDataTable(
            function () use ($request) {
                return $this->jabatanService->getListData($request);
            },
            [
                'action' => function ($row) {
                    $rowId = $row->id_jabatan;

                    return implode(' ', [
                        $this->transactionService->actionButton($rowId, 'detail'),
                        $this->transactionService->actionButton($rowId, 'edit'),
                    ]);
                },
            ]
        );
    }

    public function store(MasterJabatanRequest $request): JsonResponse
    {
        return $this->transactionService->handleWithTransaction(function () use ($request) {
            $data = $this->jabatanService->create($request->only([
                'jabatan',
                'id_unit',
                'id_periode',
                'id_eselon',
            ]));
            return $this->responseService->successResponse('Data berhasil dibuat', $data, 201);
        });
    }

    public function show(string $id): JsonResponse
    {
        return $this->transactionService->handleWithShow(function () use ($id) {
            $data = $this->jabatanService->getDetailData($id);

            return $this->responseService->successResponse('Data berhasil diambil', $data);
        });
    }

    public function update(MasterJabatanRequest $request, string $id): JsonResponse
    {
        $data = $this->jabatanService->findById($id);
        if (!$data) {
            return $this->responseService->errorResponse('Data tidak ditemukan');
        }

        return $this->transactionService->handleWithTransaction(function () use ($request, $data) {
            $updatedData = $this->jabatanService->update($data, $request->only([
                'jabatan',
                'id_unit',
                'id_periode',
                'id_eselon',
            ]));
            return $this->responseService->successResponse('Data berhasil diperbarui', $updatedData);
        });
    }
}
