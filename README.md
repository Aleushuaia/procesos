# 🎯 Sistema de Procesos Institucionales - Documentación

## 📋 Descripción

Sistema web profesional desarrollado con **Laravel 13.4.0** y **AdminLTE 3.2.0**, diseñado para la gestión de procesos a nivel institucional/judicial con control de acceso basado en roles (RBAC).

---

## 🚀 Características Principales

### ✅ Autenticación y Autorización
- Sistema de login seguro con Laravel Auth
- Gestión de roles y permisos con **Spatie Laravel Permission v7.3.0**
- Control de acceso basado en roles (RBAC)
- 2 roles predefinidos: **Administrador** y **Agente**
- 12 permisos organizados por módulos (procesos, usuarios, reportes)

### ✅ Interfaz de Usuario
- **AdminLTE 3.2.0**: Tema administrativo profesional
- **Dark Mode / Light Mode**: Toggle con persistencia en localStorage
- **Responsive Design**: Compatible con todos los dispositivos
- Dashboard con widgets de información
- Sidebar dinámico según rol del usuario

### ✅ Gestión de Acceso
- Interface gráfica para administrar roles
- Matriz de permisos editable
- Asignación de roles a usuarios
- CRUD completo para roles (validado en backend)

### ✅ Infraestructura
- **Docker Compose**: Ambiente completamente containerizado
- **PostgreSQL 18.3**: Base de datos con timezone configurado
- **PHP 8.3**: Última versión estable de PHP
- Volúmenes persistentes para datos

---

## 🔐 Credenciales de Prueba

### Administrador
```
Email: admin@procesos.local
Contraseña: password123
Permisos: TODOS (12/12)
```

### Agente
```
Email: agente@procesos.local
Contraseña: password123
Permisos: 3 (procesos.view, procesos.create, reports.view)
```

---

## 📦 Stack Tecnológico

| Componente | Versión |
|-----------|---------|
| Laravel | 13.4.0 |
| PHP | 8.3.30 |
| PostgreSQL | 18.3 |
| AdminLTE | 3.2.0 |
| Bootstrap | 4.6.2 |
| jQuery | 3.6.0 |
| FontAwesome | 5.15.4 |

---

## 🗂️ Estructura del Proyecto

```
src/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── AuthController.php          # Login/Logout
│   │   │   ├── HomeController.php          # Dashboard
│   │   │   └── AccessControlController.php # RBAC Management
│   │   └── Middleware/
│   │       └── RedirectIfAuthenticated.php # Redirige autenticados a /
│   └── Models/
│       └── User.php                        # Modelo de usuario con roles
├── database/
│   ├── migrations/                         # Esquema de BD
│   └── seeders/
│       ├── PermissionsSeeder.php          # Crea 12 permisos
│       ├── RolesSeeder.php                # Crea 2 roles con permisos
│       └── DatabaseSeeder.php             # Crea usuarios de prueba
├── resources/
│   └── views/
│       ├── auth/
│       │   └── login.blade.php             # Formulario de login
│       ├── layouts/
│       │   └── app.blade.php               # Layout maestro
│       ├── home.blade.php                  # Dashboard
│       └── settings/
│           └── access-control.blade.php    # Gestión de acceso
├── routes/
│   └── web.php                             # Definición de rutas
└── public/
    ├── css/
    │   ├── app.css                         # Estilos personalizados
    │   └── adminlte.min.css                # AdminLTE
    ├── js/
    │   ├── app.js                          # Dark mode toggle
    │   ├── access-control.js               # AJAX de control de acceso
    │   └── adminlte.min.js
    └── plugins/                            # Assets descargados (jQuery, Bootstrap, etc)
```

---

## 🛠️ Instalación y Ejecución

### Requisitos Previos
- Docker y Docker Compose instalados
- Git (opcional)

### Pasos para Ejecutar

#### 1. Entrar a la carpeta del proyecto
```bash
cd c:\laravel\procesos
```

#### 2. Iniciar los contenedores
```bash
docker compose up --build
```

Esto hará:
- Construir imagen de PHP 8.3 con extensiones
- Descargará PostgreSQL 18.3
- Ejecutará migrations automáticamente
- Poblará la BD con datos de prueba

#### 3. Acceder a la aplicación
```
URL: http://localhost:8000
```

#### 4. Login
Usa las credenciales de prueba arriba mencionadas.

---

## 📖 Rutas Disponibles

### Públicas (sin autenticación)
| Método | Ruta | Controlador | Descripción |
|--------|------|-------------|------------|
| GET | `/login` | AuthController@showLogin | Mostrar formulario de login |
| POST | `/login` | AuthController@login | Procesar login |

### Protegidas (requieren autenticación)
| Método | Ruta | Controlador | Descripción |
|--------|------|-------------|------------|
| GET | `/` | HomeController@index | Dashboard |
| POST | `/logout` | AuthController@logout | Cerrar sesión |

### Amministrador (requieren rol: administrador)
| Método | Ruta | Controlador | Descripción |
|--------|------|-------------|------------|
| GET | `/settings/access-control` | AccessControlController@index | Interface de gestión de acceso |
| GET | `/settings/access-control/role/{id}` | AccessControlController@getRoleDetails | Obtener permisos de rol (JSON) |
| POST | `/settings/access-control/role/{id}/permissions` | AccessControlController@updateRolePermissions | Actualizar permisos un rol |
| POST | `/settings/access-control/role` | AccessControlController@createRole | Crear nuevo rol |
| DELETE | `/settings/access-control/role/{id}` | AccessControlController@deleteRole | Eliminar rol |
| POST | `/settings/access-control/user/{id}/role` | AccessControlController@assignRoleToUser | Asignar rol a usuario |
| DELETE | `/settings/access-control/user/{id}/role` | AccessControlController@removeRoleFromUser | Remover rol de usuario |

