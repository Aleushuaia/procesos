<?php $__env->startSection('title', 'Tipos Procesos'); ?>

<?php $__env->startSection('page_title', 'Gestión de Tipos de Procesos'); ?>

<?php $__env->startSection('breadcrumb'); ?>
    <li class="breadcrumb-item active">Configuraciones</li>
    <li class="breadcrumb-item active">Tipos Procesos</li>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="row">
    <div class="col-lg-9 col-md-11 col-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0"><i class="fas fa-list mr-2"></i>Tipos de Procesos</h5>
                <a href="<?php echo e(route('internal.tipos-procesos.create')); ?>" class="btn btn-secondary btn-sm">
                    <i class="fas fa-plus mr-1"></i> Nuevo Tipo de Proceso
                </a>
            </div>
            <div class="card-body p-0">
                <?php if($tipoProcesos && count($tipoProcesos) > 0): ?>
                    <table class="table-crud w-100">
                        <thead>
                            <tr>
                                <th style="width: 50px;"></th>
                                    <th>Descripci�n</th>
                                <th>Etiqueta</th>
                                <th style="width: 120px;">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php $__currentLoopData = $tipoProcesos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr onclick="window.location.href='<?php echo e(route('internal.tipos-procesos.show', $item->id)); ?>'" style="cursor: pointer;">
                                    <td class="text-center">
                                        <div style="background-color: <?php echo e($item->color ?? '#6c757d'); ?>; color: white; width: 36px; height: 36px; display: inline-flex; align-items: center; justify-content: center; font-size: 1rem; border-radius: 4px;">
                                            <i class="fas <?php echo e($item->icono ?? 'fa-folder'); ?>"></i>
                                        </div>
                                    </td>
                                    <td><strong><?php echo e($item->descripcion ?? ''); ?></strong></td>
                                    <td>
                                        <div style="display: inline-flex; align-items: center; gap: 6px; background-color: <?php echo e($item->color ?? '#6c757d'); ?>; color: white; padding: 3px 10px; border-radius: 20px; font-size: 0.85rem;">
                                            <i class="fas <?php echo e($item->icono ?? 'fa-folder'); ?>"></i>
                                            <span><?php echo e($item->descripcion ?? ''); ?></span>
                                        </div>
                                    </td>
                                    <td onclick="event.stopPropagation();">
                                        <div class="action-buttons">
                                            <a href="<?php echo e(route('internal.tipos-procesos.show', $item->id)); ?>" class="btn-action btn-show" title="Ver"><i class="fas fa-eye"></i></a>
                                            <a href="<?php echo e(route('internal.tipos-procesos.edit', $item->id)); ?>" class="btn-action btn-edit" title="Editar"><i class="fas fa-pencil-alt"></i></a>
                                            <button type="button" class="btn-action btn-delete" title="Eliminar" onclick="confirmDelete('<?php echo e(route('internal.tipos-procesos.destroy', $item->id)); ?>')"><i class="fas fa-trash"></i></button>
                                        </div>
                                    </td>
                                </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                <?php else: ?>
                    <div class="empty-state text-center py-4">
                        <i class="fas fa-inbox" style="font-size: 2rem; opacity: 0.3;"></i>
                        <p class="mt-3 text-muted">No hay tipos de procesos registrados</p>
                        <a href="<?php echo e(route('internal.tipos-procesos.create')); ?>" class="btn btn-secondary btn-sm mt-2"><i class="fas fa-plus mr-1"></i> Crear primero</a>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="fas fa-exclamation-triangle mr-2 text-danger"></i>Confirmar Eliminaci�n</h5>
                <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
            </div>
            <div class="modal-body">�Est�s seguro de que deseas eliminar este tipo de proceso? Esta acci�n no se puede deshacer.</div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                <form id="deleteForm" method="POST" style="display: inline;">   
                    <?php echo csrf_field(); ?>
                    <?php echo method_field('DELETE'); ?>
                    <button type="submit" class="btn btn-danger">Eliminar</button>
                </form>
            </div>
        </div>
    </div>
</div>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
<script>
function confirmDelete(url) {
    document.getElementById('deleteForm').action = url;
    $('#deleteModal').modal('show');
}
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /var/www/html/resources/views/internal/tipos-procesos/index.blade.php ENDPATH**/ ?>