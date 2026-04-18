<?php $__env->startSection('title', 'Dashboard'); ?>
<?php $__env->startSection('page_title', 'Dashboard'); ?>

<?php $__env->startSection('breadcrumb'); ?>
    <li class="breadcrumb-item active">Dashboard</li>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>


<div class="row">
    <div class="col-12 col-sm-6 col-md-3">
        <div class="info-box">
            <span class="info-box-icon bg-info elevation-1"><i class="fas fa-users"></i></span>
            <div class="info-box-content">
                <span class="info-box-text">Usuarios</span>
                <span class="info-box-number">150</span>
            </div>
        </div>
    </div>

    <div class="col-12 col-sm-6 col-md-3">
        <div class="info-box mb-3">
            <span class="info-box-icon bg-danger elevation-1"><i class="fas fa-thumbs-up"></i></span>
            <div class="info-box-content">
                <span class="info-box-text">Me gusta</span>
                <span class="info-box-number">41,410</span>
            </div>
        </div>
    </div>

    <div class="clearfix hidden-md-up"></div>

    <div class="col-12 col-sm-6 col-md-3">
        <div class="info-box mb-3">
            <span class="info-box-icon bg-success elevation-1"><i class="fas fa-shopping-cart"></i></span>
            <div class="info-box-content">
                <span class="info-box-text">Ventas</span>
                <span class="info-box-number">760</span>
            </div>
        </div>
    </div>

    <div class="col-12 col-sm-6 col-md-3">
        <div class="info-box mb-3">
            <span class="info-box-icon bg-warning elevation-1"><i class="fas fa-cog"></i></span>
            <div class="info-box-content">
                <span class="info-box-text">Tareas activas</span>
                <span class="info-box-number">2,000</span>
            </div>
        </div>
    </div>
</div>


<div class="row">
    <div class="col-lg-3 col-6">
        <div class="small-box bg-info">
            <div class="inner">
                <h3>150</h3>
                <p>Nuevos pedidos</p>
            </div>
            <div class="icon"><i class="fas fa-shopping-basket"></i></div>
            <a href="#" class="small-box-footer">
                Más info <i class="fas fa-arrow-circle-right"></i>
            </a>
        </div>
    </div>

    <div class="col-lg-3 col-6">
        <div class="small-box bg-success">
            <div class="inner">
                <h3>53<sup style="font-size:20px">%</sup></h3>
                <p>Tasa de conversión</p>
            </div>
            <div class="icon"><i class="fas fa-chart-pie"></i></div>
            <a href="#" class="small-box-footer">
                Más info <i class="fas fa-arrow-circle-right"></i>
            </a>
        </div>
    </div>

    <div class="col-lg-3 col-6">
        <div class="small-box bg-warning">
            <div class="inner">
                <h3>44</h3>
                <p>Registros de usuario</p>
            </div>
            <div class="icon"><i class="fas fa-user-plus"></i></div>
            <a href="#" class="small-box-footer">
                Más info <i class="fas fa-arrow-circle-right"></i>
            </a>
        </div>
    </div>

    <div class="col-lg-3 col-6">
        <div class="small-box bg-danger">
            <div class="inner">
                <h3>65</h3>
                <p>Errores únicos del día</p>
            </div>
            <div class="icon"><i class="fas fa-exclamation-triangle"></i></div>
            <a href="#" class="small-box-footer">
                Más info <i class="fas fa-arrow-circle-right"></i>
            </a>
        </div>
    </div>
</div>


<div class="row">
    <div class="col-md-8">
        <div class="card card-primary card-outline">
            <div class="card-header">
                <h3 class="card-title">Actividad reciente</h3>
                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                        <i class="fas fa-minus"></i>
                    </button>
                </div>
            </div>
            <div class="card-body p-0">
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Usuario</th>
                            <th>Acción</th>
                            <th>Fecha</th>
                            <th>Estado</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php for($i = 1; $i <= 5; $i++): ?>
                        <tr>
                            <td><?php echo e($i); ?></td>
                            <td>Usuario <?php echo e($i); ?></td>
                            <td>Acción de ejemplo <?php echo e($i); ?></td>
                            <td><?php echo e(now()->subDays($i)->format('d/m/Y')); ?></td>
                            <td>
                                <span class="badge badge-<?php echo e($i % 2 === 0 ? 'success' : 'warning'); ?>">
                                    <?php echo e($i % 2 === 0 ? 'Completado' : 'Pendiente'); ?>

                                </span>
                            </td>
                        </tr>
                        <?php endfor; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    
    <div class="col-md-4">
        <div class="card card-default card-outline">
            <div class="card-header">
                <h3 class="card-title">Accesos rápidos</h3>
            </div>
            <div class="card-body">
                <div class="list-group list-group-flush">
                    <a href="#" class="list-group-item list-group-item-action d-flex align-items-center">
                        <i class="fas fa-users mr-3 text-info"></i> Gestión de usuarios
                    </a>
                    <a href="#" class="list-group-item list-group-item-action d-flex align-items-center">
                        <i class="fas fa-cogs mr-3 text-secondary"></i> Configuración
                    </a>
                    <a href="#" class="list-group-item list-group-item-action d-flex align-items-center">
                        <i class="fas fa-chart-bar mr-3 text-success"></i> Reportes
                    </a>
                    <a href="#" class="list-group-item list-group-item-action d-flex align-items-center">
                        <i class="fas fa-file-alt mr-3 text-warning"></i> Documentos
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /var/www/html/resources/views/home.blade.php ENDPATH**/ ?>