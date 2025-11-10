<?php

namespace App\Models\Threat;

use Illuminate\Database\Eloquent\Model;

final class ThreatBlackListLogs extends Model
{
    public $timestamps = false;

    protected $connection = 'log';

    protected $table = 'threat_blacklist_logs';

    protected $fillable = [
        'ip_address',
        'country',
        'country_code',
        'region',
        'region_name',
        'city',
        'zip',
        'lat',
        'lon',
        'timezone',
        'isp',
        'org',
        'as',
        'header_user_agent',
    ];

    protected $casts = [
        'id' => 'integer',
        'lat' => 'decimal:8',
        'lon' => 'decimal:8',
        'created_at' => 'datetime',
    ];
}
