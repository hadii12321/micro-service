<?php

use Illuminate\Http\Request;

define('LARAVEL_START', microtime(true));
date_default_timezone_set('Asia/Jakarta');
ini_set('memory_limit', '-1');
ini_set('max_execution_time', '0');
ini_set('display_errors', 'Off');
ini_set('display_startup_errors', 'Off');

if (file_exists($maintenance = __DIR__.'/../storage/framework/maintenance.php')) {
    require $maintenance;
}

require __DIR__.'/../vendor/autoload.php';

(require_once __DIR__.'/../bootstrap/app.php')->handleRequest(Request::capture());
