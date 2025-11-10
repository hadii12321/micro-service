<?php

namespace App\Services\Master;

use App\Models\Master\MasterUnit;
use Illuminate\Support\Collection;

final class MasterUnitService
{
    public function getListData(): Collection
    {
        return MasterUnit::all();
    }

    public function create(array $data): MasterUnit
    {
        return MasterUnit::create($data);
    }

    public function getDetailData(string $id): ?MasterUnit
    {
        return MasterUnit::query()->where('master_unit.id_unit', $id)->first();
    }

    public function findById(string $id): ?MasterUnit
    {
        return MasterUnit::find($id);
    }

    public function update(MasterUnit $unit, array $data): MasterUnit
    {
        $unit->update($data);

        return $unit;
    }
}
