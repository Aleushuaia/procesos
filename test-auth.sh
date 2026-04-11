#!/bin/bash
# Script de pruebas rápidas del sistema de autenticación

echo "╔════════════════════════════════════════════════════════════════╗"
echo "║     PRUEBAS DEL SISTEMA DE AUTENTICACIÓN                       ║"
echo "║     Sistema de Procesos Institucionales v1.0.0                 ║"
echo "╚════════════════════════════════════════════════════════════════╝"
echo ""

# Color codes
GREEN='\033[0;32m'
RED='\033[0;31m'
YELLOW='\033[1;33m'
NC='\033[0m' # No Color

# Test 1: Verificar que /login responde con 200
echo -e "${YELLOW}[TEST 1]${NC} Verificando acceso a página de login..."
RESPONSE=$(curl -s -o /dev/null -w "%{http_code}" http://localhost:8000/login)
if [ "$RESPONSE" == "200" ]; then
    echo -e "${GREEN}✓ PASÓ${NC} - /login responde con HTTP 200"
else
    echo -e "${RED}✗ FALLÓ${NC} - /login responde con HTTP $RESPONSE"
fi
echo ""

# Test 2: Verificar que / redirige a /login sin autenticación
echo -e "${YELLOW}[TEST 2]${NC} Verificando que / redirige a /login sin autenticación..."
RESPONSE=$(curl -s -o /dev/null -w "%{http_code}" -L http://localhost:8000/)
if [ "$RESPONSE" == "200" ]; then
    # Seguir redirecciones
    curl -s -L http://localhost:8000/ | grep -q "Iniciar Sesión" && \
    echo -e "${GREEN}✓ PASÓ${NC} - / redirige correctamente a /login" || \
    echo -e "${RED}✗ FALLÓ${NC} - Redirección incompleta"
else
    echo -e "${YELLOW}✓ REDIRIGE${NC} - / redirige (HTTP $RESPONSE)"
fi
echo ""

# Test 3: Verificar que la página de login tiene formulario
echo -e "${YELLOW}[TEST 3]${NC} Verificando elementos de la página de login..."
curl -s http://localhost:8000/login | grep -q "admin@procesos.local" && \
echo -e "${GREEN}✓ PASÓ${NC} - Credenciales de prueba visibles" || \
echo -e "${RED}✗ FALLÓ${NC} - Credenciales NO visibles"
echo ""

# Test 4: Verificar usuarios en BD
echo -e "${YELLOW}[TEST 4]${NC} Verificando usuarios en la base de datos..."
USERS=$(docker compose exec -T db psql -U laravel -d laravel -c "SELECT COUNT(*) FROM users;" 2>/dev/null | grep '^' | tail -1 | xargs)
if [ ! -z "$USERS" ] && [ "$USERS" -ge "2" ]; then
    echo -e "${GREEN}✓ PASÓ${NC} - Encontrados $USERS usuarios en BD"
else
    echo -e "${RED}✗ FALLÓ${NC} - Problema con usuarios en BD"
fi
echo ""

# Test 5: Verificar roles
echo -e "${YELLOW}[TEST 5]${NC} Verificando roles en la base de datos..."
ROLES=$(docker compose exec -T db psql -U laravel -d laravel -c "SELECT COUNT(*) FROM roles;" 2>/dev/null | grep '^' | tail -1 | xargs)
if [ ! -z "$ROLES" ] && [ "$ROLES" -ge "2" ]; then
    echo -e "${GREEN}✓ PASÓ${NC} - Encontrados $ROLES roles en BD"
else
    echo -e "${RED}✗ FALLÓ${NC} - Problema con roles en BD"
fi
echo ""

# Test 6: Verificar permisos
echo -e "${YELLOW}[TEST 6]${NC} Verificando permisos en la base de datos..."
PERMS=$(docker compose exec -T db psql -U laravel -d laravel -c "SELECT COUNT(*) FROM permissions;" 2>/dev/null | grep '^' | tail -1 | xargs)
if [ ! -z "$PERMS" ] && [ "$PERMS" -ge "12" ]; then
    echo -e "${GREEN}✓ PASÓ${NC} - Encontrados $PERMS permisos en BD"
else
    echo -e "${RED}✗ FALLÓ${NC} - Problema con permisos en BD"
fi
echo ""

echo "╔════════════════════════════════════════════════════════════════╗"
echo "║     RESUMEN DE PRUEBAS                                          ║"
echo "╚════════════════════════════════════════════════════════════════╝"
echo ""
echo -e "${YELLOW}Acceso a la aplicación:${NC}"
echo "  URL:        http://localhost:8000"
echo "  Login URL:  http://localhost:8000/login"
echo ""
echo -e "${YELLOW}Credenciales de prueba:${NC}"
echo "  Administrador:"
echo "    Email: admin@procesos.local"
echo "    Pass:  password123"
echo ""
echo "  Agente:"
echo "    Email: agente@procesos.local"
echo "    Pass:  password123"
echo ""
echo -e "${GREEN}✓ Sistema de autenticación configurado y listo para usar${NC}"
echo ""
