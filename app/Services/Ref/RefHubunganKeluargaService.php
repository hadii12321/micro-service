<?php

namespace App\Services\Ref;

use App\Models\Ref\RefHubunganKeluarga;
use Illuminate\Support\Collection;

final class RefHubunganKeluargaService
{
    public function getListData(): Collection
    {
        return RefHubunganKeluarga::all();
    }

    public function getListDataOrdered(string $orderBy): Collection
    {
        return RefHubunganKeluarga::orderBy($orderBy)->get();
    }

    public function create(array $data): RefHubunganKeluarga
    {
        return RefHubunganKeluarga::create($data);
    }

    public function getDetailData(string $id): ?RefHubunganKeluarga
    {
        return RefHubunganKeluarga::find($id);

    }

    public function findById(string $id): ?RefHubunganKeluarga
    {
        return RefHubunganKeluarga::find($id);
    }

    public function update(RefHubunganKeluarga $hubunganKeluarga, array $data): RefHubunganKeluarga
    {
        $hubunganKeluarga->update($data);

        return $hubunganKeluarga;
    }

    public function delete(RefHubunganKeluarga $hubunganKeluarga): void
    {
        $hubunganKeluarga->delete();
    }
}
