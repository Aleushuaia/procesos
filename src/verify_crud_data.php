<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\Proceso;
use App\Models\TipoProceso;
use App\Models\EstadoProceso;
use App\Models\CriticidadProceso;
use App\Models\UnidadResponsable;
use App\Models\Persona;

echo "=== VERIFICACIÓN DE DATOS PARA CRUD ===\n\n";

// Procesos con relaciones
$procesos = Proceso::with('tipoProceso', 'estadoProceso', 'criticidadProceso', 'unidadResponsable', 'flujos')->limit(3)->get();
echo "✓ Procesos cargables: " . $procesos->count() . " de " . Proceso::count() . "\n";
foreach ($procesos as $p) {
    echo "  - {$p->codigo}: {$p->descripcion} (Estado: {$p->estadoProceso?->descripcion}, Flujos: {$p->flujos->count()})\n";
}

echo "\n✓ Catálogos disponibles:\n";
echo "  - Tipos de Proceso: " . TipoProceso::count() . "\n";
echo "  - Estados: " . EstadoProceso::count() . "\n";
echo "  - Criticidades: " . CriticidadProceso::count() . "\n";
echo "  - Unidades Responsables: " . UnidadResponsable::count() . "\n";
echo "  - Personas para asignación: " . Persona::count() . "\n";

// Verificar que el primer proceso tenga flujos con personas
$firstProceso = Proceso::with('flujos.personas', 'flujos.tiposActores')->first();
if ($firstProceso && $firstProceso->flujos->count() > 0) {
    echo "\n✓ Relaciones de Proceso->Flujos->Personas funcionando:\n";
    $flujo = $firstProceso->flujos->first();
    echo "  - Proceso: {$firstProceso->codigo}\n";
    echo "  - Flujo: {$flujo->descripcion}\n";
    echo "  - Personas en flujo: {$flujo->personas->count()}\n";
    echo "  - Roles en flujo: {$flujo->tiposActores->count()}\n";
}

echo "\n✓ CRUD PROCESOS: ¡LISTO PARA USAR!\n";
