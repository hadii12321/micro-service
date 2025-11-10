<?php

namespace App\Models\Sdm;

use App\Traits\SkipsEmptyAudit;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Auditable as AuditableTrait;
use OwenIt\Auditing\Contracts\Auditable;

final class SdmRekening extends Model implements Auditable
{
    use AuditableTrait;
    use HasFactory;
    use SkipsEmptyAudit {
        SkipsEmptyAudit::transformAudit insteadof AuditableTrait;
    }

    public $timestamps = false;

    public $incrementing = true;

    protected $table = 'sdm_rekening';

    protected $primaryKey = 'id_rekening';

    protected $keyType = 'int';

    protected $fillable = [
        'id_sdm',
        'no_rekening',
        'bank',
        'nama_pemilik',
        'kode_bank',
        'cabang_bank',
        'rekening_utama',
        'jenis_rekening',
        'status_aktif',
    ];

    protected $guarded = ['id_rekening'];

    protected $casts = [
        'id_rekening' => 'integer',
        'id_sdm' => 'integer',
    ];

    public function setNoRekeningAttribute($v): void
    {
        $this->attributes['no_rekening'] = trim(strip_tags((string)$v));
    }

    public function setBankAttribute($v): void
    {
        $this->attributes['bank'] = trim(strip_tags((string)$v));
    }

    public function setNamaPemilikAttribute($v): void
    {
        $this->attributes['nama_pemilik'] = $v === null ? null : trim(strip_tags((string)$v));
    }

    public function setKodeBankAttribute($v): void
    {
        $this->attributes['kode_bank'] = $v === null ? null : trim(strip_tags((string)$v));
    }

    public function setCabangBankAttribute($v): void
    {
        $this->attributes['cabang_bank'] = $v === null ? null : trim(strip_tags((string)$v));
    }

    public function setRekeningUtamaAttribute($v): void
    {
        $val = strtolower((string)$v);
        $this->attributes['rekening_utama'] = in_array($val, ['y', 'n'], true) ? $val : 'n';
    }

    public function setJenisRekeningAttribute($v): void
    {
        $this->attributes['jenis_rekening'] = $v ? trim(strip_tags((string)$v)) : null;
    }

    public function setStatusAktifAttribute($v): void
    {
        $this->attributes['status_aktif'] = $v ? trim(strip_tags((string)$v)) : 'Aktif';
    }
}
