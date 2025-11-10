<?php

namespace App\Models\App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use OwenIt\Auditing\Audit as AuditableTrait;
use OwenIt\Auditing\Contracts\Audit as Auditable;

final class Audit extends Model implements Auditable
{
    use AuditableTrait;

    public $timestamps = true;

    protected $table = 'audits';

    protected $fillable = [
        'user_type',
        'user_id',
        'event',
        'auditable_type',
        'auditable_id',
        'old_values',
        'new_values',
        'url',
        'ip_address',
        'user_agent',
        'tags',
    ];

    protected $casts = [
        'id' => 'integer',
        'user_id' => 'integer',
        'auditable_id' => 'integer',
        'old_values' => 'json',
        'new_values' => 'json',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function user(): MorphTo
    {
        return $this->morphTo();
    }

    public function auditable(): MorphTo
    {
        return $this->morphTo();
    }
}
