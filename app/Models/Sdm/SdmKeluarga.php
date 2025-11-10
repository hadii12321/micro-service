<?php

namespace App\Models\Sdm;

use App\Traits\SkipsEmptyAudit;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Auditable as AuditableTrait;
use OwenIt\Auditing\Contracts\Auditable;

final class SdmKeluarga extends Model implements Auditable
{
    use AuditableTrait;
    use HasFactory;
    use SkipsEmptyAudit {
        SkipsEmptyAudit::transformAudit insteadof AuditableTrait;
    }

    public $incrementing = true;

    public $timestamps = false;

    protected $table = 'sdm_keluarga';

    protected $primaryKey = 'id_keluarga';

    protected $keyType = 'int';

    protected $fillable = [
        'id_sdm',
        'id_person',
        'id_hubungan_keluarga',
        'status_tanggungan',
        'pekerjaan',
        'pendidikan_terakhir',
        'penghasilan',
    ];

    protected $guarded = ['id_keluarga'];

    protected $casts = [
        'id_keluarga' => 'integer',
        'id_sdm' => 'integer',
        'id_person' => 'integer',
        'id_hubungan_keluarga' => 'integer',
        'penghasilan' => 'integer',
    ];

    public function setPekerjaanAttribute($v): void
    {
        $this->attributes['pekerjaan'] = $v ? trim(strip_tags($v)) : null;
    }

    public function setPendidikanTerakhirAttribute($v): void
    {
        $this->attributes['pendidikan_terakhir'] = $v ? trim(strip_tags($v)) : null;
    }

    public function setStatusTanggunganAttribute($v): void
    {
        $this->attributes['status_tanggungan'] = $v ? trim(strip_tags($v)) : null;
    }
}
