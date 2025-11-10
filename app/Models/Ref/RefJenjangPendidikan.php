<?php

namespace App\Models\Ref;

use App\Traits\SkipsEmptyAudit;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Auditable as AuditableTrait;
use OwenIt\Auditing\Contracts\Auditable;

final class RefJenjangPendidikan extends Model implements Auditable
{
    use AuditableTrait;
    use HasFactory;
    use SkipsEmptyAudit {
        SkipsEmptyAudit::transformAudit insteadof AuditableTrait;
    }

    public $timestamps = false;

    protected $table = 'ref_jenjang_pendidikan';

    protected $primaryKey = 'id_jenjang_pendidikan';

    protected $fillable = [
        'jenjang_pendidikan',
    ];

    protected $guarded = [
        'id_jenjang_pendidikan',
    ];

    protected $casts = [
        'id_jenjang_pendidikan' => 'integer',
    ];

    public function setJenjangPendidikanAttribute($value): void
    {
        $this->attributes['jenjang_pendidikan'] = trim(strip_tags($value));
    }
}
