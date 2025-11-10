<?php

namespace App\Services\Sdm;

use App\Models\Person\Person;
use App\Models\Sdm\PersonSdm;
use App\Models\Sdm\SdmKeluarga;
use App\Services\Person\PersonService;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

final readonly class SdmKeluargaService
{
    public function __construct(
        private PersonService $personService,
    )
    {
    }

    public function getPersonDetailByUuid(string $uuid): ?Person
    {
        return $this->personService->getPersonDetailByUuid($uuid);
    }

    public function getListData(string $uuid, Request $request): Collection
    {
        $idSdm = PersonSdm::query()
            ->join('person', 'person.id_person', '=', 'person_sdm.id_person')
            ->where('person.uuid_person', $uuid)
            ->value('person_sdm.id_sdm');

        if (!$idSdm) {
            return collect();
        }

        return SdmKeluarga::query()
            ->leftJoin('person as anggota', 'anggota.id_person', '=', 'sdm_keluarga.id_person')
            ->leftJoin('ref_hubungan_keluarga', 'ref_hubungan_keluarga.id_hubungan_keluarga', '=', 'sdm_keluarga.id_hubungan_keluarga')
            ->select([
                'sdm_keluarga.id_keluarga',
                'sdm_keluarga.id_sdm',
                'sdm_keluarga.id_person',
                'ref_hubungan_keluarga.hubungan_keluarga as hubungan',
                'sdm_keluarga.status_tanggungan',
                'sdm_keluarga.pekerjaan',
                'sdm_keluarga.pendidikan_terakhir',
                'sdm_keluarga.penghasilan',
                'anggota.nama as nama_anggota',
                'anggota.nik  as nik_anggota',
                'anggota.uuid_person as uuid_anggota',
            ])
            ->where('sdm_keluarga.id_sdm', $idSdm)
            ->when($request->query('id_hubungan_keluarga'), fn($q, $v) => $q->where('sdm_keluarga.id_hubungan_keluarga', $v))
            ->orderBy('anggota.nama')
            ->get();
    }

    public function create(array $data): SdmKeluarga
    {
        return SdmKeluarga::create($data);
    }

    public function getDetailData(string $id): ?SdmKeluarga
    {
        return SdmKeluarga::query()
            ->leftJoin('person as anggota', 'anggota.id_person', '=', 'sdm_keluarga.id_person')
            ->leftJoin('ref_hubungan_keluarga', 'ref_hubungan_keluarga.id_hubungan_keluarga', '=', 'sdm_keluarga.id_hubungan_keluarga')
            ->select([
                'sdm_keluarga.*',
                'anggota.nama as nama_anggota',
                'anggota.nik  as nik_anggota',
                'anggota.uuid_person as uuid_anggota',
                'ref_hubungan_keluarga.hubungan_keluarga as hubungan',
            ])
            ->where('sdm_keluarga.id_keluarga', $id)
            ->first();
    }

    public function findById(string $id): ?SdmKeluarga
    {
        return SdmKeluarga::find($id);
    }

    public function update(SdmKeluarga $keluarga, array $data): SdmKeluarga
    {
        $keluarga->update($data);

        return $keluarga;
    }

    public function delete(SdmKeluarga $keluarga): void
    {
        $keluarga->delete();
    }

    public function resolveIdSdmFromUuid(string $uuid): ?int
    {
        return PersonSdm::query()
            ->join('person', 'person.id_person', '=', 'person_sdm.id_person')
            ->where('person.uuid_person', $uuid)
            ->value('person_sdm.id_sdm');
    }

    public function checkDuplicate(int $idSdm, int $idPerson): bool
    {
        return SdmKeluarga::where('id_sdm', $idSdm)
            ->where('id_person', $idPerson)
            ->exists();
    }

    public function checkDuplicateForUpdate(SdmKeluarga $keluarga, int $idPerson): bool
    {
        return SdmKeluarga::where('id_sdm', $keluarga->id_sdm)
            ->where('id_person', $idPerson)
            ->where('id_keluarga', '!=', $keluarga->id_keluarga)
            ->exists();
    }

    public function findByNik(string $nik): ?Person
    {
        return $this->personService->findByNik($nik);
    }
}
