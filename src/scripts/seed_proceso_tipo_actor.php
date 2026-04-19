<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

if (!Schema::hasTable('procesos') || !Schema::hasTable('tipos_actores') || !Schema::hasTable('proceso_tipo_actor')) {
    echo "Required tables not found; aborting.\n";
    exit(1);
}

$procesos = DB::table('procesos')->pluck('id')->toArray();
$tipos = DB::table('tipos_actores')->pluck('id')->toArray();
if (empty($procesos) || empty($tipos)) {
    echo "No procesos or tipos_actores found; aborting.\n";
    exit(1);
}

$existing = DB::table('proceso_tipo_actor')->select(['proceso_id','tipo_actor_id'])->get()->map(function($r){ return $r->proceso_id . '|' . $r->tipo_actor_id; })->toArray();
$pairs = [];
$desired = 50;
$attempts = 0;
while (count($pairs) < $desired && $attempts < 2000) {
    $attempts++;
    $p = $procesos[array_rand($procesos)];
    $t = $tipos[array_rand($tipos)];
    $key = $p . '|' . $t;
    if (in_array($key, $existing) || isset($pairs[$key])) continue;
    $pairs[$key] = [
        'proceso_id' => $p,
        'tipo_actor_id' => $t,
        'created_at' => date('Y-m-d H:i:s'),
        'updated_at' => date('Y-m-d H:i:s'),
    ];
}

if (!empty($pairs)) {
    DB::table('proceso_tipo_actor')->insert(array_values($pairs));
    echo 'Inserted ' . count($pairs) . " records\n";
    exit(0);
} else {
    echo "No new pairs generated\n";
    exit(0);
}
