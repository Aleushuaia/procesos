

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
            <div class="collapse" id="detallesContent">
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
                <div class="panel-actions ml-auto">
                    <button class="btn btn-primary-pro btn-sm" data-toggle="modal" data-target="#uploadDocumentoModal" onclick="event.stopPropagation();"><i class="fas fa-upload mr-1"></i>Subir</button>
                </div>
            </div>
            <div class="collapse" id="documentosContent">
                <div class="card-body p-0">
                    <?php if($proceso->documentos->count() > 0): ?>
                        <div class="table-responsive">
                            <table class="table-crud w-100">
                                <thead><tr><th style="width:25%;">Descripción</th><th style="width:15%;">Tipo</th><th style="width:30%;">Archivo</th><th style="width:10%;">Tamaño</th><th style="width:10%;">Fecha</th><th style="width:10%;"></th></tr></thead>
                                <tbody>
                                    <?php $__currentLoopData = $proceso->documentos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $doc): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <tr>
                                            <td><span class="text-white"><?php echo e($doc->descripcion); ?></span></td>
                                            <td><span class="text-white"><?php echo e($doc->tipoDocumento->descripcion ?? '-'); ?></span></td>
                                            <td><span class="text-white"><i class="fas fa-file-pdf text-danger mr-1"></i><?php echo e($doc->nombre_archivo); ?></span></td>
                                            <td><span class="text-white"><?php echo e($doc->tamanio_formateado); ?></span></td>
                                            <td><span class="text-white"><?php echo e($doc->created_at->format('d/m/Y')); ?></span></td>
                                            <td><div class="action-buttons d-flex justify-content-end">
                                                <a href="<?php echo e(route('internal.procesos.documentos.edit', [$proceso->id, $doc->id])); ?>" class="btn-action btn-edit" title="Editar datos del documento asociado"><i class="fas fa-pencil-alt"></i></a>
                                                <button class="btn-action btn-delete" onclick="confirmDeleteDocument('<?php echo e($proceso->id); ?>', '<?php echo e($doc->id); ?>', '<?php echo e(addslashes($doc->nombre_archivo)); ?>')" title="Eliminar"><i class="fas fa-trash"></i></button>
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
                <div class="panel-actions ml-auto">
                    <button class="btn btn-primary-pro btn-sm" data-toggle="modal" data-target="#createFlujModal" onclick="event.stopPropagation(); setCreateModalProcessId('<?php echo e($proceso->id); ?>');"><i class="fas fa-plus mr-1"></i>Nuevo</button>
                </div>
            </div>
            <div class="collapse" id="flujosContent">
                <div class="card-body p-0">
                    <?php if($proceso->flujos->count() > 0): ?>
                        <div class="table-responsive">
                            <table class="table-crud w-100">
                                <thead><tr><th style="width:12%;">Fecha Inicio</th><th style="width:12%;">Fecha Firma</th><th style="width:38%;">Descripción</th><th style="width:13%;">Tipo</th><th style="width:10%;">Documentos</th><th style="width:15%;"></th></tr></thead>
                                <tbody>
                                    <?php $__currentLoopData = $proceso->flujos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $flujo): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <tr onclick="window.location.href='<?php echo e(route('internal.procesos.flujos.show', [$proceso->id, $flujo->id])); ?>'">
                                            <td><span class="text-white"><?php echo e($flujo->fecha_inicio_analisis ? $flujo->fecha_inicio_analisis->format('d/m/Y') : '-'); ?></span></td>
                                            <td><span class="text-white"><?php echo e($flujo->fecha_firma_version ? $flujo->fecha_firma_version->format('d/m/Y') : '-'); ?></span></td>
                                            <td><span class="text-white"><?php echo e($flujo->descripcion); ?></span></td>
                                            <td><span class="text-white"><?php echo e($flujo->tipoFlujo->descripcion ?? '-'); ?></span></td>
                                            <td><span class="badge badge-primary"><?php echo e($flujo->documentos->count()); ?></span></td>
                                            <td><div class="action-buttons d-flex justify-content-end" onclick="event.stopPropagation();">
                                                <a href="<?php echo e(route('internal.procesos.flujos.edit', [$proceso->id, $flujo->id])); ?>" class="btn-action btn-edit" title="Editar"><i class="fas fa-pencil-alt"></i></a>
                                                <button class="btn-action btn-delete" onclick="eliminarFlujo('<?php echo e($proceso->id); ?>', '<?php echo e($flujo->id); ?>', '<?php echo e(addslashes($flujo->descripcion)); ?>')" title="Eliminar"><i class="fas fa-trash"></i></button>
                                            </div></td>
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

