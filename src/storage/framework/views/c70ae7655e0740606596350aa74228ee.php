<?php $__env->startSection('title', 'Editar Criticidad'); ?>

<?php $__env->startSection('page_title', 'Editar Criticidad'); ?>

<?php $__env->startSection('breadcrumb'); ?>
    <li class="breadcrumb-item"><a href="<?php echo e(route('internal.criticidades.index')); ?>">Criticidades</a></li>
    <li class="breadcrumb-item active"><?php echo e($criticidad->descripcion ?? 'Editar'); ?></li>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header bg-light">
                <h5 class="card-title mb-0"><i class="fas fa-edit mr-2 text-muted"></i>Editar Criticidad: <?php echo e($criticidad->descripcion); ?></h5>
            </div>
            <form action="<?php echo e(route('internal.criticidades.update', $criticidad->id)); ?>" method="POST" class="card-body">
                <?php echo csrf_field(); ?>
                <?php echo method_field('PUT'); ?>
                
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
                           value="<?php echo e(old('descripcion', $criticidad->descripcion)); ?>" 
                           required maxlength="100">
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
                    <label for="color">Color de Criticidad <span class="text-danger">*</span></label>
                    <div class="d-flex align-items-center gap-3">
                        <input type="color" class="form-control <?php $__errorArgs = ['color'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                               id="color" name="color" 
                               value="<?php echo e(old('color', $criticidad->color ?? '#dc3545')); ?>" 
                               style="width: 100px; height: 45px; cursor: pointer;">
                        <div id="colorPreview" style="padding: 8px 16px; border-radius: 4px; color: white; font-weight: 500; background-color: <?php echo e(old('color', $criticidad->color ?? '#dc3545')); ?>; min-width: 200px; text-align: center;">
                            <i class="fas fa-exclamation-triangle mr-2"></i><?php echo e($criticidad->descripcion); ?>

                        </div>
                    </div>
                    <small class="text-muted d-block mt-2">Selecciona el color para mostrar esta criticidad en el sistema</small>
                    <?php $__errorArgs = ['color'];
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

                <hr class="my-4">

                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save mr-2"></i> Guardar Cambios
                    </button>
                    <a href="<?php echo e(route('internal.criticidades.index')); ?>" class="btn btn-secondary">
                        <i class="fas fa-arrow-left mr-2"></i> Volver
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.getElementById('color').addEventListener('change', function() {
    document.getElementById('colorPreview').style.backgroundColor = this.value;
});
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /var/www/html/resources/views/internal/criticidades/edit.blade.php ENDPATH**/ ?>