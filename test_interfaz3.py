import requests
import re
import json
from urllib.parse import urljoin
from bs4 import BeautifulSoup

BASE_URL = "http://localhost:8000"
session = requests.Session()

print("=" * 70)
print("TEST MANUAL DE LA INTERFAZ - BÚSQUEDA MEJORADA")
print("=" * 70)

# PASO 1: Login
print("\n[PASO 1] Navegando a login y autenticando...")
resp = session.get(urljoin(BASE_URL, "/login"))
csrf_match = re.search(r'name="_token"\s+value="([^"]+)"', resp.text)
csrf_token = csrf_match.group(1)

login_data = {"email": "admin@procesos.local", "_token": csrf_token}
resp = session.post(urljoin(BASE_URL, "/login"), data=login_data)
print("     Sesión iniciada")

# PASO 2: Obtener lista de procesos - búsqueda mejorada
print("\n[PASO 2] Obteniendo lista de procesos...")
resp = session.get(urljoin(BASE_URL, "/internal/procesos"))

# Usar BeautifulSoup para mejor parsing
from bs4 import BeautifulSoup
soup = BeautifulSoup(resp.text, 'html.parser')

# Buscar enlaces de procesos
proceso_ids = []
for link in soup.find_all('a', href=True):
    href = link.get('href', '')
    if '/internal/procesos/' in href:
        match = re.search(r'/internal/procesos/(\d+)$', href)
        if match:
            pid = match.group(1)
            if pid not in ['8000', '8001']:  # Evitar puertos
                proceso_ids.append(pid)

# Remover duplicados y puertos
proceso_ids = list(set([p for p in proceso_ids if p and int(p) < 1000]))

if not proceso_ids:
    # Buscar en toda la página
    all_nums = re.findall(r'/internal/procesos/(\d+)', resp.text)
    proceso_ids = list(set([p for p in all_nums if p and int(p) < 1000]))

print(f"     IDs encontrados: {proceso_ids[:5]}")

if proceso_ids:
    proceso_id = proceso_ids[0]
    print(f"     Usando proceso ID: {proceso_id}")
else:
    print("     No se encontraron procesos válidos")
    # Intentar con la API
    api_resp = session.get(urljoin(BASE_URL, "/api/procesos"))
    if api_resp.status_code == 200:
        try:
            data = api_resp.json()
            if 'data' in data and len(data['data']) > 0:
                proceso_id = str(data['data'][0]['id'])
                print(f"     Usando ID de API: {proceso_id}")
            else:
                proceso_id = None
        except:
            proceso_id = None
    else:
        proceso_id = None

# PASO 3: Acceder a detalles
if proceso_id:
    print(f"\n[PASO 3] Accediendo a detalles del proceso {proceso_id}...")
    resp = session.get(urljoin(BASE_URL, f"/internal/procesos/{proceso_id}"))
    
    if resp.status_code == 200:
        print(f"     Página cargada correctamente")
        
        # Análisis de elementos
        print("\n[VERIFICACIÓN DE ELEMENTOS]")
        
        soup = BeautifulSoup(resp.text, 'html.parser')
        
        # Buscar títulos de paneles
        h_tags = soup.find_all(['h3', 'h4', 'h5', 'h6'])
        titles = [tag.get_text(strip=True) for tag in h_tags]
        
        print("\nTítulos encontrados:")
        for i, title in enumerate(titles[:10], 1):
            print(f"    {i}. {title}")
        
        # Verificación específica
        print("\n[VERIFICACIÓN DE PANELES]")
        text_full = resp.text.lower()
        
        if 'detalles' in text_full and 'detalles del proceso' not in text_full:
            print("     Panel 1: Contiene 'Detalles' (sin 'del Proceso')")
        elif 'detalles del proceso' in text_full:
            print("     Panel 1: Contiene 'Detalles del Proceso' (incorrecto)")
        
        if 'unidades participantes' in text_full:
            print("     Panel 2: Contiene 'Unidades Participantes'")
        
        if 'documentos' in text_full:
            print("     Panel 3: Contiene 'Documentos'")
        
        # Buscar botones
        print("\n[VERIFICACIÓN DE FUNCIONALIDADES]")
        if 'vincular' in text_full:
            print("     Botón 'Vincular' presente")
        
        if 'modal' in text_full:
            print("     Estructura modal detectada")
        
        if 'eliminar' in text_full:
            print("     Funcionalidad de eliminar presente")
    else:
        print(f"     Error {resp.status_code}: {resp.text[:200]}")

print("\n" + "=" * 70)
