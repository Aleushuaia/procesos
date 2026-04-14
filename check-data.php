<?php
exec('cd c:\\laravel\\procesos\\src && php artisan tinker << \'EOF\'
use Illuminate\Support\Facades\DB;

$tables = ["criticidades_procesos", "estados_procesos", "tipos_actores", "tipos_procesos", "personas", "unidades_responsables", "tipos_flujos_procesos"];

foreach ($tables as $table) {
    $count = DB::table($table)->count();
    echo "$table: $count registros\n";
}
exit();
EOF
', $output, $returnCode);

echo implode("\n", $output);
