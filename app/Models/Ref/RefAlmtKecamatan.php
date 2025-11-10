<?php

namespace App\Models\Ref;

use App\Traits\SkipsEmptyAudit;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Auditable as AuditableTrait;
use OwenIt\Auditing\Contracts\Auditable;

final class RefAlmtKecamatan extends Model implements Auditable
{
    use AuditableTrait;
    use HasFactory;
    use SkipsEmptyAudit {
        SkipsEmptyAudit::transformAudit insteadof AuditableTrait;
    }

    public $incrementing = false;

    public $timestamps = false;

    protected $table = 'ref_almt_kecamatan';

    protected $primaryKey = 'id_kecamatan';

    protected $fillable = [
        'kecamatan',
        'id_kabupaten',
    ];

    protected $guarded = [
        'id_kecamatan',
    ];

    public function setKecamatanAttribute($value): void
    {
        $this->attributes['kecamatan'] = trim(strip_tags($value));
    }
}
