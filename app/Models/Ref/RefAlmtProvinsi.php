<?php

namespace App\Models\Ref;

use App\Traits\SkipsEmptyAudit;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Auditable as AuditableTrait;
use OwenIt\Auditing\Contracts\Auditable;

final class RefAlmtProvinsi extends Model implements Auditable
{
    use AuditableTrait;
    use HasFactory;
    use SkipsEmptyAudit {
        SkipsEmptyAudit::transformAudit insteadof AuditableTrait;
    }

    public $incrementing = false;

    public $timestamps = false;

    protected $table = 'ref_almt_provinsi';

    protected $primaryKey = 'id_provinsi';

    protected $fillable = [
        'provinsi',
    ];

    protected $guarded = [
        'id_provinsi',
    ];

    protected $casts = [
        'id_provinsi' => 'string',
    ];

    public function setProvinsiAttribute($value): void
    {
        $this->attributes['provinsi'] = trim(strip_tags($value));
    }
}
