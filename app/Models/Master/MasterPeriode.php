<?php

namespace App\Models\Master;

use App\Traits\SkipsEmptyAudit;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Auditable as AuditableTrait;
use OwenIt\Auditing\Contracts\Auditable;

final class MasterPeriode extends Model implements Auditable
{
    use AuditableTrait;
    use HasFactory;
    use SkipsEmptyAudit {
        SkipsEmptyAudit::transformAudit insteadof AuditableTrait;
    }

    public $timestamps = false;

    protected $table = 'master_periode';

    protected $primaryKey = 'id_periode';

    protected $fillable = [
        'periode',
        'tanggal_awal',
        'tanggal_akhir',
        'status',
    ];

    protected $guarded = [
        'id_periode',
    ];

    protected $casts = [
        'tanggal_awal' => 'date:Y-m-d',
        'tanggal_akhir' => 'date:Y-m-d',
        'status' => 'string',
    ];

    public function setUnitAttribute($value): void
    {
        $this->attributes['periode'] = trim(strip_tags($value));
    }

    public function getTanggalAwalAttribute($v): ?string
    {
        return $v ? Carbon::parse($v)->format('Y-m-d') : null;
    }

    public function getTanggalAkhirAttribute($v): ?string
    {
        return $v ? Carbon::parse($v)->format('Y-m-d') : null;
    }
}
