

<?php $__env->startSection('title', 'Ver Proceso'); ?>
<?php $__env->startSection('page_title', 'Detalles del Proceso'); ?>
<?php $__env->startSection('breadcrumb'); ?>
    <li class="breadcrumb-item"><a href="<?php echo e(route('internal.procesos.index')); ?>">Procesos</a></li>
    <li class="breadcrumb-item active"><?php echo e($proceso->codigo ?? 'Ver'); ?></li>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
<div class="row">
    <div class="col-12">
        <!-- PANEL 1: DETALLES -->
        <div class="card mb-3">
            <div class="card-header bg-light d-flex align-items-center" style="cursor: pointer;" data-toggle="collapse" data-target="#detallesContent">
                <i class="fas fa-chevron-down mr-2 panel-icon" style="transition: transform 0.3s;"></i>
                <i class="fas fa-info-circle text-primary mr-2"></i>
                <h5 class="mb-0">Detalles del Proceso</h5>
            </div>
            <div class="collapse show" id="detallesContent">
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-md-2 mb-3 mb-md-0">
                            <label class="text-muted small d-block mb-1">Código</label>
                            <p class="h6 mb-0"><strong class="text-primary"><?php echo e($proceso->codigo); ?></strong></p>
                        </div>
                        <div class="col-md-4 mb-3 mb-md-0">
                            <label class="text-muted small d-block mb-1">Descripción</label>
                            <p class="h6 mb-0"><?php echo e($proceso->descripcion); ?></p>
                        </div>
                        <div class="col-md-2 mb-3 mb-md-0">
                            <label class="text-muted small d-block mb-1">Estado</label>
                            <span class="badge p-2 w-100 text-truncate" style="background-color: <?php echo e($proceso->estadoProceso?->color ?? '#6c757d'); ?>; color: white;">
                                <?php echo e($proceso->estadoProceso->descripcion ?? '-'); ?>

                            </span>
                        </div>
                        <div class="col-md-2 mb-3 mb-md-0">
                            <label class="text-muted small d-block mb-1">Tipo</label>
                            <span class="badge p-2 w-100 text-truncate" style="background-color: <?php echo e($proceso->tipoProceso?->color ?? '#0c5aa0'); ?>; color: white;">
                                <i class="fas <?php echo e($proceso->tipoProceso?->icono ?? 'fa-folder'); ?> mr-1"></i><?php echo e($proceso->tipoProceso->descripcion ?? '-'); ?>

                            </span>
                        </div>
                        <div class="col-md-2">
                            <label class="text-muted small d-block mb-1">Criticidad</label>
                            <span class="badge p-2 w-100 text-truncate" style="background-color: <?php echo e($proceso->criticidadProceso?->color ?? '#6c757d'); ?>; color: white;">
                                <i class="fas fa-exclamation-triangle mr-1"></i><?php echo e($proceso->criticidadProceso->descripcion ?? '-'); ?>

                            </span>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-4 mb-3 mb-md-0">
                            <label class="text-muted small d-block mb-1">Unidad Responsable</label>
                            <p class="mb-0"><?php echo e($proceso->unidadResponsable->descripcion ?? '-'); ?></p>
                        </div>
                        <div class="col-md-4 mb-3 mb-md-0">
                            <label class="text-muted small d-block mb-1">Responsable</label>
                            <p class="mb-0"><?php echo e($proceso->responsable ? $proceso->responsable->nombres . ' ' . $proceso->responsable->apellido : '-'); ?></p>
                        </div>
                        <div class="col-md-4">
                            <label class="text-muted small d-block mb-1">En revisión</label>
                            <?php echo $proceso->requiere_revision ? '<span class="badge badge-danger">Sí</span>' : '<span class="badge badge-success">No</span>'; ?>

                        </div>
                    </div>

                    <?php if($proceso->objetivo): ?>
                        <div class="mb-3">
                            <label class="text-muted small d-block mb-1">Objetivo</label>
                            <p class="mb-0"><?php echo e($proceso->objetivo); ?></p>
                        </div>
                    <?php endif; ?>

                    <?php if($proceso->observaciones): ?>
                        <div class="mb-3">
                            <label class="text-muted small d-block mb-1">Observaciones</label>
                            <p class="mb-0 text-muted"><?php echo e($proceso->observaciones); ?></p>
                        </div>
                    <?php endif; ?>

                    <hr>
                    <div class="d-flex gap-2">
                        <a href="<?php echo e(route('internal.procesos.edit', $proceso->id)); ?>" class="btn btn-primary-pro btn-sm"><i class="fas fa-pencil-alt mr-1"></i>Editar</a>
                        <a href="<?php echo e(route('internal.procesos.index')); ?>" class="btn btn-secondary btn-sm"><i class="fas fa-arrow-left mr-1"></i>Volver</a>
                    </div>
                </div>
            </div>
        </div>

        <!-- PANEL 2: DOCUMENTOS -->
        <div class="card mb-3">
            <div class="card-header bg-light d-flex align-items-center justify-content-between" style="cursor: pointer;" data-toggle="collapse" data-target="#documentosContent">
                <div class="d-flex align-items-center">
                    <i class="fas fa-chevron-down mr-2 panel-icon" style="transition: transform 0.3s;"></i>
                    <i class="fas fa-file-pdf text-danger mr-2"></i>
                    <h5 class="mb-0">Documentos Asociados <span class="badge badge-danger ml-2"><?php echo e($proceso->documentos->count()); ?></span></h5>
                </div>
                <button class="btn btn-primary-pro btn-sm" data-toggle="modal" data-target="#uploadDocumentoModal" onclick="event.stopPropagation();"><i class="fas fa-upload mr-1"></i>Subir</button>
            </div>
            <div class="collapse show" id="documentosContent">
                <div class="card-body p-0">
                    <?php if($proceso->documentos->count() > 0): ?>
                        <div class="table-responsive">
                            <table class="table-crud w-100">
                                <thead><tr><th>Descripción</th><th>Tipo</th><th>Archivo</th><th class="text-center">Tamaño</th><th>Fecha</th><th style="width:100px;">Acciones</th></tr></thead>
                                <tbody>
                                    <?php $__currentLoopData = $proceso->documentos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $doc): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <tr>
                                            <td><strong class="text-primary"><?php echo e($doc->descripcion); ?></strong></td>
                                            <td><span class="badge badge-secondary"><?php echo e($doc->tipoDocumento->descripcion ?? '-'); ?></span></td>
                                            <td><a href="<?php echo e(route('internal.procesos.documentos.show', [$proceso->id, $doc->id])); ?>" target="_blank"><i class="fas fa-file-pdf text-danger mr-1"></i><?php echo e($doc->nombre_archivo); ?></a></td>
                                            <td class="text-center"><small class="text-muted"><?php echo e($doc->tamanio_formateado); ?></small></td>
                                            <td><small class="text-muted"><?php echo e($doc->created_at->format('d/m/Y')); ?></small></td>
                                            <td><div class="action-buttons">
                                                <a href="<?php echo e(route('internal.procesos.documentos.show', [$proceso->id, $doc->id])); ?>" target="_blank" class="btn-action btn-show" title="Abrir"><i class="fas fa-eye"></i></a>
                                                <button class="btn-action btn-delete" onclick="eliminarDocumento('<?php echo e($proceso->id); ?>', '<?php echo e($doc->id); ?>', '<?php echo e(addslashes($doc->nombre_archivo)); ?>')"><i class="fas fa-trash"></i></button>
                                            </div></td>
                                        </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </tbody>
                            </table>
                        </div>
                    <?php else: ?>
                        <div class="text-center py-5 text-muted"><i class="fas fa-file-pdf" style="font-size: 2rem; opacity: 0.3;"></i><p class="mt-3">No hay documentos</p>
                            <button class="btn btn-primary-pro btn-sm mt-2" data-toggle="modal" data-target="#uploadDocumentoModal"><i class="fas fa-upload mr-1"></i>Subir Documento</button>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <!-- PANEL 3: FLUJOS -->
        <div class="card">
            <div class="card-header bg-light d-flex align-items-center justify-content-between" style="cursor: pointer;" data-toggle="collapse" data-target="#flujosContent">
                <div class="d-flex align-items-center">
                    <i class="fas fa-chevron-down mr-2 panel-icon" style="transition: transform 0.3s;"></i>
                    <i class="fas fa-project-diagram text-primary mr-2"></i>
                    <h5 class="mb-0">Flujos Asociados <span class="badge badge-primary ml-2"><?php echo e($proceso->flujos->count()); ?></span></h5>
                </div>
                <button class="btn btn-primary-pro btn-sm" data-toggle="modal" data-target="#createFlujModal" onclick="event.stopPropagation(); setCreateModalProcessId('<?php echo e($proceso->id); ?>');"><i class="fas fa-plus mr-1"></i>Nuevo</button>
            </div>
            <div class="collapse show" id="flujosContent">
                <div class="card-body p-0">
                    <?php if($proceso->flujos->count() > 0): ?>
                        <div class="table-responsive">
                            <table class="table-crud w-100">
                                <thead><tr><th>Descripción</th><th>Tipo</th><th class="text-center">Personas</th><th class="text-center">Roles</th><th style="width:100px;">Acciones</th></tr></thead>
                                <tbody>
                                    <?php $__currentLoopData = $proceso->flujos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $flujo): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <tr>
                                            <td><strong class="text-primary"><?php echo e($flujo->descripcion); ?></strong><?php if($flujo->observaciones): ?><small class="text-muted d-block"><?php echo e(Str::limit($flujo->observaciones, 60)); ?></small><?php endif; ?></td>
                                            <td><span class="badge badge-info"><?php echo e($flujo->tipoFlujo->descripcion ?? '-'); ?></span></td>
                                            <td class="text-center"><span class="badge badge-secondary"><?php echo e($flujo->personas->count()); ?></span></td>
                                            <td class="text-center"><span class="badge badge-warning"><?php echo e($flujo->tiposActores->count()); ?></span></td>
                                            <td><button class="btn-action btn-show" data-toggle="modal" data-target="#showFlujoModal" onclick="loadFlujoDetailsModal('<?php echo e($proceso->id); ?>', '<?php echo e($flujo->id); ?>')"><i class="fas fa-eye"></i></button></td>
                                        </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </tbody>
                            </table>
                        </div>
                    <?php else: ?>
                        <div class="text-center py-5 text-muted"><i class="fas fa-inbox" style="font-size: 2rem;"></i><p class="mt-3">No hay flujos</p>
                            <button class="btn btn-primary-pro btn-sm mt-2" data-toggle="modal" data-target="#createFlujModal" onclick="setCreateModalProcessId('<?php echo e($proceso->id); ?>');"><i class="fas fa-plus mr-1"></i>Crear Flujo</button>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- MODALES -->
