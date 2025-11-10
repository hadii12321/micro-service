<?php

namespace App\Models\Master;

use App\Traits\SkipsEmptyAudit;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Auditable as AuditableTrait;
use OwenIt\Auditing\Contracts\Auditable;

final class MasterJabatan extends Model implements Auditable
{
    use AuditableTrait;
    use HasFactory;
    use SkipsEmptyAudit {
        SkipsEmptyAudit::transformAudit insteadof AuditableTrait;
    }

    public $timestamps = false;

    protected $table = 'master_jabatan';

    protected $primaryKey = 'id_jabatan';

    protected $fillable = [
        'jabatan',
        'id_unit',
        'id_periode',
        'id_eselon',
    ];

    protected $guarded = [
        'id_jabatan',
    ];

    protected $casts = [
        'id_unit' => 'integer',
        'id_periode' => 'integer',
        'id_eselon' => 'integer',
    ];

    public function setJabatanAttribute($value): void
    {
        $this->attributes['jabatan'] = trim(strip_tags($value));
    }
}
