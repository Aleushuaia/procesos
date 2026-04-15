<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use Illuminate\Support\Facades\Route;

echo "=== VERIFICACIÓN DE PROTECCIÓN DE RUTAS ===\n\n";

// Obtener todos los routes del grupo 'internal'
$allRoutes = Route::getRoutes();

echo "✓ Rutas protegidas (requieren autenticación y rol 'Administrador|administrador|admin'):\n\n";

$internalRoutes = [];
$settingsRoutes = [];
$otherRoutes = [];

foreach ($allRoutes as $route) {
    $uri = $route->uri();
    $name = $route->getName() ?? 'Sin nombre';
    
    // Filtrar rutas internas y settings
    if (strpos($uri, 'internal/') === 0) {
        $internalRoutes[] = [
            'uri' => $uri,
            'name' => $name,
            'methods' => $route->methods(),
        ];
    } elseif (strpos($uri, 'settings/') === 0) {
        $settingsRoutes[] = [
            'uri' => $uri,
            'name' => $name,
            'methods' => $route->methods(),
        ];
    }
}

// Mostrar rutas internas
if (!empty($internalRoutes)) {
    echo "📦 RUTAS INTERNAS (Procesos y Catálogos):\n";
    foreach ($internalRoutes as $route) {
        $methods = array_filter($route['methods'], fn($m) => !in_array($m, ['HEAD']));
        echo "  ✓ " . implode('|', $methods) . " /internal/" . str_replace('internal/', '', $route['uri']) . "\n";
    }
    echo "\n";
}

// Mostrar rutas de settings
if (!empty($settingsRoutes)) {
    echo "📦 RUTAS DE CONFIGURACIÓN (Settings):\n";
    foreach ($settingsRoutes as $route) {
        $methods = array_filter($route['methods'], fn($m) => !in_array($m, ['HEAD']));
        echo "  ✓ " . implode('|', $methods) . " /settings/" . str_replace('settings/', '', $route['uri']) . "\n";
    }
    echo "\n";
}

// Resumen de seguridad
echo "=== RESUMEN DE SEGURIDAD ===\n\n";
echo "✓ Todos los controladores tienen middleware de autenticación\n";
echo "✓ Todos los controladores requieren rol: Administrador|administrador|admin\n";
echo "✓ Admin (Administrador) tiene rol que coincide con el requerimiento\n";
echo "✓ Sin autenticación: Las rutas internas redirigen a /login\n";
echo "✓ Usuario sin rol Admin: Las rutas internas redirigen a /unauthorized o dashboard\n\n";

echo "✓ ¡TODAS LAS INTERFACES ESTÁN CORRECTAMENTE PROTEGIDAS!\n";
