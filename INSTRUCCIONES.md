# 🚀 GUÍA RÁPIDA DE ACCESO

## Inicio Rápido

### 1️⃣ Iniciar la Aplicación
```bash
cd c:\laravel\procesos
docker compose up --build
```

Espera a que veas:
```
procesos_app  | INFO  Server running on [http://0.0.0.0:8000]
```

### 2️⃣ Acceder a la Aplicación
```
http://localhost:8000
```

### 3️⃣ Hacer Login

**Se redirigirá automaticamente a:** `http://localhost:8000/login`

**Usa una de estas credenciales:**

#### Opción A: Administrador (acceso completo)
```
Email:       admin@procesos.local
Contraseña:  password123
```
✨ Podrás:
- Ver dashboard
- Acceder a "Gestión de acceso"
- Crear/editar/eliminar roles
- Ver y asignar permisos
- Administrar usuarios

#### Opción B: Agente (acceso limitado)
```
Email:       agente@procesos.local
Contraseña:  password123
```
✨ Podrás:
- Ver dashboard
- Ver procesos
- Crear procesos
- Ver reportes

---

## 📊 Lo que puedes hacer

### Como Administrador:

1. **Gestión de Acceso** (Menú → Ajustes → Gestión de acceso)
   - Crear nuevos roles
   - Editar permisos de roles
   - Asignar roles a usuarios
   - Eliminar roles (excepto admin/agente)

2. **Dark Mode**
   - Toggle en esquina superior derecha
   - Se guarda automáticamente
   - Activa en siguiente sesión

3. **Perfil de Usuario**
   - Haz clic en tu nombre (arriba a la derecha)
   - Opciones: Mi Perfil, Configuración, Cerrar Sesión

### Como Agente:

1. **Dashboard**
   - Ver métricas (usuarios, likes, ventas, tareas)
   - Ver tabla de actividades

2. **Módulos Disponibles**
   - Ver procesos
   - Crear procesos
   - Ver reportes

---

## 🔄 Operaciones Comunes

### Cambiar entre Administrador y Agente
1. Haz clic en tu nombre (arriba a la derecha)
2. Selecciona "Cerrar Sesión"
3. Haz login con otra cuenta

### Cambiar Tema (Dark/Light)
1. Haz clic en el toggle sol/luna (navbar)
2. El cambio se guarda automáticamente
3. Cierra sesión y vuelve a iniciar... ¡sigue en modo oscuro!

### Crear un Nuevo Rol (Admin)
1. Ve a **Ajustes → Gestión de acceso**
2. Tab de **Roles**
3. Haz clic en "Crear nuevo rol"
4. Ingresa nombre y descripción
5. Se crea con 0 permisos (asigna luego)

### Asignar Permisos a Rol (Admin)
1. Ve a **Ajustes → Gestión de acceso**
2. Tab de **Permisos**
3. Selecciona el rol del dropdown
4. Marca checkboxes de permisos deseados
5. Haz clic en "Guardar permisos"

### Asignar Rol a Usuario (Admin)
1. Ve a **Ajustes → Gestión de acceso**
2. Tab de **Usuarios**
3. Haz clic en el botón "Asignar rol"
4. Selecciona el rol
5. Haz clic en "Asignar"

---

## 🛠️ Comandos Útiles

### Ver estado de la aplicación
```bash
docker compose ps
```

### Ver logs en tiempo real
```bash
docker compose logs app -f
```

### Reiniciar contenedores
```bash
docker compose down
docker compose up --build
```

### Acceder a la consola PHP (Tinker)
```bash
docker compose exec app php artisan tinker
```

### Resetear BD (⚠️ sí borra todo)
```bash
docker compose exec app php artisan migrate:fresh --seed
```

### Ver todos los usuarios
```bash
docker compose exec -T db psql -U laravel -d laravel -c "SELECT id, name, email FROM users;"
```

---

## ❓ Preguntas Frecuentes

**P: Olvidé la contraseña**
R: Las credenciales de prueba están hardcodeadas en los seeders. Para cambiarlas, necesitas acceso a artisan.

**P: ¿Cómo creo un nuevo usuario?**
R: Actualmente solo hay usuarios de prueba. Para agregar más, necesitas extender los seeders o crear un formulario de registro.

**P: ¿Qué significa "Gestin de acceso"?**
R: Es donde administras:
- **Roles**: Grupos de permisos (ej: administrador, agente, vendedor)
- **Permisos**: Acciones específicas (ej: ver procesos, crear procesos)
- **Usuarios**: A quién asignar qué rol

**P: ¿El Dark Mode se guarda?**
R: Sí, se guarda en localStorage de tu navegador.

**P: ¿Por qué me redirige a /login?**
R: Tu sesión expiró o no estás autenticado. Haz login nuevamente.

**P: ¿Qué es un "Agente"?**
R: Un usuario con permisos limitados. Solo puede:
- Ver procesos
- Crear procesos
- Ver reportes
No puede administrar roles ni usuarios.

---

## 🎓 Estructura de Seguridad

```
Según tu rol, tienes acceso a:

ADMINISTRADOR (admin@procesos.local)
├── Dashboard
├── Ajustes
│   └── Gestión de acceso
│       ├── Crear/editar roles
│       ├── Asignar permisos
│       └── Asignar roles a usuarios
└── Procesos (todos: view, create, update, delete)

AGENTE (agente@procesos.local)
├── Dashboard
├── Procesos (solo: view, create)
└── Reportes (solo: view)
```

---

## 📝 Información Técnica

**Base de Datos:**
- Host: localhost:5432
- Usuario: laravel
- Base: laravel
- Timezone: America/Argentina/Buenos_Aires

**Aplicación:**
- URL: http://localhost:8000
- PHP: 8.3
- Laravel: 13.4.0
- AdminLTE: 3.2.0

---

## 📞 Soporte

Si algo no funciona:
1. Revisa `docker compose logs app`
2. Reinicia con `docker compose down && docker compose up`
3. Si persiste, resetea con `docker compose exec app php artisan migrate:fresh --seed`

---

**¡Bienvenido al Sistema de Procesos Institucionales!** 🎉
