<?php

namespace App\Http\Controllers\Admin\Ref;

use App\Http\Controllers\Controller;
use App\Http\Requests\Ref\RefEselonRequest;
use App\Services\Ref\RefEselonService;
use App\Services\Tools\ResponseService;
use App\Services\Tools\TransactionService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;

final class RefEselonController extends Controller
{
    public function __construct(
        private readonly RefEselonService   $refEselonService,
        private readonly TransactionService $transactionService,
        private readonly ResponseService    $responseService,
    )
    {
    }

    public function index(): View
    {
        return view('admin.ref.eselon.index');
    }

    public function list(): JsonResponse
    {
        return $this->transactionService->handleWithDataTable(
            function () {
                return $this->refEselonService->getListData();
            },
            [
                'action' => function ($row) {
                    $rowId = $row->id_eselon;

                    return implode(' ', [
                        $this->transactionService->actionButton($rowId, 'detail'),
                        $this->transactionService->actionButton($rowId, 'edit'),
                    ]);
                },
            ]
        );
    }

    public function store(RefEselonRequest $request): JsonResponse
    {
        return $this->transactionService->handleWithTransaction(function () use ($request) {
            $data = $this->refEselonService->create($request->only([
                'eselon',
            ]));
            return $this->responseService->successResponse('Data berhasil dibuat', $data, 201);
        });
    }

    public function show(string $id): JsonResponse
    {
        return $this->transactionService->handleWithShow(function () use ($id) {
            $data = $this->refEselonService->getDetailData($id);

            return $this->responseService->successResponse('Data berhasil diambil', $data);
        });
    }

    public function update(RefEselonRequest $request, string $id): JsonResponse
    {
        $data = $this->refEselonService->findById($id);
        if (!$data) {
            return $this->responseService->errorResponse('Data tidak ditemukan');
        }
        return $this->transactionService->handleWithTransaction(function () use ($request, $data) {
            $updatedData = $this->refEselonService->update($data, $request->only([
                'eselon',
            ]));
            return $this->responseService->successResponse('Data berhasil diperbarui', $updatedData);
        });
    }

    public function destroy(string $id): JsonResponse
    {
        $data = $this->refEselonService->findById($id);
        if (!$data) {
            return $this->responseService->errorResponse('Data tidak ditemukan');
        }

        return $this->transactionService->handleWithTransaction(function () use ($data) {
            $this->refEselonService->delete($data);

            return $this->responseService->successResponse('Data berhasil dihapus');
        });
    }
}
