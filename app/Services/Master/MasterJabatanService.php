<?php

namespace App\Services\Master;

use App\Models\Master\MasterJabatan;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

final class MasterJabatanService
{
    public function getListData(Request $request): Collection
    {
        return MasterJabatan::query()
            ->leftJoin('master_unit', 'master_jabatan.id_unit', '=', 'master_unit.id_unit')
            ->leftJoin('ref_eselon', 'master_jabatan.id_eselon', '=', 'ref_eselon.id_eselon')
            ->leftJoin('master_periode', 'master_jabatan.id_periode', '=', 'master_periode.id_periode')
            ->select([
                'master_jabatan.*',
                'master_unit.unit',
                'master_periode.periode',
                'ref_eselon.eselon',
                'master_unit.singkatan as unit_singkatan',
            ])
            ->when($request->query('id_unit'), function ($query, $id_unit) {
                $query->where('master_jabatan.id_unit', $id_unit);
            })
            ->get();
    }

    public function create(array $data): MasterJabatan
    {
        return MasterJabatan::create($data);
    }

    public function getDetailData(string $id): ?MasterJabatan
    {
        return MasterJabatan::query()
            ->leftJoin('master_unit', 'master_jabatan.id_unit', '=', 'master_unit.id_unit')
            ->leftJoin('ref_eselon', 'master_jabatan.id_eselon', '=', 'ref_eselon.id_eselon')
            ->leftJoin('master_periode', 'master_jabatan.id_periode', '=', 'master_periode.id_periode')
            ->select([
                'master_jabatan.*',
                'master_unit.unit',
                'master_periode.periode',
                'ref_eselon.eselon',
                'master_unit.singkatan as unit_singkatan',
            ])
            ->where('master_jabatan.id_jabatan', $id)
            ->first();
    }

    public function findById(string $id): ?MasterJabatan
    {
        return MasterJabatan::find($id);
    }

    public function update(MasterJabatan $jabatan, array $data): MasterJabatan
    {
        $jabatan->update($data);

        return $jabatan;
    }

    public function getApiData(Request $request): Collection
    {
        return MasterJabatan::query()
            ->leftJoin('master_unit', 'master_jabatan.id_unit', '=', 'master_unit.id_unit')
            ->leftJoin('master_periode', 'master_jabatan.id_periode', '=', 'master_periode.id_periode')
            ->select([
                'master_jabatan.id_jabatan',
                'master_jabatan.id_unit',
                'master_jabatan.jabatan',
                'master_unit.unit',
                'master_unit.singkatan as unit_singkatan',
            ])
            ->where('master_periode.status','active')
            ->orderBy('master_jabatan.id_jabatan', 'desc')
            ->when($request->query('id_unit'), function ($query, $id_unit) {
                $query->where('master_jabatan.id_unit', $id_unit);
            })
            ->when($request->query('id_periode'), function ($query, $id_periode) {
                $query->where('master_jabatan.id_periode', $id_periode);
            })
            ->when($request->query('id_eselon'), function ($query, $id_eselon) {
                $query->where('master_jabatan.id_eselon', $id_eselon);
            })
            ->get();
    }
}