<!-- MODAL: Confirmar eliminación de documento -->
<div class="modal fade" id="deleteDocumentoModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="fas fa-exclamation-triangle text-danger mr-2"></i>
                    Confirmar eliminación
                </h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <p class="mb-0">¿Estás seguro de que deseas eliminar este documento?</p>
                <small class="text-muted d-block mt-2" id="deleteDocumentoName"></small>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-danger" id="confirmDeleteBtn">
                    <i class="fas fa-trash mr-1"></i>Eliminar
                </button>
            </div>
        </div>
    </div>
</div>

<?php echo $__env->make('internal.flujos.create', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<?php echo $__env->make('internal.flujos.show', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

<style>
/* Page title smaller for better balance */
.content-header .m-0 { font-size: 1.25rem; }

/* Reduce panel header typography slightly */
.card-header h5.mb-0 { font-size: 0.95rem; margin:0; }
.card-header { cursor: pointer; padding: .5rem .75rem; }
.card { font-size: 0.9375rem; }

/* Smaller badges/text inside panels */
.card .badge { font-size: 0.8125rem; }

.panel-icon { display: inline-block; }
.collapse:not(.show) ~ .card-header .panel-icon { transform: rotate(-90deg); }

/* Ensure panel action buttons align to the right */
.card-header .panel-actions { margin-left: auto; }

/* Table typography standardization */
.table-crud { font-size: 0.875rem; border-collapse: collapse; }
.table-crud thead { background-color: #f8f9fa; }
.table-crud th { 
    font-size: 0.8125rem; 
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    padding: 0.75rem;
    border-bottom: 1px solid #dee2e6;
    vertical-align: middle;
}
.table-crud tbody tr { border-bottom: 1px solid #dee2e6; cursor: pointer; }
.table-crud tbody td { 
    padding: 0.75rem;
    vertical-align: middle;
    font-size: 0.875rem;
    line-height: 1.4;
    color: white;
}
.table-crud tbody td span,
.table-crud tbody td strong { 
    font-size: 0.875rem;
    font-family: inherit;
    color: white;
}
</style>

<script>
// Open specific panel if requested via query parameter
document.addEventListener('DOMContentLoaded', function() {
    const params = new URLSearchParams(window.location.search);
    const panelToOpen = params.get('panel');
    if (panelToOpen === 'documentos') {
        const documentosPanel = document.getElementById('documentosContent');
        if (documentosPanel) {
            documentosPanel.classList.add('show');
        }
    }
});

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

// Documento elimination with modal confirmation
function confirmDeleteDocument(pId, dId, name) {
    document.getElementById('deleteDocumentoName').textContent = `Archivo: ${name}`;
    window.deleteDocInfo = { procesId: pId, docId: dId };
    $('#deleteDocumentoModal').modal('show');
}

document.getElementById('confirmDeleteBtn')?.addEventListener('click', function() {
    const { procesId, docId } = window.deleteDocInfo || {};
    if (!procesId || !docId) return;
    
    fetch(`/internal/procesos/${procesId}/documentos/${docId}`, {
        method: 'DELETE',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            'Accept': 'application/json'
        }
    })
    .then(r => r.json())
    .then(d => {
        if (d.success) {
            $('#deleteDocumentoModal').modal('hide');
            location.reload();
        } else {
            alert('Error al eliminar el documento');
        }
    })
    .catch(() => alert('Error al eliminar el documento'));
});

function eliminarFlujo(pId, fId, name) {
    if(!confirm(`¿Eliminar flujo "${name}"?`)) return;
    fetch(`/internal/procesos/${pId}/flujos/${fId}`, {method: 'DELETE', headers: {'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content, 'Accept': 'application/json'}})
        .then(r => r.json()).then(d => { if(d.success) location.reload(); }).catch(() => alert('Error al eliminar'));
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