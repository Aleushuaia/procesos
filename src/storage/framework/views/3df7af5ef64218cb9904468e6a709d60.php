<?php $__env->startSection('title', 'Tipos de Actores'); ?>
<?php $__env->startSection('page_title', 'Detalles del Tipo de Actor'); ?>
<?php $__env->startSection('breadcrumb'); ?><li class="breadcrumb-item"><a href="<?php echo e(route('internal.tipos-actores.index')); ?>">Tipos</a></li><li class="breadcrumb-item active">Ver</li><?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
<div class="row"><div class="col-md-8"><div class="form-card"><div class="mb-3"><label class="text-muted small">Descripción</label><p>Descripción</p></div><div class="mt-4"><a href="<?php echo e(route('internal.tipos-actores.edit', 1)); ?>" class="btn btn-primary-pro"><i class="fas fa-pencil-alt mr-2"></i> Editar</a><a href="<?php echo e(route('internal.tipos-actores.index')); ?>" class="btn btn-secondary-pro"><i class="fas fa-arrow-left mr-2"></i> Volver</a></div></div></div></div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /var/www/html/resources/views/internal/tipos-actores/show.blade.php ENDPATH**/ ?>