<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <title><?php echo $__env->yieldContent('title', config('app.name')); ?> | <?php echo e(config('app.name')); ?></title>

    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Source+Sans+Pro:300,400,400i,700&display=swap">
    
    <link rel="stylesheet" href="<?php echo e(asset('plugins/fontawesome-free/css/all.min.css')); ?>">
    
    <link rel="stylesheet" href="<?php echo e(asset('plugins/bootstrap/css/bootstrap.min.css')); ?>">
    
    <link rel="stylesheet" href="<?php echo e(asset('css/adminlte.min.css')); ?>">
    
    <link rel="stylesheet" href="<?php echo e(asset('css/app.css')); ?>">

    <?php echo $__env->yieldContent('styles'); ?>
</head>


<body class="hold-transition sidebar-mini layout-fixed" id="app-body">
<script>
    (function () {
        if (localStorage.getItem('theme') === 'dark') {
            document.getElementById('app-body').classList.add('dark-mode');
        }
    })();
</script>

<div class="wrapper">

    
    <nav class="main-header navbar navbar-expand navbar-white navbar-light">

        
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" data-widget="pushmenu" href="#" role="button" aria-label="Menú lateral">
                    <i class="fas fa-bars"></i>
                </a>
            </li>
        </ul>

        
        <ul class="navbar-nav ml-auto">
            
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
            
            
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fas fa-user-circle mr-2"></i>
                    <span class="d-none d-md-inline"><?php echo e(auth()->user()->name); ?></span>
                </a>
                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
                    <a class="dropdown-item" href="#">
                        <i class="fas fa-user mr-2"></i> Mi Perfil
                    </a>
                    <a class="dropdown-item" href="#">
                        <i class="fas fa-cog mr-2"></i> Configuración
                    </a>
                    <div class="dropdown-divider"></div>
                    <form id="logoutForm" action="<?php echo e(route('logout')); ?>" method="POST" style="display: inline;">
                        <?php echo csrf_field(); ?>
                        <a class="dropdown-item" href="#" onclick="document.getElementById('logoutForm').submit(); return false;">
                            <i class="fas fa-sign-out-alt mr-2"></i> Cerrar Sesión
                        </a>
                    </form>
                </div>
            </li>
        </ul>
    </nav>

    
    <aside class="main-sidebar sidebar-dark-primary elevation-4">

        <a href="<?php echo e(url('/')); ?>" class="brand-link pl-3">
            <i class="fas fa-cubes brand-image elevation-3 text-white" style="font-size:1.5rem; opacity:.8; width:34px; line-height:34px; text-align:center;"></i>
            <span class="brand-text font-weight-light ml-2"><?php echo e(config('app.name')); ?></span>
        </a>

        <div class="sidebar">
            <nav class="mt-2">
                <ul class="nav nav-pills nav-sidebar flex-column"
                    data-widget="treeview"
                    role="menu"
                    data-accordion="false">

                    <li class="nav-header">NAVEGACIÓN</li>

                    <li class="nav-item">
                        <a href="<?php echo e(url('/')); ?>" class="nav-link <?php echo e(request()->is('/') ? 'active' : ''); ?>">
                            <i class="nav-icon fas fa-tachometer-alt"></i>
                            <p>Dashboard</p>
                        </a>
                    </li>

                    
                    <?php if(auth()->check() && auth()->user()->hasAnyRole(['Administrador','administrador','admin'])): ?>
                        <li class="nav-item">
                            <a href="<?php echo e(route('internal.procesos.index')); ?>" class="nav-link <?php echo e(request()->is('internal/procesos*') ? 'active' : ''); ?>">
                                <i class="nav-icon fas fa-sitemap text-primary"></i>
                                <p>Procesos</p>
                            </a>
                        </li>
                    <?php endif; ?>

                    
                    <?php if(auth()->check() && auth()->user()->hasAnyRole(['Administrador','administrador','admin'])): ?>
                        <li class="nav-header mt-2">CONFIGURACIONES</li>
                        
                            <li class="nav-item has-treeview tree-tablas <?php echo e(request()->is('internal/*') ? 'menu-open' : ''); ?>">
                                    <a href="#" class="nav-link <?php echo e(request()->is('internal/*') ? 'active' : ''); ?>">
                                        <i class="nav-icon fas fa-cogs"></i>
                                        <p>
                                            Tablas internas
                                            <i class="fas fa-angle-left right"></i>
                                        </p>
                                    </a>
                                    <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="<?php echo e(route('internal.criticidades.index')); ?>" class="nav-link <?php echo e(request()->is('internal/criticidades*') ? 'active' : ''); ?>">
                                        <i class="far fa-dot-circle nav-icon"></i>
                                        <p>Criticidades de Procesos</p>
                                    </a>
                                </li>
                                
                                <li class="nav-item">
                                    <a href="<?php echo e(route('internal.estados.index')); ?>" class="nav-link <?php echo e(request()->is('internal/estados*') ? 'active' : ''); ?>">
                                        <i class="far fa-dot-circle nav-icon"></i>
                                        <p>Estados de proceso</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="<?php echo e(route('internal.personas.index')); ?>" class="nav-link <?php echo e(request()->is('internal/personas*') ? 'active' : ''); ?>">
                                        <i class="far fa-dot-circle nav-icon"></i>
                                        <p>Personas</p>
                                    </a>
                                </li>
                                
                                <li class="nav-item">
                                    <a href="<?php echo e(route('internal.tipos-actores.index')); ?>" class="nav-link <?php echo e(request()->is('internal/tipos-actores*') ? 'active' : ''); ?>">
                                        <i class="far fa-dot-circle nav-icon"></i>
                                        <p>Tipos Actores</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="<?php echo e(route('internal.tipo-flujos.index')); ?>" class="nav-link <?php echo e(request()->is('internal/tipo-flujos*') ? 'active' : ''); ?>">
                                        <i class="far fa-dot-circle nav-icon"></i>
                                        <p>Tipos Flujos</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="<?php echo e(route('internal.tipos-procesos.index')); ?>" class="nav-link <?php echo e(request()->is('internal/tipos-procesos*') ? 'active' : ''); ?>">
                                        <i class="far fa-dot-circle nav-icon"></i>
                                        <p>Tipos Procesos</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="<?php echo e(route('internal.unidades-responsables.index')); ?>" class="nav-link <?php echo e(request()->is('internal/unidades-responsables*') ? 'active' : ''); ?>">
                                        <i class="far fa-dot-circle nav-icon"></i>
                                        <p>Unidades Responsables</p>
                                    </a>
                                </li>
                                
                            </ul>
                        </li>

                        
                        <li class="nav-item has-treeview tree-ajustes <?php echo e(request()->is('settings/*') ? 'menu-open' : ''); ?>">
                            <a href="#" class="nav-link <?php echo e(request()->is('settings/*') ? 'active' : ''); ?>">
                                    <i class="nav-icon fas fa-sliders-h"></i>
                                    <p>
                                        Ajustes y Logs
                                        <i class="fas fa-angle-left right"></i>
                                    </p>
                                </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="<?php echo e(route('settings.access-control.index')); ?>" class="nav-link <?php echo e(request()->is('settings/access-control*') ? 'active' : ''); ?>">
                                        <i class="far fa-dot-circle nav-icon"></i>
                                        <p>Gestión de acceso</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="<?php echo e(url(config('telescope.path', 'telescope'))); ?>" class="nav-link <?php echo e(request()->is(trim(config('telescope.path', 'telescope'), '/') . '*') ? 'active' : ''); ?>" target="_blank" rel="noopener">
                                        <i class="far fa-dot-circle nav-icon"></i>
                                        <p>Logs Telescope</p>
                                    </a>
                                </li>
                            </ul>
                        </li>
                    <?php endif; ?>

                </ul>
            </nav>
        </div>
    </aside>

    
    <div class="content-wrapper">

        
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0"><?php echo $__env->yieldContent('page_title', 'Dashboard'); ?></h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="<?php echo e(url('/')); ?>">Inicio</a></li>
                            <?php echo $__env->yieldContent('breadcrumb'); ?>
                        </ol>
                    </div>
                </div>
            </div>
        </div>

        
        <section class="content">
            <div class="container-fluid">
                <?php echo $__env->yieldContent('content'); ?>
            </div>
        </section>

    </div>

    
    <footer class="main-footer">
        <strong>&copy; <?php echo e(date('Y')); ?> <a href="#"><?php echo e(config('app.name')); ?></a>.</strong>
        Todos los derechos reservados.
        <div class="float-right d-none d-sm-inline-block">
            <b>Laravel</b> v<?php echo e(app()->version()); ?>

        </div>
    </footer>

    
    <aside class="control-sidebar control-sidebar-dark"></aside>

</div>


<script src="<?php echo e(asset('plugins/jquery/jquery.min.js')); ?>"></script>

<script src="<?php echo e(asset('plugins/bootstrap/js/bootstrap.bundle.min.js')); ?>"></script>

<script src="<?php echo e(asset('js/adminlte.min.js')); ?>"></script>

<script src="<?php echo e(asset('js/app.js')); ?>"></script>

<script src="<?php echo e(asset('js/flujo-manager.js')); ?>"></script>

<?php echo $__env->yieldContent('scripts'); ?>

</body>
</html>
<?php /**PATH /var/www/html/resources/views/layouts/app.blade.php ENDPATH**/ ?>