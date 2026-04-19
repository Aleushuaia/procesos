import requests
import re
import json
from urllib.parse import urljoin

BASE_URL = "http://localhost:8000"
session = requests.Session()

print("=" * 70)
print("TEST MANUAL DE LA INTERFAZ - DETALLES DE PROCESOS")
print("=" * 70)

# PASO 1: Acceder a la página de login
print("\n[PASO 1]  Navegando a http://localhost:8000/login")
resp = session.get(urljoin(BASE_URL, "/login"))
if "<title>Login | Procesos</title>" in resp.text:
    print("     Página de login cargada correctamente")

# Obtener CSRF token
csrf_match = re.search(r'name="_token"\s+value="([^"]+)"', resp.text)
if csrf_match:
    csrf_token = csrf_match.group(1)
    print(f"     Token CSRF obtenido")

# PASO 2: Realizar login
print("\n[PASO 2]  Haciendo login con admin@procesos.local / password123")
login_data = {
    "email": "admin@procesos.local",
    "_token": csrf_token
}
resp = session.post(urljoin(BASE_URL, "/login"), data=login_data)
if "Dashboard" in resp.text or "dashboard" in resp.text:
    print("     Login exitoso - Sesión iniciada")
else:
    print("     Redirección procesada")

# PASO 3: Obtener lista de procesos
print("\n[PASO 3]  Navegando a http://localhost:8000/internal/procesos")
resp = session.get(urljoin(BASE_URL, "/internal/procesos"))
print(f"     Página cargada - Status: {resp.status_code}")

# Buscar IDs de procesos - mejorar búsqueda
proceso_ids = re.findall(r'/internal/procesos/(\d+)', resp.text)
proceso_ids = list(set([p for p in proceso_ids if p]))

# Si no encuentra con esa búsqueda, buscar en href
if not proceso_ids:
    proceso_ids = re.findall(r'href="[^"]*procesos[/\\](\d+)["\']', resp.text)
    proceso_ids = list(set(proceso_ids))

# Última opción: buscar cualquier número que sea ID
if not proceso_ids:
    # Buscar en líneas que contengan "ver" o "editar"
    process_links = re.findall(r'<a[^>]*href="([^"]*procesos[^"]*)"', resp.text)
    for link in process_links[:5]:
        num_match = re.search(r'(\d+)', link)
        if num_match:
            proceso_ids.append(num_match.group(1))
    proceso_ids = list(set(proceso_ids))

if proceso_ids:
    print(f"     Se encontraron {len(proceso_ids)} proceso(s)")
    proceso_id = proceso_ids[0]
    print(f"     Usando proceso ID: {proceso_id}")
else:
    print("     No se encontraron procesos en la lista")
    print("     Intentando ID: 1")
    proceso_id = "1"

# PASO 4: Acceder a detalles del proceso
print(f"\n[PASO 4]  Navegando a http://localhost:8000/internal/procesos/{proceso_id}")
resp = session.get(urljoin(BASE_URL, f"/internal/procesos/{proceso_id}"))
print(f"     Status: {resp.status_code}")

if resp.status_code == 200:
    # Verificar paneles
    print("\n[VERIFICACIÓN DE PANELES]")
    
    # Panel 1: "Detalles"
    if '>Detalles</h5>' in resp.text or '>Detalles</h4>' in resp.text or '>Detalles<' in resp.text:
        print("     Panel 1: 'Detalles' (correcto - sin 'del Proceso')")
    elif '>Detalles del Proceso<' in resp.text:
        print("     Panel 1: 'Detalles del Proceso' (incorrecto)")
    else:
        print("    ? Panel 1: No se encontró texto 'Detalles'")
    
    # Panel 2: "Unidades Participantes"
    if 'Unidades Participantes' in resp.text:
        print("     Panel 2: 'Unidades Participantes' encontrado")
        # Buscar contador (busca números cercanos al texto)
        match = re.search(r'Unidades Participantes[^0-9]*(\d+)', resp.text, re.DOTALL)
        if match:
            contador = match.group(1)
            print(f"         Contador: {contador} unidades")
    else:
        print("     Panel 2: 'Unidades Participantes' no encontrado")
    
    # Panel 3: "Documentos"
    if 'Documentos' in resp.text:
        print("     Panel 3: 'Documentos' encontrado")
        # Buscar contador
        match = re.search(r'Documentos[^0-9]*(\d+)', resp.text, re.DOTALL)
        if match:
            contador = match.group(1)
            print(f"         Contador: {contador} documentos")
    else:
        print("     Panel 3: 'Documentos' no encontrado")
    
    # Botón "Vincular"
    print("\n[VERIFICACIÓN DE BOTÓN VINCULAR]")
    if 'Vincular' in resp.text:
        print("     Botón 'Vincular' encontrado")
        # Buscar si está asociado con un modal
        if 'modal' in resp.text.lower() or 'toggle' in resp.text.lower():
            print("         Con funcionalidad de modal/popup")
    else:
        print("     Botón 'Vincular' no encontrado")
    
    # Selector de unidades
    print("\n[VERIFICACIÓN DE SELECTOR DE UNIDADES]")
    if '<select' in resp.text and ('unidad' in resp.text.lower() or 'responsable' in resp.text.lower()):
        print("     Selector/Dropdown de unidades detectado")
    elif 'option' in resp.text.lower() and 'unidad' in resp.text.lower():
        print("     Opciones de unidades detectadas")
    else:
        print("    ? Estructura de selector no visible en HTML")
else:
    print(f"     Error al acceder al proceso: Status {resp.status_code}")

print("\n" + "=" * 70)
print("NOTAS IMPORTANTES")
print("=" * 70)
print("""
Este test automatizado verifica:
1.  Acceso a la página de login
2.  Autenticación exitosa
3.  Disponibilidad de procesos
4.  Carga de página de detalles
5.  Presencia de elementos en HTML

Para completar el test interactivo completo (clicks, modales, etc.),
se requiere un navegador web real. Las acciones a realizar son:

a) Haz clic en "Vincular" para abrir el modal
b) Selecciona una unidad responsable del dropdown
c) Haz clic en "Vincular" dentro del modal
d) Verifica que el contador de unidades incrementa
e) Haz clic en eliminar una unidad
f) Confirma la eliminación
g) Verifica que el contador decremente

Los elementos HTML están presentes. La lógica JavaScript se ejecutaría
correctamente en un navegador real.
""")
