

<?php $__env->startSection('title', 'Nuevo Proceso'); ?>

<?php $__env->startSection('page_title', 'Crear Nuevo Proceso'); ?>

<?php $__env->startSection('breadcrumb'); ?>
    <li class="breadcrumb-item"><a href="<?php echo e(route('internal.procesos.index')); ?>">Procesos</a></li>
    <li class="breadcrumb-item active">Nuevo</li>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="row">
    <div class="col-lg-8">
        <form action="<?php echo e(route('internal.procesos.store')); ?>" method="POST" class="form-card">
            <?php echo csrf_field(); ?>
            
            <h5 class="mb-4">
                <i class="fas fa-sitemap mr-2 text-primary"></i>
                Información Básica
            </h5>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="codigo">Código <span class="text-danger">*</span></label>
                        <input type="text" class="form-control <?php $__errorArgs = ['codigo'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="codigo" name="codigo" placeholder="Ej: PROC-001" value="<?php echo e(old('codigo')); ?>">
                        <?php $__errorArgs = ['codigo'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <div class="invalid-feedback"><?php echo e($message); ?></div>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="descripcion">Descripción <span class="text-danger">*</span></label>
                        <input type="text" class="form-control <?php $__errorArgs = ['descripcion'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="descripcion" name="descripcion" placeholder="Descripción del proceso" required value="<?php echo e(old('descripcion')); ?>">
                        <?php $__errorArgs = ['descripcion'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <div class="invalid-feedback"><?php echo e($message); ?></div>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label for="objetivo">Objetivo</label>
                <textarea class="form-control <?php $__errorArgs = ['objetivo'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="objetivo" name="objetivo" rows="2" placeholder="Objetivo del proceso"><?php echo e(old('objetivo')); ?></textarea>
                <?php $__errorArgs = ['objetivo'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                    <div class="invalid-feedback"><?php echo e($message); ?></div>
                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>

            <div class="form-group">
                <label for="observaciones">Observaciones</label>
                <textarea class="form-control <?php $__errorArgs = ['observaciones'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="observaciones" name="observaciones" rows="2" placeholder="Observaciones adicionales"><?php echo e(old('observaciones')); ?></textarea>
                <?php $__errorArgs = ['observaciones'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                    <div class="invalid-feedback"><?php echo e($message); ?></div>
                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>

            <hr class="my-4">
            <h5 class="mb-4">
                <i class="fas fa-cogs mr-2 text-primary"></i>
                Configuración
            </h5>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="tipo_proceso_id">Tipo de Proceso <span class="text-danger">*</span></label>
                        <select class="form-control <?php $__errorArgs = ['tipo_proceso_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="tipo_proceso_id" name="tipo_proceso_id" required data-colors="<?php echo e(json_encode($tiposProceso->pluck('color', 'id'))); ?>" data-iconos="<?php echo e(json_encode($tiposProceso->pluck('icono', 'id'))); ?>">
                            <option value="">-- Seleccionar --</option>
                            <?php $__currentLoopData = $tiposProceso; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tipo): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($tipo->id); ?>" <?php echo e(old('tipo_proceso_id') == $tipo->id ? 'selected' : ''); ?>>
                                    <?php echo e($tipo->descripcion); ?>

                                </option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                        <?php $__errorArgs = ['tipo_proceso_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <div class="invalid-feedback"><?php echo e($message); ?></div>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                    <div id="tipoPreview" style="display: none; padding: 10px; border-radius: 4px; color: white; margin-top: 8px; font-weight: 500; text-align: center;"></div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label for="estado_proceso_id">Estado <span class="text-danger">*</span></label>
                        <select class="form-control <?php $__errorArgs = ['estado_proceso_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="estado_proceso_id" name="estado_proceso_id" required data-colors="<?php echo e(json_encode($estadosProceso->pluck('color', 'id'))); ?>">
                            <option value="">-- Seleccionar --</option>
                            <?php $__currentLoopData = $estadosProceso; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $estado): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($estado->id); ?>" <?php echo e(old('estado_proceso_id') == $estado->id ? 'selected' : ''); ?>>
                                    <?php echo e($estado->descripcion); ?>

                                </option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                        <?php $__errorArgs = ['estado_proceso_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <div class="invalid-feedback"><?php echo e($message); ?></div>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                    <div id="estadoPreview" style="display: none; padding: 10px; border-radius: 4px; color: white; margin-top: 8px; font-weight: 500; text-align: center;"></div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="criticidad_proceso_id">Criticidad <span class="text-danger">*</span></label>
                        <select class="form-control <?php $__errorArgs = ['criticidad_proceso_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="criticidad_proceso_id" name="criticidad_proceso_id" required data-colors="<?php echo e(json_encode($criticidadesProceso->pluck('color', 'id'))); ?>">
                            <option value="">-- Seleccionar --</option>
                            <?php $__currentLoopData = $criticidadesProceso; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $criticidad): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($criticidad->id); ?>" <?php echo e(old('criticidad_proceso_id') == $criticidad->id ? 'selected' : ''); ?>>
                                    <?php echo e($criticidad->descripcion); ?>

                                </option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                        <?php $__errorArgs = ['criticidad_proceso_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <div class="invalid-feedback"><?php echo e($message); ?></div>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                    <div id="criticidadPreview" style="display: none; padding: 10px; border-radius: 4px; color: white; margin-top: 8px; font-weight: 500; text-align: center;"><i class="fas fa-exclamation-triangle mr-2"></i><span id="criticidadPreviewText"></span></div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label for="unidad_responsable_id">Unidad Responsable <span class="text-danger">*</span></label>
                        <select class="form-control <?php $__errorArgs = ['unidad_responsable_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="unidad_responsable_id" name="unidad_responsable_id" required>
                            <option value="">-- Seleccionar --</option>
                            <?php $__currentLoopData = $unidadesResponsables; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $unidad): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($unidad->id); ?>" <?php echo e(old('unidad_responsable_id') == $unidad->id ? 'selected' : ''); ?>>
                                    <?php echo e($unidad->descripcion); ?>

                                </option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                        <?php $__errorArgs = ['unidad_responsable_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <div class="invalid-feedback"><?php echo e($message); ?></div>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="responsable_proceso_id">Responsable del Proceso</label>
                        <select class="form-control <?php $__errorArgs = ['responsable_proceso_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="responsable_proceso_id" name="responsable_proceso_id">
                            <option value="">-- Sin asignar --</option>
                            <?php $__currentLoopData = $personas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $persona): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($persona->id); ?>" <?php echo e(old('responsable_proceso_id') == $persona->id ? 'selected' : ''); ?>>
                                    <?php echo e($persona->nombres); ?> <?php echo e($persona->apellido); ?>

                                </option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                        <?php $__errorArgs = ['responsable_proceso_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <div class="invalid-feedback"><?php echo e($message); ?></div>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label for="proceso_padre_id">Proceso Padre (si aplica)</label>
                        <select class="form-control <?php $__errorArgs = ['proceso_padre_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="proceso_padre_id" name="proceso_padre_id">
                            <option value="">-- Ninguno --</option>
                            <?php $__currentLoopData = $procesos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $proc): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($proc->id); ?>" <?php echo e(old('proceso_padre_id') == $proc->id ? 'selected' : ''); ?>>
                                    <?php echo e($proc->codigo); ?> - <?php echo e($proc->descripcion); ?>

                                </option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                        <?php $__errorArgs = ['proceso_padre_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <div class="invalid-feedback"><?php echo e($message); ?></div>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <div class="custom-control custom-checkbox">
                    <input type="checkbox" class="custom-control-input" id="requiere_revision" name="requiere_revision" value="1" <?php echo e(old('requiere_revision') ? 'checked' : ''); ?>>
                    <label class="custom-control-label" for="requiere_revision">
                        Requiere Revisión
                    </label>
                </div>
            </div>

            <div class="form-group mt-4">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save mr-2"></i> Guardar Proceso
                </button>
                <a href="<?php echo e(route('internal.procesos.index')); ?>" class="btn btn-secondary">
                    <i class="fas fa-arrow-left mr-2"></i> Volver
                </a>
            </div>
        </form>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const tipoSelect = document.getElementById('tipo_proceso_id');
    const estadoSelect = document.getElementById('estado_proceso_id');
    const criticidadSelect = document.getElementById('criticidad_proceso_id');
    
    const tipoColors = JSON.parse(tipoSelect.dataset.colors || '{}');
    const tipoIconos = JSON.parse(tipoSelect.dataset.iconos || '{}');
    const estadoColors = JSON.parse(estadoSelect.dataset.colors || '{}');
    const criticidadColors = JSON.parse(criticidadSelect.dataset.colors || '{}');
    
    const tipoPreview = document.getElementById('tipoPreview');
    const estadoPreview = document.getElementById('estadoPreview');
    const criticidadPreview = document.getElementById('criticidadPreview');
    
    function updateTipoPreview() {
        const selectedId = tipoSelect.value;
        const selectedText = tipoSelect.options[tipoSelect.selectedIndex].text;
        if (selectedId) {
            const color = tipoColors[selectedId] || '#0c5aa0';
            const icono = tipoIconos[selectedId] || 'fa-folder';
            tipoPreview.style.display = 'block';
            tipoPreview.style.backgroundColor = color;
            tipoPreview.innerHTML = `<i class="fas ${icono} mr-2"></i>${selectedText}`;
        } else {
            tipoPreview.style.display = 'none';
        }
    }
    
    function updateEstadoPreview() {
        const selectedId = estadoSelect.value;
        const selectedText = estadoSelect.options[estadoSelect.selectedIndex].text;
        if (selectedId) {
            const color = estadoColors[selectedId] || '#6c757d';
            estadoPreview.style.display = 'block';
            estadoPreview.style.backgroundColor = color;
            estadoPreview.textContent = selectedText;
        } else {
            estadoPreview.style.display = 'none';
        }
    }
    
    function updateCriticidadPreview() {
        const selectedId = criticidadSelect.value;
        const selectedText = criticidadSelect.options[criticidadSelect.selectedIndex].text;
        if (selectedId) {
            const color = criticidadColors[selectedId] || '#dc3545';
            criticidadPreview.style.display = 'block';
            criticidadPreview.style.backgroundColor = color;
            document.getElementById('criticidadPreviewText').textContent = selectedText;
        } else {
            criticidadPreview.style.display = 'none';
        }
    }
    
    tipoSelect.addEventListener('change', updateTipoPreview);
    estadoSelect.addEventListener('change', updateEstadoPreview);
    criticidadSelect.addEventListener('change', updateCriticidadPreview);
    
    // Initialize previews on page load
    updateTipoPreview();
    updateEstadoPreview();
    updateCriticidadPreview();
});
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /var/www/html/resources/views/internal/procesos/create.blade.php ENDPATH**/ ?>