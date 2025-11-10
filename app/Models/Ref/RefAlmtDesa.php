<?php

namespace App\Models\Ref;

use App\Traits\SkipsEmptyAudit;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Auditable as AuditableTrait;
use OwenIt\Auditing\Contracts\Auditable;

final class RefAlmtDesa extends Model implements Auditable
{
    use AuditableTrait;
    use HasFactory;
    use SkipsEmptyAudit {
        SkipsEmptyAudit::transformAudit insteadof AuditableTrait;
    }

    public $incrementing = false;

    public $timestamps = false;

    protected $table = 'ref_almt_desa';

    protected $primaryKey = 'id_desa';

    protected $fillable = [
        'desa',
        'id_kecamatan',
    ];

    protected $guarded = [
        'id_desa',
    ];

    public function setDesaAttribute($value): void
    {
        $this->attributes['desa'] = trim(strip_tags($value));
    }
}
