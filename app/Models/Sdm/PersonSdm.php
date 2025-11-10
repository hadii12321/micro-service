<?php

namespace App\Models\Sdm;

use App\Traits\SkipsEmptyAudit;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use OwenIt\Auditing\Auditable as AuditableTrait;
use OwenIt\Auditing\Contracts\Auditable;

final class PersonSdm extends Model implements Auditable
{
    use AuditableTrait;
    use HasFactory;
    use SkipsEmptyAudit {
        SkipsEmptyAudit::transformAudit insteadof AuditableTrait;
    }

    public $timestamps = false;

    public $incrementing = true;

    protected $table = 'person_sdm';

    protected $primaryKey = 'id_sdm';

    protected $keyType = 'int';

    protected $dateFormat = 'Y-m-d';

    protected $fillable = [
        'id_person',
        'nomor_karpeg',
        'nomor_sk',
        'tmt',
        'tmt_pensiun',
    ];

    protected $guarded = ['id_sdm'];

    protected $casts = [
        'id_sdm' => 'integer',
        'id_person' => 'integer',
        'id_jenis_sdm' => 'integer',
        'id_status_sdm' => 'integer',
        'tmt' => 'date',
        'tmt_pensiun' => 'date',
    ];

    public function setNomorKarpegAttribute($v): void
    {
        $this->attributes['nomor_karpeg'] = $v ? trim(strip_tags($v)) : null;
    }

    public function setNuptkAttribute($v): void
    {
        $this->attributes['nuptk'] = $v ? trim(strip_tags($v)) : null;
    }

    public function setNomorSkAttribute($v): void
    {
        $this->attributes['nomor_sk'] = $v ? trim(strip_tags($v)) : null;
    }

    public function getTmtAttribute($value): ?string
    {
        return $value ? Carbon::parse($value)->format('Y-m-d') : null;
    }

    public function getTmtPensiunAttribute($value): ?string
    {
        return $value ? Carbon::parse($value)->format('Y-m-d') : null;
    }
}
