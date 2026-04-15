<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\User;

$admin = User::where('email', 'admin@procesos.local')->first();

if ($admin) {
    echo "✓ Admin usuario: {$admin->name}\n";
    echo "✓ Email: {$admin->email}\n";
    $roles = $admin->getRoleNames();
    echo "✓ Roles: " . $roles->implode(', ') . "\n";
    echo "✓ Total permisos: " . count($admin->getAllPermissions()) . "\n";
} else {
    echo "✗ No admin encontrado\n";
}

// Verificar procesos
$procesosCount = \App\Models\Proceso::count();
echo "\n✓ Procesos en BD: {$procesosCount}\n";

// Verificar flujos
$flujoCount = \App\Models\Flujo::count();
echo "✓ Flujos en BD: {$flujoCount}\n";

// Verificar personas
$personasCount = \App\Models\Persona::count();
echo "✓ Personas en BD: {$personasCount}\n";
