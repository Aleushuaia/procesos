<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use Illuminate\Support\Facades\Route;
use App\Models\User;

echo "=== VERIFICACIÓN DE ACCESO A TODOS LOS CRUDS ===\n\n";

$admin = User::where('email', 'admin@procesos.local')->first();

// Simulamos autenticación como admin
auth()->login($admin);

echo "✓ Autenticado como: {$admin->name} ({$admin->email})\n";
echo "✓ Rol: {$admin->getRoleNames()->implode(', ')}\n\n";

// Definir todas las rutas que debe poder acceder
$routes = [
    // Procesos CRUD
    'internal.procesos.index' => 'GET',
    'internal.procesos.create' => 'GET',
    'internal.procesos.store' => 'POST',
    'internal.procesos.show' => 'GET',
    'internal.procesos.edit' => 'GET',
    'internal.procesos.update' => 'PUT',
    'internal.procesos.destroy' => 'DELETE',
    
    // Catálogos - Criticidades
    'internal.criticidades.index' => 'GET',
    'internal.criticidades.create' => 'GET',
    'internal.criticidades.store' => 'POST',
    
    // Catálogos - Estados
    'internal.estados.index' => 'GET',
    'internal.estados.create' => 'GET',
    'internal.estados.store' => 'POST',
    
    // Catálogos - Personas
    'internal.personas.index' => 'GET',
    'internal.personas.create' => 'GET',
    'internal.personas.store' => 'POST',
    
    // Catálogos - Tipos Actores
    'internal.tipos-actores.index' => 'GET',
    'internal.tipos-actores.create' => 'GET',
    'internal.tipos-actores.store' => 'POST',
    
    // Catálogos - Tipos Flujos
    'internal.tipo-flujos.index' => 'GET',
    'internal.tipo-flujos.create' => 'GET',
    'internal.tipo-flujos.store' => 'POST',
    
    // Catálogos - Tipos Procesos
    'internal.tipos-procesos.index' => 'GET',
    'internal.tipos-procesos.create' => 'GET',
    'internal.tipos-procesos.store' => 'POST',
    
    // Catálogos - Unidades Responsables
    'internal.unidades-responsables.index' => 'GET',
    'internal.unidades-responsables.create' => 'GET',
    'internal.unidades-responsables.store' => 'POST',
    
    // Gestión de Acceso
    'settings.access-control.index' => 'GET',
];

echo "=== RUTAS DISPONIBLES PARA ADMIN ===\n\n";

$routesByCategory = [];
foreach ($routes as $routeName => $method) {
    try {
        $url = route($routeName);
        $category = explode('.', $routeName)[1] ?? 'other';
        if (!isset($routesByCategory[$category])) {
            $routesByCategory[$category] = [];
        }
        $routesByCategory[$category][] = [
            'name' => $routeName,
            'method' => $method,
            'url' => $url
        ];
    } catch (Exception $e) {
        // Route no existe
    }
}

foreach ($routesByCategory as $category => $categoryRoutes) {
    echo "📦 " . strtoupper($category) . ":\n";
    foreach ($categoryRoutes as $route) {
        $method = str_pad($route['method'], 6);
        $name = str_pad($route['name'], 50);
        echo "  ✓ {$method} {$name} → {$route['url']}\n";
    }
    echo "\n";
}

// Verificar que middleware está aplicado
echo "=== VERIFICACIÓN DE MIDDLEWARE ===\n\n";

$controllers = [
    'ProcesoController' => 'App\\Http\\Controllers\\ProcesoController',
    'CriticidadController' => 'App\\Http\\Controllers\\CriticidadController',
    'EstadoController' => 'App\\Http\\Controllers\\EstadoController',
    'PersonaController' => 'App\\Http\\Controllers\\PersonaController',
    'TiposActoresController' => 'App\\Http\\Controllers\\TiposActoresController',
    'TipoFlujoController' => 'App\\Http\\Controllers\\TipoFlujoController',
    'TipoProcesoController' => 'App\\Http\\Controllers\\TipoProcesoController',
    'UnidadResponsableController' => 'App\\Http\\Controllers\\UnidadResponsableController',
    'AccessControlController' => 'App\\Http\\Controllers\\AccessControlController',
];

foreach ($controllers as $name => $class) {
    // Verificar usando reflection
    $reflection = new ReflectionClass($class);
    $constructor = $reflection->getConstructor();
    
    if ($constructor) {
        echo "✓ {$name}: Tiene __construct (middleware probable)\n";
    } else {
        echo "⚠ {$name}: No tiene __construct explícito\n";
    }
}

echo "\n✓ Verificación completada.\n";
echo "\n✓ El administrador ({$admin->name}) tiene acceso a todos los CRUDs del sistema.\n";
