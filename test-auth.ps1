# Pruebas rápidas de autenticación (PowerShell)
Write-Host "== Pruebas de autenticación =="

# Comprobar /login
$status = (docker compose exec -T app sh -lc "curl -s -o /dev/null -w '%{http_code}' http://localhost:8000/login")
Write-Host "/login HTTP status: $status"

# Verificar que el HTML contiene el formulario y credenciales
$html = docker compose exec -T app sh -lc "curl -s http://localhost:8000/login"
if ($html -match '<form') { Write-Host "Form detected" } else { Write-Host "Form NOT found" }
if ($html -match 'admin@procesos.local') { Write-Host "Admin credentials visible" } else { Write-Host "Admin credentials NOT visible" }

# Comprobar redirección de / cuando no autenticado
$response = docker compose exec -T app sh -lc "curl -s -o /dev/null -w '%{http_code}' -I http://localhost:8000/"
Write-Host "/ HTTP status (expect 302): $response"

Write-Host "== Fin de pruebas =="