---

## 🎨 Funcionalidades de Interfaz

### Dark Mode / Light Mode
- Toggle en navbar superior derecha
- Persiste en localStorage
- Se aplica automáticamente al cargar la página
- No causa "flash of unstyled content" (FOUC)

### Menú Usuario
- Dropdown en navbar
- Muestra nombre del usuario autenticado
- Opciones: Mi Perfil, Configuración, Cerrar Sesión
- Botón de logout funcional

### Sidebar Dinámico
- "Dashboard" visible para todos
- "Gestión de acceso" solo para administradores
- Usa directiva `@role('administrador')` de Spatie

### Gestión de Acceso (Admin)
- **Tab 1 - Roles**: Tabla editable de roles, asignación a usuarios
- **Tab 2 - Permisos**: Matriz de módulos vs acciones, toggle dinámico
- **Tab 3 - Usuarios**: Lista de usuarios con asignación de roles
- Validaciones en frontend y backend
- Mensajes de error y éxito

---

## 🔒 Seguridad

### Implementaciones
- CSRF token en todos los formularios
- Password hashing con Bcrypt
- Regeneración de session ID en login
- Invalidación de sesión en logout
- Validación en servidor (no confiar en cliente)
- Middleware `auth` para proteger rutas
- Middleware `role:administrador` para rutas sensibles

### Permisos Predefinidos (12 total)
```
procesos:
  - view      (ver procesos)
  - create    (crear procesos)
  - update    (editar procesos)
  - delete    (eliminar procesos)

usuarios:
  - view      (ver usuarios)
  - create    (crear usuarios)
  - update    (editar usuarios)
  - delete    (eliminar usuarios)

reports:
  - view      (ver reportes)
  - create    (crear reportes)
  - update    (editar reportes)
  - delete    (eliminar reportes)
```

---

## 📊 Base de Datos

### Tablas Principales
- `users` - Usuarios del sistema
- `roles` - Definición de roles
- `permissions` - Definición de permisos
- `role_has_permissions` - Relación roles ↔ permisos (Spatie)
- `model_has_roles` - Relación usuarios ↔ roles (Spatie)
- `sessions` - Sesiones de usuario
- `cache` - Caché de aplicación
- `jobs` - Cola de trabajos

### Credenciales BD
```
Host: db (dentro de Docker)
Puerto: 5432
Usuario: laravel
Contraseña: root
Base de datos: laravel
Timezone: America/Argentina/Buenos_Aires
```

---

## 🚦 Comandos Útiles

### En el contenedor de aplicación
```bash
# Ver estado de migrations
docker compose exec app php artisan migrate:status

# Ejecutar seeders
docker compose exec app php artisan db:seed

# Resetear BD completamente
docker compose exec app php artisan migrate:fresh --seed

# Acceder a Tinker (consola interactiva)
docker compose exec app php artisan tinker

# Ver logs
docker compose logs app -f --tail=50
```

### En PostgreSQL
```bash
# Conectarse a la BD
docker compose exec -T db psql -U laravel -d laravel

# Ver usuarios
SELECT id, name, email FROM users;

# Ver roles de un usuario
SELECT u.name, r.name as role FROM users u 
LEFT JOIN model_has_roles mr ON u.id = mr.model_id 
LEFT JOIN roles r ON mr.role_id = r.id;

# Ver permisos de un rol
SELECT DISTINCT r.name as role, p.name as permission 
FROM roles r 
LEFT JOIN role_has_permissions rp ON r.id = rp.role_id 
LEFT JOIN permissions p ON rp.permission_id = p.id 
WHERE r.name = 'administrador';
```

---

## 🐛 Troubleshooting

### "Error: relation sessions does not exist"
**Solución:** Ejecutar migrations
```bash
docker compose exec app php artisan migrate
```

### "Error: no route matches"
**Solución:** Verificar rutas y middleware
```bash
docker compose exec app php artisan route:list
```

### "Error: table cache has no column"
**Solución:** Crear tabla de cache
```bash
docker compose exec app php artisan cache:table && php artisan migrate
```

### Contenedores no responden
**Solución:** Reiniciar
```bash
docker compose down
docker compose up --build
```

---

## 📝 Próximas Características Recomendadas

1. **Módulo de Procesos**: CRUD para procesos judiciales
2. **Módulo de Usuarios**: Gestión completa de usuarios
3. **Módulo de Reportes**: Generación de reportes en PDF
4. **Auditoría**: Log de todas las acciones
5. **Notificaciones**: Email y notificaciones en tiempo real
6. **API REST**: Endpoints JSON para mobile apps
7. **Two-Factor Authentication**: Mayor seguridad
8. **File Management**: Gestión de documentos adjuntos

---

## 📄 Licencia

Este proyecto es de uso interno para fines institucionales/judiciales.

---

## ℹ️ Información de Contacto

Para soporte técnico, contactar al equipo de desarrollo.

**Versión:** 1.0.0  
**Fecha de creación:** 11 de Abril, 2026
