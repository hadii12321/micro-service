<?php

namespace App\Models\Sdm;

use App\Traits\SkipsEmptyAudit;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Auditable as AuditableTrait;
use OwenIt\Auditing\Contracts\Auditable;

final class SdmStruktural extends Model implements Auditable
{
    use AuditableTrait;
    use HasFactory;
    use SkipsEmptyAudit {
        SkipsEmptyAudit::transformAudit insteadof AuditableTrait;
    }

    public $timestamps = false;

    public $incrementing = true;

    protected $table = 'sdm_struktural';

    protected $primaryKey = 'id_struktural';

    protected $keyType = 'int';

    protected $dateFormat = 'Y-m-d';

    protected $fillable = [
        'id_sdm',
        'id_unit',
        'id_jabatan',
        'nomor_sk',
        'tanggal_sk',
        'tanggal_masuk',
        'id_eselon',
        'masa_jabatan',
        'tanggal_keluar',
        'sk_pemberhentian',
        'alasan_keluar',
        'keterangan',
        'file_sk_masuk',
        'file_sk_keluar',
    ];

    protected $guarded = ['id_struktural'];

    protected $casts = [
        'id_struktural' => 'integer',
        'id_sdm' => 'integer',
        'id_unit' => 'integer',
        'id_jabatan' => 'integer',
        'id_eselon' => 'integer',
        'masa_jabatan' => 'integer',
        'tanggal_sk' => 'date',
        'tanggal_masuk' => 'date',
        'tanggal_keluar' => 'date',
    ];

    public function setNomorSkAttribute($v): void
    {
        $this->attributes['nomor_sk'] = trim(strip_tags((string)$v));
    }

    public function setSkPemberhentianAttribute($v): void
    {
        $this->attributes['sk_pemberhentian'] = $v === null ? null : trim(strip_tags((string)$v));
    }

    public function setAlasanKeluarAttribute($v): void
    {
        $this->attributes['alasan_keluar'] = $v === null ? null : trim((string)$v);
    }

    public function setKeteranganAttribute($v): void
    {
        $this->attributes['keterangan'] = $v === null ? null : trim((string)$v);
    }

    public function getTanggalSkAttribute($v): ?string
    {
        return $v ? Carbon::parse($v)->format('Y-m-d') : null;
    }

    public function getTanggalMasukAttribute($v): ?string
    {
        return $v ? Carbon::parse($v)->format('Y-m-d') : null;
    }

    public function getTanggalKeluarAttribute($v): ?string
    {
        return $v ? Carbon::parse($v)->format('Y-m-d') : null;
    }
}
