<?php

namespace App\Services\Sdm;

use App\Models\Person\Person;
use App\Models\Sdm\PersonSdm;
use App\Services\Person\PersonService;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

final readonly class PersonSdmService
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

    public function getHistoriByUuid(string $uuid): Collection
    {
        return PersonSdm::query()
            ->leftJoin('person', 'person.id_person', '=', 'person_sdm.id_person')
            ->select([
                'person_sdm.id_sdm',
                'person_sdm.nomor_karpeg',
                'person_sdm.nomor_sk',
                'person_sdm.tmt',
                'person_sdm.tmt_pensiun',
                'person.nama',
                'person.uuid_person',
            ])
            ->where('person.uuid_person', $uuid)
            ->orderByDesc('person_sdm.tmt')
            ->get();
    }

    public function getListData(): Collection
    {
        return PersonSdm::query()
            ->leftJoin('person', 'person.id_person', '=', 'person_sdm.id_person')
            ->select([
                'person_sdm.id_sdm',
                'person_sdm.nomor_karpeg',
                'person_sdm.nomor_sk',
                'person_sdm.tmt',
                'person_sdm.tmt_pensiun',
                'person.nama',
                'person.uuid_person',
            ])
            ->get();
    }

    public function create(array $data): PersonSdm
    {
        return PersonSdm::create($data);
    }

    public function getDetailData(string $id): ?PersonSdm
    {
        return PersonSdm::query()
            ->leftJoin('person', 'person.id_person', '=', 'person_sdm.id_person')
            ->select([
                'person_sdm.*',
                'person.nik',
                'person.nomor_kk',
                'person.nomor_hp',
                'person.nama',
            ])
            ->where('person_sdm.id_sdm', $id)
            ->first();
    }

    public function findById(string $id): ?PersonSdm
    {
        return PersonSdm::find($id);
    }

    public function update(PersonSdm $personSdm, array $data): PersonSdm
    {
        $personSdm->update($data);

        return $personSdm;
    }

    public function checkDuplicate(int $idPerson): bool
    {
        return PersonSdm::where('id_person', $idPerson)
            ->exists();
    }

    public function findByNik(string $nik): ?Person
    {
        return $this->personService->findByNik($nik);
    }
}
