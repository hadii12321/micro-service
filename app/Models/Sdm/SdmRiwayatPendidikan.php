<?php

namespace App\Models\Sdm;

use App\Traits\SkipsEmptyAudit;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Auditable as AuditableTrait;
use OwenIt\Auditing\Contracts\Auditable;

final class SdmRiwayatPendidikan extends Model implements Auditable
{
    use AuditableTrait;
    use HasFactory;
    use SkipsEmptyAudit {
        SkipsEmptyAudit::transformAudit insteadof AuditableTrait;
    }

    public $incrementing = true;

    public $timestamps = false;

    protected $table = 'sdm_riwayat_pendidikan';

    protected $primaryKey = 'id_riwayat_pendidikan';

    protected $dateFormat = 'Y-m-d';

    protected $fillable = [
        'id_riwayat_pendidikan_sister',
        'id_sdm',
        'id_jenjang_pendidikan',
        'nama_sekolah',
        'negara',
        'status_sekolah',
        'jurusan',
        'nomor_induk',
        'tahun_masuk',
        'tahun_lulus',
        'gelar_akademik',
        'bidang_studi',
        'ipk',
        'tanggal_lulus',
        'jumlah_semester',
        'jumlah_sks',
        'nomor_ijazah',
        'judul_tugas_akhir',
        'sumber_biaya',
        'nama_pembimbing',
        'file_ijazah',
        'file_transkip',
    ];

    protected $guarded = ['id_riwayat_pendidikan'];

    protected $casts = [
        'id_riwayat_pendidikan' => 'integer',
        'id_sdm' => 'integer',
        'id_jenjang_pendidikan' => 'integer',
        'tahun_masuk' => 'integer',
        'tahun_lulus' => 'integer',
        'ipk' => 'decimal:2',
        'tanggal_lulus' => 'date',
        'jumlah_semester' => 'integer',
        'jumlah_sks' => 'integer',
    ];

    public function setNamaSekolahAttribute($v): void
    {
        $this->attributes['nama_sekolah'] = $v ? trim(strip_tags($v)) : null;
    }

    public function setJurusanAttribute($v): void
    {
        $this->attributes['jurusan'] = $v ? trim(strip_tags($v)) : null;
    }

    public function setNomorIndukAttribute($v): void
    {
        $this->attributes['nomor_induk'] = $v ? trim(strip_tags($v)) : null;
    }

    public function setGelarAkademikAttribute($v): void
    {
        $this->attributes['gelar_akademik'] = $v ? trim(strip_tags($v)) : null;
    }

    public function setBidangStudiAttribute($v): void
    {
        $this->attributes['bidang_studi'] = $v ? trim(strip_tags($v)) : null;
    }

    public function setNomorIjazahAttribute($v): void
    {
        $this->attributes['nomor_ijazah'] = $v ? trim(strip_tags($v)) : null;
    }

    public function setJudulTugasAkhirAttribute($v): void
    {
        $this->attributes['judul_tugas_akhir'] = $v ? trim(strip_tags($v)) : null;
    }

    public function setNamaPembimbingAttribute($v): void
    {
        $this->attributes['nama_pembimbing'] = $v ? trim(strip_tags($v)) : null;
    }

    public function setNegaraAttribute($v): void
    {
        $this->attributes['negara'] = $v ? trim($v) : 'Indonesia';
    }

    public function getTanggalLulusAttribute($v): ?string
    {
        return $v ? Carbon::parse($v)->format('Y-m-d') : null;
    }
}
