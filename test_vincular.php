<?php
require 'src/vendor/autoload.php';
$app = require 'src/bootstrap/app.php';
$kernel = $app->make('Illuminate\Contracts\Console\Kernel');
$kernel->bootstrap();

$proceso = \App\Models\Proceso::first();
$unidad = \App\Models\UnidadResponsable::first();

if (!$proceso) {
    echo "ERROR: No hay procesos en la BD\n";
    exit(1);
}

if (!$unidad) {
    echo "ERROR: No hay unidades responsables en la BD\n";
    exit(1);
}

echo "=== Test de Relación Many-to-Many ===\n";
echo "Proceso ID: " . $proceso->id . "\n";
echo "Unidad ID: " . $unidad->id . "\n";
echo "Unidades antes: " . $proceso->unidadesResponsables()->count() . "\n";

try {
    echo "\nIntentando vincular unidad...\n";
    $proceso->unidadesResponsables()->attach($unidad->id);
    echo "✓ Unidad vinculada exitosamente\n";
    echo "Unidades después de attach: " . $proceso->unidadesResponsables()->count() . "\n";
    
    // Verificar que existe
    $existe = $proceso->unidadesResponsables()->where('unidad_responsable_id', $unidad->id)->exists();
    echo "Unidad vinculada verificada: " . ($existe ? "SÍ" : "NO") . "\n";
    
    echo "\nIntentando desvincu lar unidad...\n";
    $proceso->unidadesResponsables()->detach($unidad->id);
    echo "✓ Unidad desvinculada exitosamente\n";
    echo "Unidades después de detach: " . $proceso->unidadesResponsables()->count() . "\n";
} catch (Exception $e) {
    echo "✗ ERROR: " . $e->getMessage() . "\n";
    echo "Trace:\n" . $e->getTraceAsString() . "\n";
    exit(1);
}

echo "\n=== Test Completado Exitosamente ===\n";
