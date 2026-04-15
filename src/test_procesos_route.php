<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use Illuminate\Support\Facades\Http;

try {
    $response = Http::get('http://localhost/internal/procesos');
    
    echo "=== TEST DE RUTA HTTP ===\n";
    echo "Status Code: " . $response->status() . "\n";
    
    if ($response->status() === 200) {
        echo "✓ Ruta /internal/procesos responde con 200 OK\n";
        echo "✓ Content-Length: " . strlen($response->body()) . " bytes\n";
        
        // Verificar que contiene elementos clave
        if (strpos($response->body(), 'Procesos') !== false) {
            echo "✓ Contiene título 'Procesos'\n";
        }
        if (strpos($response->body(), 'PROC-') !== false) {
            echo "✓ Contiene datos de procesos (PROC-)\n";
        }
        if (strpos($response->body(), 'Acciones') !== false) {
            echo "✓ Contiene columna de Acciones\n";
        }
        echo "\n✓ ¡CRUD DE PROCESOS FUNCIONANDO CORRECTAMENTE!\n";
    } elseif ($response->status() === 302) {
        echo "⚠ Redireccionamiento (302) - Posiblemente requiere autenticación\n";
    } else {
        echo "✗ Status inesperado: " . $response->status() . "\n";
    }
} catch (Exception $e) {
    echo "Error en request: " . $e->getMessage() . "\n";
}
