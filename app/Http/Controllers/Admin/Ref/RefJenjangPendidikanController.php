<?php

namespace App\Http\Controllers\Admin\Ref;

use App\Http\Controllers\Controller;
use App\Http\Requests\Ref\RefJenjangPendidikanRequest;
use App\Services\Ref\RefJenjangPendidikanService;
use App\Services\Tools\ResponseService;
use App\Services\Tools\TransactionService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;

final class RefJenjangPendidikanController extends Controller
{
    public function __construct(
        private readonly RefJenjangPendidikanService $refJenjangPendidikanService,
        private readonly TransactionService          $transactionService,
        private readonly ResponseService             $responseService,
    )
    {
    }

    public function index(): View
    {
        return view('admin.ref.jenjang_pendidikan.index');
    }

    public function list(): JsonResponse
    {
        return $this->transactionService->handleWithDataTable(
            function () {
                return $this->refJenjangPendidikanService->getListData();
            },
            [
                'action' => function ($row) {
                    $rowId = $row->id_jenjang_pendidikan;

                    return implode(' ', [
                        $this->transactionService->actionButton($rowId, 'detail'),
                        $this->transactionService->actionButton($rowId, 'edit'),
                    ]);
                },
            ]
        );
    }

    public function store(RefJenjangPendidikanRequest $request): JsonResponse
    {
        return $this->transactionService->handleWithTransaction(function () use ($request) {
            $data = $this->refJenjangPendidikanService->create($request->only([
                'jenjang_pendidikan',
            ]));
            return $this->responseService->successResponse('Data berhasil dibuat', $data, 201);
        });
    }

    public function show(string $id): JsonResponse
    {
        return $this->transactionService->handleWithShow(function () use ($id) {
            $data = $this->refJenjangPendidikanService->getDetailData($id);

            return $this->responseService->successResponse('Data berhasil diambil', $data);
        });
    }

    public function update(RefJenjangPendidikanRequest $request, string $id): JsonResponse
    {
        $data = $this->refJenjangPendidikanService->findById($id);
        if (!$data) {
            return $this->responseService->errorResponse('Data tidak ditemukan');
        }
        return $this->transactionService->handleWithTransaction(function () use ($request, $data) {
            $updatedData = $this->refJenjangPendidikanService->update($data, $request->only([
                'jenjang_pendidikan',
            ]));
            return $this->responseService->successResponse('Data berhasil diperbarui', $updatedData);
        });
    }

    public function destroy(string $id): JsonResponse
    {
        $data = $this->refJenjangPendidikanService->findById($id);
        if (!$data) {
            return $this->responseService->errorResponse('Data tidak ditemukan');
        }

        return $this->transactionService->handleWithTransaction(function () use ($data) {
            $this->refJenjangPendidikanService->delete($data);

            return $this->responseService->successResponse('Data berhasil dihapus');
        });
    }
}
