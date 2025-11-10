<?php

use App\Models\App\Audit;

return [
    'enabled' => env('AUDITING_ENABLED', true),

    'implementation' => Audit::class,

    /*
    |--------------------------------------------------------------------------
    | User Morph Prefix & Guards
    |--------------------------------------------------------------------------
    */
    'user' => [
        'morph_prefix' => 'user',
        'guards' => ['web', 'admin', 'api'],
        'resolver' => OwenIt\Auditing\Resolvers\UserResolver::class,
    ],

    /*
    |--------------------------------------------------------------------------
    | Audit Resolvers
    |--------------------------------------------------------------------------
    */
    'resolvers' => [
        'ip_address' => OwenIt\Auditing\Resolvers\IpAddressResolver::class,
        'user_agent' => OwenIt\Auditing\Resolvers\UserAgentResolver::class,
        'url' => OwenIt\Auditing\Resolvers\UrlResolver::class,
    ],

    /*
    |--------------------------------------------------------------------------
    | Audit Events
    |--------------------------------------------------------------------------
    */
    'events' => [
        'created',
        'updated',
        'deleted',
        'restored',
    ],

    'strict' => true,

    /*
    |--------------------------------------------------------------------------
    | Global Excluded Attributes
    |--------------------------------------------------------------------------
    */
    'exclude' => [],

    /*
    |--------------------------------------------------------------------------
    | Empty Values Configuration
    |--------------------------------------------------------------------------
    | Audit akan disimpan hanya jika old_values atau new_values tidak kosong,
    | kecuali event termasuk dalam allowed_empty_values.
    */
    'empty_values' => false,
    'allowed_empty_values' => [
        'retrieved',
    ],

    /*
    |--------------------------------------------------------------------------
    | Allowed Array Values
    |--------------------------------------------------------------------------
    | Hindari menyimpan array besar kecuali benar-benar dibutuhkan.
    */
    'allowed_array_values' => false,

    /*
    |--------------------------------------------------------------------------
    | Timestamp Auditing
    |--------------------------------------------------------------------------
    | Jika ingin mencatat perubahan created_at, updated_at, dll, ubah ke true.
    */
    'timestamps' => false,

    /*
    |--------------------------------------------------------------------------
    | Audit Threshold
    |--------------------------------------------------------------------------
    | Maksimal jumlah audit per model (0 = tidak terbatas).
    */
    'threshold' => 0,

    /*
    |--------------------------------------------------------------------------
    | Audit Storage Driver
    |--------------------------------------------------------------------------
    */
    'driver' => 'database',

    'drivers' => [
        'database' => [
            'table' => 'audits',
            'connection' => 'log',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Audit Queue Configuration
    |--------------------------------------------------------------------------
    | Nonaktifkan jika ingin proses audit sinkron dan langsung tersimpan.
    */
    'queue' => [
        'enable' => false,
        'connection' => 'sync',
        'queue' => 'default',
        'delay' => 0,
    ],

    /*
    |--------------------------------------------------------------------------
    | Audit Console Events
    |--------------------------------------------------------------------------
    | Set true untuk mencatat perintah console seperti db:seed, migrate, dll.
    */
    'console' => false,
];
