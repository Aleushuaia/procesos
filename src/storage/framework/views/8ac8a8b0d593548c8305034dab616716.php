<?php $__env->startSection('title', 'Stakeholders'); ?>
<?php $__env->startSection('page_title', 'Gestión de Stakeholders'); ?>
<?php $__env->startSection('breadcrumb'); ?><li class="breadcrumb-item active">Configuraciones</li><li class="breadcrumb-item active">Stakeholders</li><?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
<div class="row">
    <div class="col-lg-10 col-md-12 col-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h6 class="card-title mb-0"><i class="fas fa-user-tag mr-2"></i>Tipos de Stakeholders</h6>
                <a href="<?php echo e(route('internal.tipos-actores.create')); ?>" class="btn btn-secondary btn-sm ml-auto">
                    <i class="fas fa-plus mr-1"></i> Nuevo Stakeholder
                </a>
            </div>
            <div class="card-body p-0">
                <?php if($tiposActores && count($tiposActores) > 0): ?>
                    <table class="table-crud w-100">
                        <thead>
                            <tr>
                                <th>Descripción</th>
                                <th>Observaciones</th>
                                <th style="width: 120px;">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $tiposActores; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr onclick="window.location.href='<?php echo e(route('internal.tipos-actores.show', $item->id)); ?>'" style="cursor: pointer;">
                                    <td><strong><?php echo e($item->descripcion); ?></strong></td>
                                    <td><span class="text-muted"><?php echo e($item->observaciones ? substr($item->observaciones, 0, 50) . (strlen($item->observaciones) > 50 ? '...' : '') : '-'); ?></span></td>
                                    <td onclick="event.stopPropagation();">
                                        <div class="action-buttons">
                                            <a href="<?php echo e(route('internal.tipos-actores.show', $item->id)); ?>" class="btn-action btn-show" title="Ver"><i class="fas fa-eye"></i></a>
                                            <a href="<?php echo e(route('internal.tipos-actores.edit', $item->id)); ?>" class="btn-action btn-edit" title="Editar"><i class="fas fa-pencil-alt"></i></a>
                                            <button type="button" class="btn-action btn-delete" title="Eliminar" onclick="confirmDelete('<?php echo e(route('internal.tipos-actores.destroy', $item->id)); ?>')"><i class="fas fa-trash"></i></button>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                <?php else: ?>
                    <div class="empty-state text-center py-4">
                        <i class="fas fa-inbox" style="font-size: 2rem; opacity: 0.3;"></i>
                        <p class="mt-3 text-muted">No hay stakeholders registrados</p>
                        <a href="<?php echo e(route('internal.tipos-actores.create')); ?>" class="btn btn-secondary btn-sm mt-2"><i class="fas fa-plus mr-1"></i> Crear primero</a>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="deleteModal" tabindex="-1"><div class="modal-dialog modal-sm"><div class="modal-content"><div class="modal-header"><h5 class="modal-title">Confirmar eliminación</h5><button type="button" class="close" data-dismiss="modal"><span>&times;</span></button></div><div class="modal-body">¿Deseas eliminar este registro?</div><div class="modal-footer"><button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button><form id="deleteForm" method="POST" style="display: inline;"><?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?><button type="submit" class="btn btn-danger">Eliminar</button></form></div></div></div></div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('scripts'); ?>
<script>
function confirmDelete(url) {
    document.getElementById('deleteForm').action = url;
    $('#deleteModal').modal('show');
}
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /var/www/html/resources/views/internal/tipos-actores/index.blade.php ENDPATH**/ ?>