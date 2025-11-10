<?php

namespace App\Services\Ref;

use App\Models\Ref\RefAlmtDesa;
use App\Models\Ref\RefAlmtKabupaten;
use App\Models\Ref\RefAlmtKecamatan;
use App\Models\Ref\RefAlmtProvinsi;
use Illuminate\Support\Collection;

final class RefAlmtService
{
    public function getProvinsi(): Collection
    {
        return RefAlmtProvinsi::orderBy('id_provinsi')->get();
    }

    public function getKabupaten($id): Collection
    {
        return RefAlmtKabupaten::where('id_provinsi', $id)
            ->orderBy('id_kabupaten')
            ->get();
    }

    public function getKecamatan($id): Collection
    {
        return RefAlmtKecamatan::where('id_kabupaten', $id)
            ->orderBy('id_kecamatan')
            ->get();
    }

    public function getDesa($id): Collection
    {
        return RefAlmtDesa::where('id_kecamatan', $id)
            ->orderBy('id_desa')
            ->get();
    }
}
