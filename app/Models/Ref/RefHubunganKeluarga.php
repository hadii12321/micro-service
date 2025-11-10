<?php

namespace App\Models\Ref;

use App\Traits\SkipsEmptyAudit;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Auditable as AuditableTrait;
use OwenIt\Auditing\Contracts\Auditable;

final class RefHubunganKeluarga extends Model implements Auditable
{
    use AuditableTrait;
    use HasFactory;
    use SkipsEmptyAudit {
        SkipsEmptyAudit::transformAudit insteadof AuditableTrait;
    }

    public $timestamps = false;

    protected $table = 'ref_hubungan_keluarga';

    protected $primaryKey = 'id_hubungan_keluarga';

    protected $fillable = [
        'hubungan_keluarga',
        'jk',
    ];

    protected $guarded = [
        'id_hubungan_keluarga',
    ];

    protected $casts = [
        'id_hubungan_keluarga' => 'integer',
    ];

    public function setHubunganKeluargaAttribute($value): void
    {
        $this->attributes['hubungan_keluarga'] = trim(strip_tags($value));
    }

    public function setJkAttribute($value): void
    {
        $this->attributes['jk'] = strtoupper(trim($value));
    }
}
