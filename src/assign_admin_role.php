<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\User;

$u = User::where('email', 'admin@procesos.local')->first();
if ($u) {
    $u->assignRole('Administrador');
    echo "Rol asignado a: {$u->email}\n";
    echo "Roles actuales: " . $u->getRoleNames()->implode(', ') . "\n";
} else {
    echo "Usuario admin@procesos.local no encontrado\n";
}
