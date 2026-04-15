<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

$role = Spatie\Permission\Models\Role::where('name', 'Administrador')->first();
if (! $role) {
    echo "Role not found\n";
    exit(1);
}

echo json_encode($role->toArray()) . PHP_EOL;
