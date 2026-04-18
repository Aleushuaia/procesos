<?php $__env->startSection('title', 'Tipos de Flujos'); ?>
<?php $__env->startSection('page_title', 'Gestión de Tipos de Flujos'); ?>
<?php $__env->startSection('breadcrumb'); ?><li class="breadcrumb-item active">Configuraciones</li><li class="breadcrumb-item active">Tipos de Flujos</li><?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
<div class="row">
    <div class="col-lg-7 col-md-9 col-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0"><i class="fas fa-stream mr-2"></i>Tipos de Flujos</h5>
                <a href="<?php echo e(route('internal.tipo-flujos.create')); ?>" class="btn btn-secondary btn-sm">
                    <i class="fas fa-plus mr-1"></i> Nuevo Tipo de Flujo
                </a>
            </div>
            <div class="card-body p-0">
                <?php if($tipoFlujos && count($tipoFlujos) > 0): ?>
                    <table class="table-crud w-100">
                        <thead>
                            <tr>
                                <th>Descripción</th>
                                <th style="width: 120px;">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $tipoFlujos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr onclick="window.location.href='<?php echo e(route('internal.tipo-flujos.show', $item->id)); ?>'" style="cursor: pointer;">
                                    <td><strong><?php echo e($item->descripcion); ?></strong></td>
                                    <td onclick="event.stopPropagation();">
                                        <div class="action-buttons">
                                            <a href="<?php echo e(route('internal.tipo-flujos.show', $item->id)); ?>" class="btn-action btn-show" title="Ver"><i class="fas fa-eye"></i></a>
                                            <a href="<?php echo e(route('internal.tipo-flujos.edit', $item->id)); ?>" class="btn-action btn-edit" title="Editar"><i class="fas fa-pencil-alt"></i></a>
                                            <button type="button" class="btn-action btn-delete" title="Eliminar" onclick="confirmDelete('<?php echo e(route('internal.tipo-flujos.destroy', $item->id)); ?>')"><i class="fas fa-trash"></i></button>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                <?php else: ?>
                    <div class="empty-state text-center py-4">
                        <i class="fas fa-inbox" style="font-size: 2rem; opacity: 0.3;"></i>
                        <p class="mt-3 text-muted">No hay tipos de flujos registrados</p>
                        <a href="<?php echo e(route('internal.tipo-flujos.create')); ?>" class="btn btn-secondary btn-sm mt-2"><i class="fas fa-plus mr-1"></i> Crear primero</a>
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

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /var/www/html/resources/views/internal/tipo-flujos/index.blade.php ENDPATH**/ ?>