<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', config('app.name')) | {{ config('app.name') }}</title>

    {{-- Google Font --}}
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    {{-- FontAwesome --}}
    <link rel="stylesheet" href="{{ asset('plugins/fontawesome-free/css/all.min.css') }}">
    {{-- Bootstrap 4 --}}
    <link rel="stylesheet" href="{{ asset('plugins/bootstrap/css/bootstrap.min.css') }}">
    {{-- AdminLTE --}}
    <link rel="stylesheet" href="{{ asset('css/adminlte.min.css') }}">
    {{-- Custom styles --}}
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">

    @yield('styles')
</head>

{{-- Clase dark-mode aplicada inmediatamente desde localStorage para evitar destello --}}
<body class="hold-transition sidebar-mini layout-fixed" id="app-body">
<script>
    (function () {
        if (localStorage.getItem('theme') === 'dark') {
            document.getElementById('app-body').classList.add('dark-mode');
        }
    })();
</script>

<div class="wrapper">

    {{-- ============================================================
         NAVBAR SUPERIOR
    ============================================================ --}}
    <nav class="main-header navbar navbar-expand navbar-white navbar-light">

        {{-- Izquierda: toggle sidebar --}}
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" data-widget="pushmenu" href="#" role="button" aria-label="Menú lateral">
                    <i class="fas fa-bars"></i>
                </a>
            </li>
        </ul>

        {{-- Derecha: Dark / Light mode switch + User menu --}}
        <ul class="navbar-nav ml-auto">
            {{-- Dark / Light mode switch --}}
            <li class="nav-item d-flex align-items-center mr-3">
                <div class="theme-toggle d-flex align-items-center gap-2">
                    <i class="fas fa-sun theme-icon-light" aria-hidden="true"></i>
                    <label class="switch mb-0" for="darkModeSwitch" title="Alternar modo oscuro / claro">
                        <input type="checkbox" id="darkModeSwitch" role="switch" aria-label="Modo oscuro">
                        <span class="slider round"></span>
                    </label>
                    <i class="fas fa-moon theme-icon-dark" aria-hidden="true"></i>
                </div>
            </li>
            
            {{-- User Menu --}}
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fas fa-user-circle mr-2"></i>
                    <span class="d-none d-md-inline">{{ auth()->user()->name }}</span>
                </a>
                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
                    <a class="dropdown-item" href="#">
                        <i class="fas fa-user mr-2"></i> Mi Perfil
                    </a>
                    <a class="dropdown-item" href="#">
                        <i class="fas fa-cog mr-2"></i> Configuración
                    </a>
                    <div class="dropdown-divider"></div>
                    <form id="logoutForm" action="{{ route('logout') }}" method="POST" style="display: inline;">
                        @csrf
                        <a class="dropdown-item" href="#" onclick="document.getElementById('logoutForm').submit(); return false;">
                            <i class="fas fa-sign-out-alt mr-2"></i> Cerrar Sesión
                        </a>
                    </form>
                </div>
            </li>
        </ul>
    </nav>

    {{-- ============================================================
         SIDEBAR
    ============================================================ --}}
    <aside class="main-sidebar sidebar-dark-primary elevation-4">

        <a href="{{ url('/') }}" class="brand-link pl-3">
            <i class="fas fa-cubes brand-image elevation-3 text-white" style="font-size:1.5rem; opacity:.8; width:34px; line-height:34px; text-align:center;"></i>
            <span class="brand-text font-weight-light ml-2">{{ config('app.name') }}</span>
        </a>

        <div class="sidebar">
            <nav class="mt-2">
                <ul class="nav nav-pills nav-sidebar flex-column"
                    data-widget="treeview"
                    role="menu"
                    data-accordion="false">

                    <li class="nav-header">NAVEGACIÓN</li>

                    <li class="nav-item">
                        <a href="{{ url('/') }}" class="nav-link {{ request()->is('/') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-tachometer-alt"></i>
                            <p>Dashboard</p>
                        </a>
                    </li>

                    {{-- Sección visible solo para administradores --}}
                    @if(auth()->check() && auth()->user()->hasAnyRole(['Administrador','administrador','admin']))
                        <li class="nav-header mt-2">CONFIGURACIONES</li>
                        
                            <li class="nav-item has-treeview tree-tablas {{ request()->is('internal/*') ? 'menu-open' : '' }}">
                                    <a href="#" class="nav-link {{ request()->is('internal/*') ? 'active' : '' }}">
                                        <i class="nav-icon fas fa-cogs"></i>
                                        <p>
                                            Tablas internas
                                            <i class="fas fa-angle-left right"></i>
                                        </p>
                                    </a>
                                    <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{ route('internal.criticidades.index') }}" class="nav-link {{ request()->is('internal/criticidades*') ? 'active' : '' }}">
                                        <i class="far fa-dot-circle nav-icon"></i>
                                        <p>Criticidades de Procesos</p>
                                    </a>
                                </li>
                                {{-- Procesos link removed (obsolete) --}}
                                <li class="nav-item">
                                    <a href="{{ route('internal.estados.index') }}" class="nav-link {{ request()->is('internal/estados*') ? 'active' : '' }}">
                                        <i class="far fa-dot-circle nav-icon"></i>
                                        <p>Estados de proceso</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('internal.personas.index') }}" class="nav-link {{ request()->is('internal/personas*') ? 'active' : '' }}">
                                        <i class="far fa-dot-circle nav-icon"></i>
                                        <p>Personas</p>
                                    </a>
                                </li>
                                {{-- Roles y Proceso Unidad Responsable removidos (obsoletos) --}}
                                <li class="nav-item">
                                    <a href="{{ route('internal.tipos-actores.index') }}" class="nav-link {{ request()->is('internal/tipos-actores*') ? 'active' : '' }}">
                                        <i class="far fa-dot-circle nav-icon"></i>
                                        <p>Tipos Actores</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('internal.tipo-flujos.index') }}" class="nav-link {{ request()->is('internal/tipo-flujos*') ? 'active' : '' }}">
                                        <i class="far fa-dot-circle nav-icon"></i>
                                        <p>Tipos Flujos</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('internal.tipos-procesos.index') }}" class="nav-link {{ request()->is('internal/tipos-procesos*') ? 'active' : '' }}">
                                        <i class="far fa-dot-circle nav-icon"></i>
                                        <p>Tipos Procesos</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('internal.unidades-responsables.index') }}" class="nav-link {{ request()->is('internal/unidades-responsables*') ? 'active' : '' }}">
                                        <i class="far fa-dot-circle nav-icon"></i>
                                        <p>Unidades Responsables</p>
                                    </a>
                                </li>
                                
                            </ul>
                        </li>

                        {{-- Nuevo submenú hermano: Ajustes y Logs (al mismo nivel que Tablas internas) --}}
                        <li class="nav-item has-treeview tree-ajustes {{ request()->is('settings/*') ? 'menu-open' : '' }}">
                            <a href="#" class="nav-link {{ request()->is('settings/*') ? 'active' : '' }}">
                                    <i class="nav-icon fas fa-sliders-h"></i>
                                    <p>
                                        Ajustes y Logs
                                        <i class="fas fa-angle-left right"></i>
                                    </p>
                                </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{ route('settings.access-control.index') }}" class="nav-link {{ request()->is('settings/access-control*') ? 'active' : '' }}">
                                        <i class="far fa-dot-circle nav-icon"></i>
                                        <p>Gestión de acceso</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ url(config('telescope.path', 'telescope')) }}" class="nav-link {{ request()->is(trim(config('telescope.path', 'telescope'), '/') . '*') ? 'active' : '' }}" target="_blank" rel="noopener">
                                        <i class="far fa-dot-circle nav-icon"></i>
                                        <p>Logs Telescope</p>
                                    </a>
                                </li>
                            </ul>
                        </li>
                    @endif

                </ul>
            </nav>
        </div>
    </aside>

    {{-- ============================================================
         CONTENT WRAPPER
    ============================================================ --}}
    <div class="content-wrapper">

        {{-- Cabecera de página --}}
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">@yield('page_title', 'Dashboard')</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ url('/') }}">Inicio</a></li>
                            @yield('breadcrumb')
                        </ol>
                    </div>
                </div>
            </div>
        </div>

        {{-- Contenido principal --}}
        <section class="content">
            <div class="container-fluid">
                @yield('content')
            </div>
        </section>

    </div>

    {{-- ============================================================
         FOOTER
    ============================================================ --}}
    <footer class="main-footer">
        <strong>&copy; {{ date('Y') }} <a href="#">{{ config('app.name') }}</a>.</strong>
        Todos los derechos reservados.
        <div class="float-right d-none d-sm-inline-block">
            <b>Laravel</b> v{{ app()->version() }}
        </div>
    </footer>

    {{-- Control sidebar (requerido por AdminLTE) --}}
    <aside class="control-sidebar control-sidebar-dark"></aside>

</div>

{{-- jQuery (debe cargarse primero) --}}
<script src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>
{{-- Bootstrap 4 --}}
<script src="{{ asset('plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
{{-- AdminLTE --}}
<script src="{{ asset('js/adminlte.min.js') }}"></script>
{{-- Custom JS --}}
<script src="{{ asset('js/app.js') }}"></script>

@yield('scripts')

</body>
</html>
