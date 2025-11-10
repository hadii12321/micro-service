<?php

namespace App\Models\Ref;

use App\Traits\SkipsEmptyAudit;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Auditable as AuditableTrait;
use OwenIt\Auditing\Contracts\Auditable;

final class RefAlmtKabupaten extends Model implements Auditable
{
    use AuditableTrait;
    use HasFactory;
    use SkipsEmptyAudit {
        SkipsEmptyAudit::transformAudit insteadof AuditableTrait;
    }

    public $incrementing = false;

    public $timestamps = false;

    protected $table = 'ref_almt_kabupaten';

    protected $primaryKey = 'id_kabupaten';

    protected $fillable = [
        'kabupaten',
        'id_provinsi',
    ];

    protected $guarded = [
        'id_kabupaten',
    ];

    public function setKabupatenAttribute($value): void
    {
        $this->attributes['kabupaten'] = trim(strip_tags($value));
    }
}