<div class="modal fade" id="uploadDocumentoModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header"><h5 class="modal-title"><i class="fas fa-upload text-danger mr-2"></i>Subir Documento</h5><button class="close" data-dismiss="modal">&times;</button></div>
            <form id="uploadDocumentoForm" enctype="multipart/form-data">
                <?php echo csrf_field(); ?>
                <div class="modal-body">
                    <div class="form-group"><label>Descripción *</label><input type="text" class="form-control" name="descripcion" required maxlength="100"></div>
                    <div class="form-group"><label>Tipo *</label><select class="form-control" name="tipo_proceso_documento_id" required>
                        <option value=""> Seleccionar </option>
                        <?php $__currentLoopData = $tiposDocumento; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tipo): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($tipo->id); ?>"><?php echo e($tipo->descripcion); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select></div>
                    <div class="form-group"><label>Archivo PDF *</label><input type="file" class="form-control" name="archivo" accept=".pdf" required></div>
                </div>
                <div class="modal-footer"><button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button><button type="submit" class="btn btn-primary-pro">Subir</button></div>
            </form>
        </div>
    </div>
</div>

<?php echo $__env->make('internal.flujos.create', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<?php echo $__env->make('internal.flujos.show', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

<style>
.card-header { cursor: pointer; }
.panel-icon { display: inline-block; }
.collapse:not(.show) ~ .card-header .panel-icon { transform: rotate(-90deg); }
</style>

<script>
document.querySelectorAll('[data-toggle="collapse"]').forEach(el => {
    el.addEventListener('click', function() {
        const target = document.querySelector(this.getAttribute('data-target'));
        const icon = this.querySelector('.panel-icon');
        if(icon) {
            setTimeout(() => {
                icon.style.transform = target.classList.contains('show') ? 'rotate(0deg)' : 'rotate(-90deg)';
            }, 100);
        }
    });
});

function setCreateModalProcessId(id) { document.getElementById('createFlujModal').dataset.procesId = id; }
function loadFlujoDetailsModal(pId, fId) {
    const cont = document.getElementById('flujoContent');
    cont.innerHTML = '<div class="text-center py-5"><div class="spinner-border"></div></div>';
    fetch(`/internal/procesos/${pId}/flujos/${fId}`, {headers: {'Accept': 'application/json', 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content}})
        .then(r => r.json()).then(d => { cont.innerHTML = `<p>${d.descripcion}</p>`; }).catch(() => { cont.innerHTML = '<div class="alert alert-danger">Error</div>'; });
}
function eliminarDocumento(pId, dId, name) {
    if(!confirm(`¿Eliminar "${name}"?`)) return;
    fetch(`/internal/procesos/${pId}/documentos/${dId}`, {method: 'DELETE', headers: {'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content, 'Accept': 'application/json'}})
        .then(r => r.json()).then(d => { if(d.success) location.reload(); }).catch(() => alert('Error'));
}

document.getElementById('uploadDocumentoForm')?.addEventListener('submit', function(e) {
    e.preventDefault();
    const fd = new FormData(this);
    fetch(`/internal/procesos/<?php echo e($proceso->id); ?>/documentos`, {method: 'POST', body: fd, headers: {'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content, 'Accept': 'application/json'}})
        .then(r => r.json()).then(d => { if(d.success) { $('#uploadDocumentoModal').modal('hide'); setTimeout(() => location.reload(), 500); } }).catch(() => alert('Error'));
});
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /var/www/html/resources/views/internal/procesos/show.blade.php ENDPATH**/ ?>