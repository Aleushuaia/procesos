

<?php $__env->startSection('title', 'Editar Documento'); ?>
<?php $__env->startSection('page_title', 'Editar Documento'); ?>
<?php $__env->startSection('breadcrumb'); ?>
    <li class="breadcrumb-item"><a href="<?php echo e(route('internal.procesos.index')); ?>">Procesos</a></li>
    <li class="breadcrumb-item"><a href="<?php echo e(route('internal.procesos.show', $proceso->id)); ?>"><?php echo e($proceso->codigo); ?></a></li>
    <li class="breadcrumb-item active">Editar Documento</li>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="row">
    <div class="col-12 col-lg-6 offset-lg-3">
        <div class="card">
            <div class="card-header bg-light">
                <i class="fas fa-file-pdf text-danger mr-2"></i>
                <h5 class="mb-0 d-inline">Editar Documento</h5>
            </div>
            <div class="card-body">
                <form id="editDocumentoForm" action="<?php echo e(route('internal.procesos.documentos.update', [$proceso->id, $documento->id])); ?>" method="POST" class="needs-validation">
                    <?php echo csrf_field(); ?>
                    <?php echo method_field('PUT'); ?>

                    <!-- Información del documento -->
                    <div class="mb-4">
                        <h6 class="text-primary mb-3">
                            <i class="fas fa-info-circle mr-2"></i>
                            Información del Documento
                        </h6>

                        <div class="form-group">
                            <label for="descripcion">Descripción <span class="text-danger">*</span></label>
                            <input type="text" class="form-control <?php $__errorArgs = ['descripcion'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                   id="descripcion" name="descripcion" 
                                   value="<?php echo e(old('descripcion', $documento->descripcion)); ?>"
                                   placeholder="Descripción del documento" required maxlength="100">
                            <small class="form-text text-muted">Máximo 100 caracteres</small>
                            <?php $__errorArgs = ['descripcion'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <div class="invalid-feedback d-block"><?php echo e($message); ?></div>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <div class="form-group">
                            <label for="tipo_proceso_documento_id">Tipo de Documento <span class="text-danger">*</span></label>
                            <select class="form-control <?php $__errorArgs = ['tipo_proceso_documento_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                    id="tipo_proceso_documento_id" name="tipo_proceso_documento_id" required>
                                <option value="">-- Seleccionar --</option>
                                <?php $__currentLoopData = $tiposDocumento; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tipo): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($tipo->id); ?>" 
                                        <?php echo e(old('tipo_proceso_documento_id', $documento->tipo_proceso_documento_id) == $tipo->id ? 'selected' : ''); ?>>
                                        <?php echo e($tipo->descripcion); ?>

                                    </option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                            <?php $__errorArgs = ['tipo_proceso_documento_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <div class="invalid-feedback d-block"><?php echo e($message); ?></div>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>
                    </div>

                    <hr class="my-4">

                    <!-- Información del archivo (solo lectura) -->
                    <div class="mb-4">
                        <h6 class="text-primary mb-3">
                            <i class="fas fa-file mr-2"></i>
                            Información del Archivo (Solo lectura)
                        </h6>

                        <div class="form-group">
                            <label for="nombre_archivo">Nombre del Archivo</label>
                            <input type="text" class="form-control" id="nombre_archivo" 
                                   value="<?php echo e($documento->nombre_archivo); ?>" disabled>
                            <small class="form-text text-muted">No se puede cambiar el nombre del archivo</small>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="tamanio">Tamaño</label>
                                    <input type="text" class="form-control" id="tamanio" 
                                           value="<?php echo e($documento->tamanio_formateado); ?>" disabled>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="fecha_subida">Fecha de Subida</label>
                                    <input type="text" class="form-control" id="fecha_subida" 
                                           value="<?php echo e($documento->created_at->format('d/m/Y H:i')); ?>" disabled>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="extension">Extensión</label>
                            <input type="text" class="form-control" id="extension" 
                                   value="<?php echo e(strtoupper($documento->extension)); ?>" disabled>
                        </div>
                    </div>

                    <hr class="my-4">

                    <!-- Botones de Acción -->
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary-pro">
                            <i class="fas fa-save mr-1"></i>Guardar Cambios
                        </button>
                        <a href="<?php echo e(route('internal.procesos.show', $proceso->id) . '?panel=documentos'); ?>" class="btn btn-secondary">
                            <i class="fas fa-times mr-1"></i>Cancelar
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
document.getElementById('editDocumentoForm')?.addEventListener('submit', function(e) {
    // Allow form submission to proceed normally, but ensure redirect keeps panel open
    // The form will POST to the update route which should redirect with the panel parameter
});

// Optional: If you want to handle the redirect via JavaScript for POST requests
// Uncomment the code below and modify the form action accordingly
/*
document.getElementById('editDocumentoForm')?.addEventListener('submit', function(e) {
    e.preventDefault();
    const form = this;
    const formData = new FormData(form);
    
    fetch(form.action, {
        method: 'POST',
        body: formData,
        headers: {
            'Accept': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        }
    })
    .then(response => {
        if (response.ok) {
            window.location.href = '<?php echo e(route('internal.procesos.show', $proceso->id)); ?>' + '?panel=documentos';
        } else {
            response.json().then(data => {
                console.error('Error:', data);
                alert('Error al guardar los cambios');
            });
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Error al guardar los cambios');
    });
});
*/
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /var/www/html/resources/views/internal/procesos/documentos/edit.blade.php ENDPATH**/ ?>