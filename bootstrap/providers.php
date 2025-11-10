<?php

use App\Providers\AppServiceProvider;
use OwenIt\Auditing\AuditingServiceProvider;
use Rap2hpoutre\LaravelLogViewer\LaravelLogViewerServiceProvider;
use Yajra\DataTables\DataTablesServiceProvider;

return [
    AppServiceProvider::class,
    DataTablesServiceProvider::class,
    LaravelLogViewerServiceProvider::class,
    AuditingServiceProvider::class,
];
