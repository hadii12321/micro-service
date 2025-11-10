<?php

namespace App\Models\Master;

use App\Traits\SkipsEmptyAudit;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Auditable as AuditableTrait;
use OwenIt\Auditing\Contracts\Auditable;

final class MasterUnit extends Model implements Auditable
{
    use AuditableTrait;
    use HasFactory;
    use SkipsEmptyAudit {
        SkipsEmptyAudit::transformAudit insteadof AuditableTrait;
    }

    public $timestamps = false;

    protected $table = 'master_unit';

    protected $primaryKey = 'id_unit';

    protected $fillable = [
        'unit',
        'singkatan',
    ];

    protected $guarded = [
        'id_unit',
    ];


    public function setUnitAttribute($value): void
    {
        $this->attributes['unit'] = trim(strip_tags($value));
    }

    public function setSingkatanAttribute($value): void
    {
        $this->attributes['singkatan'] = strtoupper(trim(strip_tags($value)));
    }
}
