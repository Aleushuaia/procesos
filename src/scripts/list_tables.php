<?php

require __DIR__ . '/../vendor/autoload.php';
$app = require __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\DB;

$tables = DB::select("select table_name from information_schema.tables where table_schema='public'");
$names = array_map(function($r){ return $r->table_name ?? ($r[0] ?? null); }, $tables);
echo json_encode($names, JSON_PRETTY_PRINT) . PHP_EOL;
