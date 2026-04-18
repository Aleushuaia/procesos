

<?php $__env->startSection('title', 'Editar Flujo'); ?>
<?php $__env->startSection('page_title', 'Editar Flujo'); ?>
<?php $__env->startSection('breadcrumb'); ?>
    <li class="breadcrumb-item"><a href="<?php echo e(route('internal.procesos.index')); ?>">Procesos</a></li>
    <li class="breadcrumb-item"><a href="<?php echo e(route('internal.procesos.show', $proceso->id)); ?>"><?php echo e($proceso->codigo); ?></a></li>
    <li class="breadcrumb-item"><a href="<?php echo e(route('internal.procesos.flujos.show', [$proceso->id, $flujo->id])); ?>"><?php echo e($flujo->descripcion); ?></a></li>
    <li class="breadcrumb-item active">Editar</li>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="row">
    <div class="col-12 col-lg-8 offset-lg-2">
        <div class="card">
            <div class="card-header bg-light">
                <i class="fas fa-pencil-alt text-primary mr-2"></i>
                <h5 class="mb-0 d-inline">Editar Flujo</h5>
            </div>
            <div class="card-body">
                <form id="editFlujoForm" action="<?php echo e(route('internal.procesos.flujos.update', [$proceso->id, $flujo->id])); ?>" method="POST" class="needs-validation">
                    <?php echo csrf_field(); ?>
                    <?php echo method_field('PUT'); ?>

                    <!-- Información Básica -->
                    <div class="mb-4">
                        <h6 class="text-primary mb-3">
                            <i class="fas fa-info-circle mr-2"></i>
                            Información Básica
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
                                   value="<?php echo e(old('descripcion', $flujo->descripcion)); ?>"
                                   placeholder="Descripción del flujo" required maxlength="255">
                            <small class="form-text text-muted">Máximo 255 caracteres</small>
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
                            <label for="tipo_flujo_id">Tipo de Flujo <span class="text-danger">*</span></label>
                            <select class="form-control <?php $__errorArgs = ['tipo_flujo_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                    id="tipo_flujo_id" name="tipo_flujo_id" required>
                                <option value="">-- Seleccionar --</option>
                                <?php $__currentLoopData = $tiposFlujo; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tipo): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($tipo->id); ?>" 
                                        <?php echo e(old('tipo_flujo_id', $flujo->tipo_flujo_id) == $tipo->id ? 'selected' : ''); ?>>
                                        <?php echo e($tipo->descripcion); ?>

                                    </option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                            <?php $__errorArgs = ['tipo_flujo_id'];
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
                            <label for="observaciones">Observaciones</label>
                            <textarea class="form-control <?php $__errorArgs = ['observaciones'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                      id="observaciones" name="observaciones" 
                                      rows="3" placeholder="Observaciones o notas adicionales" maxlength="1000"><?php echo e(old('observaciones', $flujo->observaciones)); ?></textarea>
                            <small class="form-text text-muted">Máximo 1000 caracteres</small>
                            <?php $__errorArgs = ['observaciones'];
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

                    <!-- Fechas -->
                    <div class="mb-4">
                        <h6 class="text-primary mb-3">
                            <i class="fas fa-calendar-alt mr-2"></i>
                            Fechas
                        </h6>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="fecha_inicio_analisis">Fecha Inicio de Análisis</label>
                                    <input type="date" class="form-control <?php $__errorArgs = ['fecha_inicio_analisis'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                           id="fecha_inicio_analisis" name="fecha_inicio_analisis"
                                           value="<?php echo e(old('fecha_inicio_analisis', $flujo->fecha_inicio_analisis ? $flujo->fecha_inicio_analisis->format('Y-m-d') : '')); ?>">
                                    <?php $__errorArgs = ['fecha_inicio_analisis'];
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
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="fecha_firma_version">Fecha Firma de Versión</label>
                                    <input type="date" class="form-control <?php $__errorArgs = ['fecha_firma_version'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                           id="fecha_firma_version" name="fecha_firma_version"
                                           value="<?php echo e(old('fecha_firma_version', $flujo->fecha_firma_version ? $flujo->fecha_firma_version->format('Y-m-d') : '')); ?>">
                                    <small class="form-text text-muted">Debe ser igual o posterior a la fecha de inicio</small>
                                    <?php $__errorArgs = ['fecha_firma_version'];
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
                        </div>
                    </div>

                    <hr class="my-4">

                    <!-- Personas -->
                    <div class="mb-4">
                        <h6 class="text-primary mb-3">
                            <i class="fas fa-users mr-2"></i>
                            Personas Involucradas
                        </h6>

                        <div class="form-group">
                            <label for="personas">Seleccionar Personas</label>
                            <select class="form-control <?php $__errorArgs = ['personas'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                    id="personas" name="personas[]" multiple size="6">
                                <?php $__currentLoopData = $personas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $persona): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($persona->id); ?>"
                                        <?php echo e(in_array($persona->id, $personasSeleccionadas) ? 'selected' : ''); ?>>
                                        <?php echo e($persona->apellido); ?>, <?php echo e($persona->nombres); ?>

                                    </option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                            <small class="form-text text-muted">
                                <i class="fas fa-info-circle mr-1"></i>
                                Mantén Ctrl/Cmd presionado para seleccionar múltiples personas
                            </small>
                            <?php $__errorArgs = ['personas'];
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

                    <!-- Tipos de Actores (Roles) -->
                    <div class="mb-4">
                        <h6 class="text-primary mb-3">
                            <i class="fas fa-shield-alt mr-2"></i>
                            Roles/Tipos de Actores
                        </h6>

                        <div class="form-group">
                            <label for="tipos_actores">Seleccionar Roles</label>
                            <select class="form-control <?php $__errorArgs = ['tipos_actores'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                    id="tipos_actores" name="tipos_actores[]" multiple size="6">
                                <?php $__currentLoopData = $tiposActores; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $actor): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($actor->id); ?>"
                                        <?php echo e(in_array($actor->id, $tiposActoresSeleccionados) ? 'selected' : ''); ?>>
                                        <?php echo e($actor->descripcion); ?>

                                    </option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                            <small class="form-text text-muted">
                                <i class="fas fa-info-circle mr-1"></i>
                                Mantén Ctrl/Cmd presionado para seleccionar múltiples roles
                            </small>
                            <?php $__errorArgs = ['tipos_actores'];
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

                    <!-- Botones de Acción -->
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary-pro">
                            <i class="fas fa-save mr-1"></i>Guardar Cambios
                        </button>
                        <a href="<?php echo e(route('internal.procesos.flujos.show', [$proceso->id, $flujo->id])); ?>" class="btn btn-secondary">
                            <i class="fas fa-times mr-1"></i>Cancelar
                        </a>
                        <a href="<?php echo e(route('internal.procesos.show', $proceso->id)); ?>" class="btn btn-outline-secondary">
                            <i class="fas fa-arrow-left mr-1"></i>Volver al Proceso
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
document.getElementById('editFlujoForm')?.addEventListener('submit', function(e) {
    // Validar fechas
    const fechaInicio = document.getElementById('fecha_inicio_analisis').value;
    const fechaFirma = document.getElementById('fecha_firma_version').value;
    
    if (fechaInicio && fechaFirma && new Date(fechaFirma) < new Date(fechaInicio)) {
        e.preventDefault();
        alert('La fecha de firma debe ser igual o posterior a la fecha de inicio del análisis');
        return false;
    }
});
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /var/www/html/resources/views/internal/flujos/edit_standalone.blade.php ENDPATH**/ ?>