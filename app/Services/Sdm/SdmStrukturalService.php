<?php

namespace App\Services\Sdm;

use App\Models\Person\Person;
use App\Models\Sdm\PersonSdm;
use App\Models\Sdm\SdmStruktural;
use App\Services\Person\PersonService;
use App\Services\Tools\FileUploadService;
use Illuminate\Support\Collection;

final readonly class SdmStrukturalService
{
    public function __construct(
        private FileUploadService $fileUploadService,
        private PersonService     $personService,
    )
    {
    }

    public function getPersonDetailByUuid(string $uuid): ?Person
    {
        return $this->personService->getPersonDetailByUuid($uuid);
    }

    public function getListData(string $uuid): Collection
    {
        $idSdm = PersonSdm::query()
            ->join('person', 'person.id_person', '=', 'person_sdm.id_person')
            ->where('person.uuid_person', $uuid)
            ->value('person_sdm.id_sdm');

        if (!$idSdm) {
            return collect();
        }

        $latestId = SdmStruktural::query()
            ->where('id_sdm', $idSdm)
            ->orderByDesc('tanggal_sk')
            ->orderByDesc('id_struktural')
            ->value('id_struktural');

        $data = SdmStruktural::query()
            ->leftJoin('master_jabatan', 'master_jabatan.id_jabatan', '=', 'sdm_struktural.id_jabatan')
            ->leftJoin('master_periode', 'master_periode.id_periode', '=', 'master_jabatan.id_periode')
            ->leftJoin('master_unit', 'master_unit.id_unit', '=', 'sdm_struktural.id_unit')
            ->leftJoin('ref_eselon', 'ref_eselon.id_eselon', '=', 'master_jabatan.id_eselon')
            ->select([
                'sdm_struktural.*',
                'master_periode.periode',
                'master_jabatan.jabatan as nama_jabatan',
                'master_unit.unit as nama_unit',
                'ref_eselon.eselon',
            ])
            ->where('sdm_struktural.id_sdm', $idSdm)
            ->orderByDesc('sdm_struktural.tanggal_sk')
            ->orderBy('master_jabatan.jabatan')
            ->get();

        return $data->map(function ($row) use ($latestId) {
            $row->is_latest = (int)($row->id_struktural == $latestId);

            return $row;
        });
    }

    public function create(array $data): SdmStruktural
    {
        return SdmStruktural::create($data);
    }

    public function getDetailData(string $id): ?SdmStruktural
    {
        return SdmStruktural::query()
            ->leftJoin('master_jabatan', 'master_jabatan.id_jabatan', '=', 'sdm_struktural.id_jabatan')
            ->leftJoin('master_unit', 'master_unit.id_unit', '=', 'sdm_struktural.id_unit')
            ->leftJoin('ref_eselon', 'ref_eselon.id_eselon', '=', 'master_jabatan.id_eselon')
            ->select([
                'sdm_struktural.*',
                'master_jabatan.jabatan as nama_jabatan',
                'master_unit.unit as nama_unit',
                'ref_eselon.eselon',
            ])
            ->where('sdm_struktural.id_struktural', $id)
            ->first();
    }

    public function findById(string $id): ?SdmStruktural
    {
        return SdmStruktural::find($id);
    }

    public function delete(SdmStruktural $struktural): void
    {
        if ($struktural->file_sk_masuk) {
            $this->fileUploadService->deleteFileByType($struktural->file_sk_masuk, 'struktural');
        }
        if ($struktural->file_sk_keluar) {
            $this->fileUploadService->deleteFileByType($struktural->file_sk_keluar, 'struktural');
        }
        $struktural->delete();
    }


    public function resolveIdSdmFromUuid(string $uuid): ?int
    {
        return PersonSdm::query()
            ->join('person', 'person.id_person', '=', 'person_sdm.id_person')
            ->where('person.uuid_person', $uuid)
            ->value('person_sdm.id_sdm');
    }

    public function isLatestRecord(SdmStruktural $struktural): bool
    {
        $latestId = $this->getLatestId($struktural->id_sdm);

        return $struktural->id_struktural == $latestId;
    }

    public function getLatestId(int $idSdm): ?int
    {
        return SdmStruktural::query()
            ->where('id_sdm', $idSdm)
            ->orderByDesc('tanggal_sk')
            ->orderByDesc('id_struktural')
            ->value('id_struktural');
    }

    public function updatePreviousStructuralRecords(int $idSdm): void
    {
        // Close previous structural records without exit date
        SdmStruktural::query()
            ->where('id_sdm', $idSdm)
            ->whereNull('tanggal_keluar')
            ->update([
                'tanggal_keluar' => now()->format('Y-m-d'),
            ]);
    }

    public function update(SdmStruktural $struktural, array $data): SdmStruktural
    {
        $struktural->update($data);

        return $struktural;
    }

    public function handleFileUpload($file, int $idSdm, string $dokumen): ?array
    {
        if (!$file) {
            return null;
        }

        $personSdm = PersonSdm::query()
            ->join('person', 'person.id_person', '=', 'person_sdm.id_person')
            ->select([
                'person.uuid_person',
                'person.nama',
            ])
            ->where('person_sdm.id_sdm', $idSdm)
            ->first();

        $uniqueCode = substr(md5(uniqid()), 0, 6);
        $template = '{id_sdm}_{nama}_{dokumen}_{unique_code}';

        $data = [
            'id_sdm' => $personSdm->uuid_person ?? 'unknown',
            'nama' => $personSdm->nama ?? 'unknown',
            'dokumen' => $dokumen,
            'unique_code' => $uniqueCode,
        ];

        return $this->fileUploadService->uploadWithTemplate($file, 'struktural', $template, $data);
    }

    public function updateFileUpload($file, string $oldFileName, int $idSdm, string $dokumen): ?array
    {
        if (!$file) {
            return null;
        }

        $personSdm = PersonSdm::query()
            ->join('person', 'person.id_person', '=', 'person_sdm.id_person')
            ->select([
                'person.uuid_person',
                'person.nama',
            ])
            ->where('person_sdm.id_sdm', $idSdm)
            ->first();

        $uniqueCode = substr(md5(uniqid()), 0, 6);
        $template = '{id_sdm}_{nama}_{dokumen}_{unique_code}';

        $data = [
            'id_sdm' => $personSdm->uuid_person ?? 'unknown',
            'nama' => $personSdm->nama ?? 'unknown',
            'dokumen' => $dokumen,
            'unique_code' => $uniqueCode,
        ];

        return $this->fileUploadService->updateWithTemplate($file, $oldFileName, 'struktural', $template, $data);
    }
}
