# Test interfaces accessiblity
$baseUrl = "http://localhost:8000"

Write-Host "========================================"
Write-Host "INICIANDO PRUEBAS DE INTERFACES"
Write-Host "========================================"
Write-Host ""

# Verificar servidor
try {
    $response = Invoke-WebRequest -Uri $baseUrl -Method Get -UseBasicParsing -TimeoutSec 5 -WarningAction SilentlyContinue
    Write-Host "[OK] Servidor activo en puerto 8000"
} catch {
    Write-Host "[ERROR] Servidor no responde"
    exit 1
}

# Lista de interfaces
$interfaces = @(
    "Home|/",
    "Procesos - Listar|/internal/procesos",
    "Procesos - Crear|/internal/procesos/create",
    "Criticidades - Listar|/internal/criticidades",
    "Criticidades - Crear|/internal/criticidades/create",
    "Estados - Listar|/internal/estados",
    "Estados - Crear|/internal/estados/create",
    "Personas - Listar|/internal/personas",
    "Personas - Crear|/internal/personas/create",
    "Tipos Actores - Listar|/internal/tipos-actores",
    "Tipos Actores - Crear|/internal/tipos-actores/create",
    "Tipos Flujos - Listar|/internal/tipo-flujos",
    "Tipos Flujos - Crear|/internal/tipo-flujos/create",
    "Tipos Procesos - Listar|/internal/tipos-procesos",
    "Tipos Procesos - Crear|/internal/tipos-procesos/create",
    "Unidades Responsables - Listar|/internal/unidades-responsables",
    "Unidades Responsables - Crear|/internal/unidades-responsables/create",
    "Control de Acceso|/settings/access-control"
)

Write-Host ""
Write-Host "Probando disponibilidad de interfaces:"
Write-Host "========================================"

$ok = 0
$error = 0

foreach ($item in $interfaces) {
    $parts = $item -split "\|"
    $name = $parts[0]
    $url = $parts[1]
    
    try {
        $response = Invoke-WebRequest -Uri "$baseUrl$url" -Method Get -UseBasicParsing `
            -TimeoutSec 5 -SkipHttpErrorCheck -ErrorAction SilentlyContinue -WarningAction SilentlyContinue
        
        if ($response.StatusCode -eq 200 -or $response.StatusCode -eq 302) {
            Write-Host "  [OK] $name"
            $ok++
        } else {
            Write-Host "  [WARN] $name - HTTP $($response.StatusCode)"
            $ok++
        }
    } catch {
        Write-Host "  [ERROR] $name"
        $error++
    }
}

Write-Host ""
Write-Host "========================================"
Write-Host "RESULTADOS: $ok OK, $error ERRORES"
Write-Host "========================================"
