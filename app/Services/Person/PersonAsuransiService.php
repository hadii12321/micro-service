<?php

namespace App\Services\Person;

use App\Models\Person\Person;
use App\Models\Person\PersonAsuransi;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

final readonly class PersonAsuransiService
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
        $nomorKK = Person::where('uuid_person', $uuid)->value('nomor_kk');

        if (!$nomorKK) {
            return collect();
        }

        return PersonAsuransi::query()
            ->leftJoin('person', 'person.id_person', '=', 'person_asuransi.id_person')
            ->leftJoin('ref_jenis_asuransi', 'ref_jenis_asuransi.id_jenis_asuransi', '=', 'person_asuransi.id_jenis_asuransi')
            ->select([
                'person_asuransi.id_person_asuransi',
                'person_asuransi.id_jenis_asuransi',
                'ref_jenis_asuransi.jenis_asuransi',
                'ref_jenis_asuransi.nama_produk',
                'person_asuransi.nomor_registrasi',
                'person_asuransi.kartu_anggota',
                'person_asuransi.status_aktif',
                'person_asuransi.tanggal_mulai',
                'person_asuransi.tanggal_berakhir',
                'person.id_person',
                'person.nama',
                'person.nik',
                'person.uuid_person',
            ])
            ->where(function ($q) use ($nomorKK, $uuid) {
                $q->where('person_asuransi.kartu_anggota', $nomorKK)
                    ->orWhere('person.uuid_person', $uuid);
            })
            ->when($request->query('id_jenis_asuransi'), fn($q, $v) => $q->where('person_asuransi.id_jenis_asuransi', $v))
            ->when($request->query('status'), fn($q, $v) => $q->where('person_asuransi.status_aktif', $v))
            ->orderBy('person.nama')
            ->get();
    }

    public function create(array $data): PersonAsuransi
    {
        return PersonAsuransi::create($data);
    }

    public function getDetailData(string $id): ?PersonAsuransi
    {
        return PersonAsuransi::query()
            ->leftJoin('person', 'person.id_person', '=', 'person_asuransi.id_person')
            ->leftJoin('ref_jenis_asuransi', 'ref_jenis_asuransi.id_jenis_asuransi', '=', 'person_asuransi.id_jenis_asuransi')
            ->select([
                'person_asuransi.*',
                'person.nama', 'person.nik', 'person.uuid_person',
                'ref_jenis_asuransi.jenis_asuransi', 'ref_jenis_asuransi.nama_produk',
            ])
            ->where('person_asuransi.id_person_asuransi', $id)
            ->first();
    }

    public function findById(string $id): ?PersonAsuransi
    {
        return PersonAsuransi::find($id);
    }

    public function update(PersonAsuransi $personAsuransi, array $data): PersonAsuransi
    {
        $personAsuransi->update($data);

        return $personAsuransi;
    }

    public function delete(PersonAsuransi $personAsuransi): bool
    {
        return $personAsuransi->delete();
    }

    public function resolvePersonId(?int $idPerson = null, ?string $uuid_person = null): ?int
    {
        if ($idPerson) {
            return $idPerson;
        }

        if ($uuid_person) {
            return Person::where('uuid_person', $uuid_person)->value('id_person');
        }
        return null;
    }

    public function checkActivePolisExists(int $idPerson, int $idJenisAsuransi): bool
    {
        return PersonAsuransi::where('id_person', $idPerson)
            ->where('id_jenis_asuransi', $idJenisAsuransi)
            ->where('status_aktif', 'Aktif')
            ->exists();
    }

    public function checkActivePolisExistsForUpdate(PersonAsuransi $personAsuransi, int $idJenisAsuransi): bool
    {
        return PersonAsuransi::where('id_person', $personAsuransi->id_person)
            ->where('id_jenis_asuransi', $idJenisAsuransi)
            ->where('status_aktif', 'Aktif')
            ->where('id_person_asuransi', '!=', $personAsuransi->id_person_asuransi)
            ->exists();
    }

    public function findByNik(string $nik): ?Person
    {
        return $this->personService->findByNik($nik);
    }
}
