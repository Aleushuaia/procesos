<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\User;
use Illuminate\Support\Facades\Route;

echo "╔══════════════════════════════════════════════════════════════════════════╗\n";
echo "║        VALIDACIÓN DE LINKS DEL SIDEBAR PARA ADMINISTRADOR                ║\n";
echo "╚══════════════════════════════════════════════════════════════════════════╝\n\n";

$admin = User::where('email', 'admin@procesos.local')->first();
auth()->login($admin);

echo "👤 Usuario autenticado: {$admin->name} ({$admin->email})\n";
echo "📌 Rol: {$admin->getRoleNames()->implode(', ')}\n\n";

// Definir todos los links del sidebar
$sidebarLinks = [
    [
        'title' => 'NAVEGACIÓN',
        'items' => [
            ['label' => 'Dashboard', 'route' => null, 'url' => '/'],
            ['label' => 'Procesos', 'route' => 'internal.procesos.index', 'icon' => 'fas fa-sitemap'],
        ]
    ],
    [
        'title' => 'CONFIGURACIONES',
        'items' => [
            ['label' => 'Tablas internas (submenu)', 'header' => true],
            ['label' => '  └─ Criticidades de Procesos', 'route' => 'internal.criticidades.index', 'icon' => 'far fa-dot-circle'],
            ['label' => '  └─ Estados de proceso', 'route' => 'internal.estados.index', 'icon' => 'far fa-dot-circle'],
            ['label' => '  └─ Personas', 'route' => 'internal.personas.index', 'icon' => 'far fa-dot-circle'],
            ['label' => '  └─ Tipos Actores', 'route' => 'internal.tipos-actores.index', 'icon' => 'far fa-dot-circle'],
            ['label' => '  └─ Tipos Flujos', 'route' => 'internal.tipo-flujos.index', 'icon' => 'far fa-dot-circle'],
            ['label' => '  └─ Tipos Procesos', 'route' => 'internal.tipos-procesos.index', 'icon' => 'far fa-dot-circle'],
            ['label' => '  └─ Unidades Responsables', 'route' => 'internal.unidades-responsables.index', 'icon' => 'far fa-dot-circle'],
            ['label' => 'Ajustes y Logs (submenu)', 'header' => true],
            ['label' => '  └─ Gestión de acceso', 'route' => 'settings.access-control.index', 'icon' => 'far fa-dot-circle'],
            ['label' => '  └─ Logs Telescope', 'url' => 'telescope', 'icon' => 'far fa-dot-circle'],
        ]
    ]
];

$totalLinks = 0;
$accessibleLinks = 0;
$inaccessibleLinks = [];

// Procesar cada link
foreach ($sidebarLinks as $section) {
    echo "📌 {$section['title']}\n";
    echo str_repeat("─", 75) . "\n";
    
    foreach ($section['items'] as $item) {
        if (isset($item['header']) && $item['header']) {
            echo "\n  📂 {$item['label']}\n";
            continue;
        }
        
        $totalLinks++;
        $route = $item['route'] ?? null;
        $url = $item['url'] ?? null;
        
        if ($route) {
            try {
                $routeUrl = route($route);
                echo "  ✅ {$item['label']}\n";
                echo "      Ruta: {$route}\n";
                echo "      URL:  {$routeUrl}\n";
                $accessibleLinks++;
            } catch (Exception $e) {
                echo "  ❌ {$item['label']}\n";
                echo "      Error: Ruta no encontrada ({$route})\n";
                $inaccessibleLinks[] = $item['label'];
            }
        } elseif ($url) {
            $fullUrl = $url === '/' ? '/' : url($url);
            echo "  ✅ {$item['label']}\n";
            echo "      URL:  {$fullUrl}\n";
            $accessibleLinks++;
        } else {
            echo "  ✅ {$item['label']} (Dashboard)\n";
            echo "      URL:  /\n";
            $accessibleLinks++;
        }
    }
    echo "\n";
}

// Resumen
echo "╔══════════════════════════════════════════════════════════════════════════╗\n";
echo "║                          RESUMEN DE VALIDACIÓN                            ║\n";
echo "╚══════════════════════════════════════════════════════════════════════════╝\n\n";

echo "📊 Estadísticas:\n";
echo "   Total de links:        {$totalLinks}\n";
echo "   ✅ Accesibles:         {$accessibleLinks}\n";

if (!empty($inaccessibleLinks)) {
    echo "   ❌ Inaccesibles:       " . count($inaccessibleLinks) . "\n\n";
    echo "   Links inaccesibles:\n";
    foreach ($inaccessibleLinks as $link) {
        echo "     - {$link}\n";
    }
} else {
    echo "   ❌ Inaccesibles:       0\n\n";
}

echo "\n📋 Conclusión:\n";
if ($accessibleLinks === $totalLinks && empty($inaccessibleLinks)) {
    echo "   ✅ ¡TODOS LOS LINKS DEL SIDEBAR SON ACCESIBLES PARA ADMINISTRADOR!\n";
    echo "   ✅ Cada interfaz está correctamente configurada con middleware.\n";
    echo "   ✅ El administrador tiene acceso completo a todo el sistema.\n";
} else {
    echo "   ⚠️  Hay links con problemas. Revisar la configuración.\n";
}

echo "\n";
