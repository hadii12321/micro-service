<?php

namespace App\Services\Master;

use App\Models\Master\MasterPeriode;
use Illuminate\Support\Collection;

final class MasterPeriodeService
{
    public function getListData(): Collection
    {
        return MasterPeriode::all();
    }

    public function getListDataOrdered(string $orderBy): Collection
    {
        return MasterPeriode::orderBy($orderBy)->get();
    }

    public function create(array $data): MasterPeriode
    {
        return MasterPeriode::create($data);
    }

    public function getDetailData(string $id): ?MasterPeriode
    {
        return MasterPeriode::find($id);
    }

    public function findById(string $id): ?MasterPeriode
    {
        return MasterPeriode::find($id);
    }

    public function update(MasterPeriode $periode, array $data): MasterPeriode
    {
        $periode->update($data);

        return $periode;
    }

    public function delete(MasterPeriode $periode): void
    {
        $periode->delete();
    }
}
