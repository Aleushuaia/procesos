<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\User;
use Spatie\Permission\Models\Role;

echo "=== VERIFICACIÓN DE PERMISOS Y ROLES ===\n\n";

// Verificar admin
$admin = User::where('email', 'admin@procesos.local')->first();
echo "✓ Usuario Admin:\n";
echo "  - Email: {$admin->email}\n";
echo "  - Nombre: {$admin->name}\n";

$roles = $admin->getRoleNames();
echo "  - Roles asignados: " . $roles->implode(', ') . "\n";

// Mostrar todas las roles en el sistema
echo "\n✓ Todos los Roles en el Sistema:\n";
$allRoles = Role::all();
foreach ($allRoles as $role) {
    echo "  - {$role->name}\n";
}

// Verificar permisos del admin
echo "\n✓ Permisos del Admin:\n";
$permisos = $admin->getAllPermissions();
if ($permisos->count() > 0) {
    foreach ($permisos as $permiso) {
        echo "  - {$permiso->name}\n";
    }
} else {
    echo "  - (ningún permiso directo)\n";
}

// Test acceso a rutas
echo "\n✓ Verificación de Rutas de Acceso:\n";
$rutas = [
    'internal.procesos.index' => 'Procesos',
    'internal.criticidades.index' => 'Criticidades',
    'internal.estados.index' => 'Estados',
    'internal.personas.index' => 'Personas',
    'internal.tipos-actores.index' => 'Tipos Actores',
    'internal.tipo-flujos.index' => 'Tipos Flujos',
    'internal.tipos-procesos.index' => 'Tipos Procesos',
    'internal.unidades-responsables.index' => 'Unidades Responsables',
    'settings.access-control.index' => 'Gestión de Acceso',
];

foreach ($rutas as $routeName => $label) {
    try {
        $url = route($routeName);
        echo "  ✓ {$label}: {$routeName} → {$url}\n";
    } catch (Exception $e) {
        echo "  ✗ {$label}: RUTA NO ENCONTRADA\n";
    }
}

echo "\n✓ Verificación completada.\n";
