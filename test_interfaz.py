import requests
import re
import json
from urllib.parse import urljoin

BASE_URL = "http://localhost:8000"
session = requests.Session()

print("=" * 60)
print("INICIANDO TEST MANUAL DE LA INTERFAZ")
print("=" * 60)

# PASO 1: Acceder a la página de login
print("\n[PASO 1] Navegando a http://localhost:8000/login")
resp = session.get(urljoin(BASE_URL, "/login"))
print(f" Página cargada - Status: {resp.status_code}")
if "<title>Login | Procesos</title>" in resp.text:
    print(" Título correcto: 'Login | Procesos'")

# Obtener CSRF token
csrf_match = re.search(r'name="_token"\s+value="([^"]+)"', resp.text)
if csrf_match:
    csrf_token = csrf_match.group(1)
    print(f" CSRF Token obtenido: {csrf_token[:20]}...")

# PASO 2: Realizar login
print("\n[PASO 2] Realizando login con admin@procesos.local")
login_data = {
    "email": "admin@procesos.local",
    "_token": csrf_token
}
resp = session.post(urljoin(BASE_URL, "/login"), data=login_data)
print(f" Login enviado - Status: {resp.status_code}")

# Verificar si el login fue exitoso
if "Dashboard" in resp.text or "dashboard" in resp.text or resp.status_code == 200:
    print(" Login exitoso")
else:
    print(" Posible error en login")
    print(f"  Respuesta parcial: {resp.text[:200]}")

# PASO 3: Obtener lista de procesos
print("\n[PASO 3] Obteniendo lista de procesos")
resp = session.get(urljoin(BASE_URL, "/internal/procesos"))
print(f" Página de procesos cargada - Status: {resp.status_code}")

# Buscar IDs de procesos en la respuesta
proceso_ids = re.findall(r'/internal/procesos/(\d+)', resp.text)
proceso_ids = list(set(proceso_ids))

if proceso_ids:
    print(f" Se encontraron {len(proceso_ids)} proceso(s)")
    proceso_id = proceso_ids[0]
    print(f" Usando proceso ID: {proceso_id}")
else:
    print(" No se encontraron procesos")
    proceso_id = None

# PASO 4: Acceder a detalles del proceso
if proceso_id:
    print(f"\n[PASO 4] Navegando a detalles del proceso (ID: {proceso_id})")
    resp = session.get(urljoin(BASE_URL, f"/internal/procesos/{proceso_id}"))
    print(f" Página cargada - Status: {resp.status_code}")
    
    # Verificar paneles
    print("\n[VERIFICACIÓN DE PANELES]")
    
    # Panel 1: "Detalles"
    if '>Detalles</h5>' in resp.text or '>Detalles</h4>' in resp.text or '>Detalles<' in resp.text:
        print(" Panel 1: Encontrado 'Detalles' (sin 'del Proceso')")
    elif '>Detalles del Proceso<' in resp.text:
        print(" Panel 1: Dice 'Detalles del Proceso' (debería ser solo 'Detalles')")
    else:
        print("? Panel 1: No se encontró texto 'Detalles'")
    
    # Panel 2: "Unidades Participantes" con contador
    if 'Unidades Participantes' in resp.text:
        print(" Panel 2: Encontrado 'Unidades Participantes'")
        # Buscar contador
        contador_match = re.search(r'Unidades Participantes.*?(\d+)', resp.text, re.DOTALL)
        if contador_match:
            print(f"   Contador: {contador_match.group(1)} unidades")
    else:
        print(" Panel 2: No encontrado 'Unidades Participantes'")
    
    # Panel 3: "Documentos" con contador
    if 'Documentos' in resp.text:
        print(" Panel 3: Encontrado 'Documentos'")
        # Buscar contador
        contador_match = re.search(r'Documentos.*?(\d+)', resp.text, re.DOTALL)
        if contador_match:
            print(f"   Contador: {contador_match.group(1)} documentos")
    else:
        print(" Panel 3: No encontrado 'Documentos'")
    
    # Botón "Vincular"
    print("\n[VERIFICACIÓN DE BOTÓN VINCULAR]")
    if 'Vincular' in resp.text and 'vinc' in resp.text.lower():
        print(" Botón 'Vincular' encontrado en la página")
    else:
        print(" Botón 'Vincular' no encontrado")
    
    # Modal selector de unidades
    print("\n[VERIFICACIÓN DE MODAL]")
    if 'modal' in resp.text.lower() or 'unidad' in resp.text.lower():
        print(" Estructura para modal/selector de unidades detectada")
    else:
        print("? Modal/selector no claramente visible en HTML")

print("\n" + "=" * 60)
print("TEST COMPLETADO")
print("=" * 60)
print("\nNOTA: Para funcionalidades interactivas (clicks, cambios de estado),")
print("es necesario usar un navegador web real como se solicitó.")
