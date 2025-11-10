<?php

namespace App\Models\Threat;

use Illuminate\Database\Eloquent\Model;

final class ThreatActivityLogs extends Model
{
    public $timestamps = false;

    protected $connection = 'log';

    protected $table = 'threat_activity_logs';

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
        'method',
        'url',
        'header_user_agent',
        'referer',
        'browser_detected',
        'os_detected',
        'device_type',
        'validation_score',
    ];

    protected $casts = [
        'id' => 'integer',
        'validation_score' => 'integer',
        'lat' => 'decimal:8',
        'lon' => 'decimal:8',
        'created_at' => 'datetime',
    ];
}
