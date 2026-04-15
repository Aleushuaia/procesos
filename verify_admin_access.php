<?php

require_once __DIR__ . '/src/vendor/autoload.php';
require_once __DIR__ . '/src/bootstrap/app.php';

use App\Models\User;
use Illuminate\Support\Facades\Auth;

// ========================================
// PRUEBA EXHAUSTIVA DE ACCESO ADMINISTRADOR
// ========================================

echo "========================================\n";
echo "PRUEBA DE ACCESO DEL ADMINISTRADOR\n";
echo "========================================\n\n";

// 1. Verificar usuarios
echo "1. VERIFICANDO USUARIOS EN LA BD...\n";
$admin = User::where('email', 'admin@procesos.local')->first();
$agent = User::where('email', 'agente@procesos.local')->first();

if ($admin) {
    echo "   [OK] Usuario Administrador encontrado: " . $admin->name . "\n";
    echo "        Email: " . $admin->email . "\n";
    echo "        Roles: " . $admin->roles->pluck('name')->implode(', ') . "\n";
} else {
    echo "   [ERROR] Usuario Administrador no encontrado\n";
    exit(1);
}

if ($agent) {
    echo "   [OK] Usuario Agente encontrado: " . $agent->name . "\n";
    echo "        Email: " . $agent->email . "\n";
    echo "        Roles: " . $agent->roles->pluck('name')->implode(', ') . "\n";
} else {
    echo "   [ERROR] Usuario Agente no encontrado\n";
}

// 2. Verificar permisos
echo "\n2. VERIFICANDO PERMISOS DEL ADMINISTRADOR...\n";
$adminPermissions = $admin->permissions;
echo "   Total de permisos asignados: " . $adminPermissions->count() . "\n";
echo "   Permisos:\n";
foreach ($adminPermissions as $perm) {
    echo "     - " . $perm->name . "\n";
}

// 3. Verificar acceso vía Auth
echo "\n3. SIMULANDO ACCESO CON ADMINISTRADOR...\n";
Auth::login($admin, false);

if (Auth::check()) {
    echo "   [OK] Autenticación simulada correctamente\n";
    echo "   Usuario autenticado: " . Auth::user()->name . "\n";
    echo "   Tiene rol Administrador: " . (Auth::user()->hasRole('Administrador') ? 'SÍ' : 'NO') . "\n";
} else {
    echo "   [ERROR] No se pudo autenticar\n";
}

// 4. Verificar acceso a rutas/permisos
echo "\n4. VERIFICANDO ACCESO A FUNCIONALIDADES...\n";

$features = [
    'procesos.view' => 'Ver Procesos',
    'procesos.create' => 'Crear Procesos',
    'procesos.edit' => 'Editar Procesos',
    'procesos.delete' => 'Eliminar Procesos',
    'criticidades.view' => 'Ver Criticidades',
    'criticidades.create' => 'Crear Criticidades',
    'estados.view' => 'Ver Estados',
    'estados.create' => 'Crear Estados',
    'personas.view' => 'Ver Personas',
    'personas.create' => 'Crear Personas',
    'tipos-actores.view' => 'Ver Tipos Actores',
    'tipos-actores.create' => 'Crear Tipos Actores',
    'tipo-flujos.view' => 'Ver Tipos Flujos',
    'tipo-flujos.create' => 'Crear Tipos Flujos',
    'tipos-procesos.view' => 'Ver Tipos Procesos',
    'tipos-procesos.create' => 'Crear Tipos Procesos',
    'unidades-responsables.view' => 'Ver Unidades Responsables',
    'unidades-responsables.create' => 'Crear Unidades Responsables',
    'access-control.view' => 'Ver Control de Acceso',
    'access-control.manage' => 'Gestionar Control de Acceso',
];

$granted = 0;
$denied = 0;

foreach ($features as $permission => $description) {
    if (Auth::user()->can($permission)) {
        echo "   [OK] $description\n";
        $granted++;
    } else {
        echo "   [DENY] $description\n";
        $denied++;
    }
}

echo "\n========================================\n";
echo "RESUMEN DE PERMISOS\n";
echo "========================================\n";
echo "Permisos otorgados: $granted\n";
echo "Permisos denegados: $denied\n";

if ($denied == 0) {
    echo "\n✓ ADMINISTRADOR TIENE ACCESO COMPLETO A TODAS LAS FUNCIONALIDADES\n";
} else {
    echo "\n✗ ADVERTENCIA: Algunos permisos están denegados\n";
}

echo "\n========================================\n";

?>
