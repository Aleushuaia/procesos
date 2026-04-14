#!/bin/bash
cd /app/src
php artisan tinker << 'EOF'
use Illuminate\Support\Facades\DB;

$tables = ["criticidades_procesos", "estados_procesos", "tipos_actores", "tipos_procesos", "personas", "unidades_responsables", "tipos_flujos_procesos"];

echo "=== ESTADO DE LA BD ===\n";
foreach ($tables as $table) {
    $count = DB::table($table)->count();
    echo "$table: $count registros\n";
}

echo "\n=== PRIMEROS REGISTROS ===\n";
if (DB::table('criticidades_procesos')->count() > 0) {
    $criticidades = DB::table('criticidades_procesos')->limit(5)->get();
    echo "Criticidades: " . json_encode($criticidades, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) . "\n";
}

exit();
EOF
