<?php

namespace App\Services\Ref;

use App\Models\Ref\RefJenjangPendidikan;
use Illuminate\Support\Collection;

final class RefJenjangPendidikanService
{
    public function getListData(): Collection
    {
        return RefJenjangPendidikan::all();
    }

    public function getListDataOrdered(string $orderBy): Collection
    {
        return RefJenjangPendidikan::orderBy($orderBy)->get();
    }

    public function create(array $data): RefJenjangPendidikan
    {
        return RefJenjangPendidikan::create($data);
    }

    public function getDetailData(string $id): ?RefJenjangPendidikan
    {
        return RefJenjangPendidikan::find($id);
    }

    public function findById(string $id): ?RefJenjangPendidikan
    {
        return RefJenjangPendidikan::find($id);
    }

    public function update(RefJenjangPendidikan $jenjangPendidikan, array $data): RefJenjangPendidikan
    {
        $jenjangPendidikan->update($data);

        return $jenjangPendidikan;
    }

    public function delete(RefJenjangPendidikan $jenjangPendidikan): void
    {
        $jenjangPendidikan->delete();
    }

}
