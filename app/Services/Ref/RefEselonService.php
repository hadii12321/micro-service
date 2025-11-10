<?php

namespace App\Services\Ref;

use App\Models\Ref\RefEselon;
use Illuminate\Support\Collection;

final class RefEselonService
{
    public function getListData(): Collection
    {
        return RefEselon::all();
    }

    public function getListDataOrdered(string $orderBy): Collection
    {
        return RefEselon::orderBy($orderBy)->get();
    }

    public function create(array $data): RefEselon
    {
        return RefEselon::create($data);
    }

    public function getDetailData(string $id): ?RefEselon
    {
        return RefEselon::find($id);
    }

    public function findById(string $id): ?RefEselon
    {
        return RefEselon::find($id);
    }

    public function update(RefEselon $eselon, array $data): RefEselon
    {
        $eselon->update($data);

        return $eselon;
    }

    public function delete(RefEselon $eselon): void
    {
        $eselon->delete();
    }
}
