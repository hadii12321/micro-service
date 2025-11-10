<?php

namespace App\Models\Ref;

use App\Traits\SkipsEmptyAudit;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Auditable as AuditableTrait;
use OwenIt\Auditing\Contracts\Auditable;

final class RefJenisAsuransi extends Model implements Auditable
{
    use AuditableTrait;
    use HasFactory;
    use SkipsEmptyAudit {
        SkipsEmptyAudit::transformAudit insteadof AuditableTrait;
    }

    public $timestamps = false;

    protected $table = 'ref_jenis_asuransi';

    protected $primaryKey = 'id_jenis_asuransi';

    protected $fillable = [
        'jenis_asuransi',
        'nama_produk',
        'provider',
    ];

    protected $guarded = [
        'id_jenis_asuransi',
    ];

    protected $casts = [
        'id_jenis_asuransi' => 'integer',
    ];

    public function setJenisAsuransiAttribute($value): void
    {
        $this->attributes['jenis_asuransi'] = trim(strip_tags($value));
    }

    public function setNamaProdukAttribute($value): void
    {
        $this->attributes['nama_produk'] = trim(strip_tags($value));
    }

    public function setProviderAttribute($value): void
    {
        $this->attributes['provider'] = trim(strip_tags($value));
    }
}
