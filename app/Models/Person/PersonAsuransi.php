<?php

namespace App\Models\Person;

use App\Traits\SkipsEmptyAudit;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Auditable as AuditableTrait;
use OwenIt\Auditing\Contracts\Auditable;

final class PersonAsuransi extends Model implements Auditable
{
    use AuditableTrait;
    use HasFactory;
    use SkipsEmptyAudit {
        SkipsEmptyAudit::transformAudit insteadof AuditableTrait;
    }

    public $timestamps = false;

    public $incrementing = true;

    protected $table = 'person_asuransi';

    protected $primaryKey = 'id_person_asuransi';

    protected $keyType = 'int';

    protected $dateFormat = 'Y-m-d';

    protected $fillable = [
        'id_jenis_asuransi',
        'id_person',
        'nomor_registrasi',
        'kartu_anggota',
        'status_aktif',
        'tanggal_mulai',
        'tanggal_berakhir',
        'keterangan',
    ];

    protected $guarded = ['id_person_asuransi'];

    protected $casts = [
        'id_person_asuransi' => 'integer',
        'id_jenis_asuransi' => 'integer',
        'id_person' => 'integer',
        'tanggal_mulai' => 'date',
        'tanggal_berakhir' => 'date',
    ];

    public function setNomorRegistrasiAttribute($v): void
    {
        $this->attributes['nomor_registrasi'] = $v ? trim(strip_tags($v)) : null;
    }

    public function setKartuAnggotaAttribute($v): void
    {
        $this->attributes['kartu_anggota'] = $v ? trim(strip_tags($v)) : null;
    }

    public function setStatusAktifAttribute($v): void
    {
        $this->attributes['status_aktif'] = $v ? trim(strip_tags($v)) : 'Aktif';
    }

    public function setKeteranganAttribute($v): void
    {
        $this->attributes['keterangan'] = $v === null ? null : trim($v);
    }

    public function getTanggalMulaiAttribute($value): ?string
    {
        return $value ? Carbon::parse($value)->format('Y-m-d') : null;
    }

    public function getTanggalBerakhirAttribute($value): ?string
    {
        return $value ? Carbon::parse($value)->format('Y-m-d') : null;
    }
    
}
