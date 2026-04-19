<?php $__env->startSection('title', 'Gestion de accceso'); ?>
<?php $__env->startSection('page_title', 'Gestion de accceso'); ?>

<?php $__env->startSection('breadcrumb'); ?>
    <li class="breadcrumb-item"><a href="#">Ajustes</a></li>
    <li class="breadcrumb-item active">Gestión de Acceso</li>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>


<div class="nav-tabs-custom card card-primary card-outline">
    <ul class="nav nav-tabs" id="accessControlTabs" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active" id="roles-tab" data-toggle="tab" data-target="#rolesSection" type="button" role="tab" aria-controls="rolesSection" aria-selected="true">
                <i class="fas fa-id-badge mr-2"></i> Roles
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="permissions-tab" data-toggle="tab" data-target="#permissionsSection" type="button" role="tab" aria-controls="permissionsSection" aria-selected="false">
                <i class="fas fa-lock mr-2"></i> Permisos
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="users-tab" data-toggle="tab" data-target="#usersSection" type="button" role="tab" aria-controls="usersSection" aria-selected="false">
                <i class="fas fa-users mr-2"></i> Usuarios
            </button>
        </li>
    </ul>

    <div class="tab-content p-4">

        
        <div class="tab-pane fade show active" id="rolesSection" role="tabpanel" aria-labelledby="roles-tab">
            <div class="row">
                
                <div class="col-12 mb-3">
                    <button class="btn btn-sm btn-primary" id="btnCreateRole" data-toggle="modal" data-target="#roleModal">
                        <i class="fas fa-plus mr-2"></i> Crear nuevo rol
                    </button>
                </div>

                
                <div class="col-12">
                    <div class="table-responsive">
                        <table class="table table-hover table-striped" id="rolesTable">
                            <thead class="thead-dark">
                                <tr>
                                    <th width="25%">Nombre del rol</th>
                                    <th width="40%">Descripción</th>
                                    <th width="15%" class="text-center">Usuarios asignados</th>
                                    <th width="20%" class="text-center">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__empty_1 = true; $__currentLoopData = $roles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $role): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                    <tr data-role-id="<?php echo e($role->id); ?>">
                                        <td>
                                            <span class="badge badge-info"><?php echo e($role->name); ?></span>
                                        </td>
                                        <td>
                                            <?php if($role->name === 'administrador'): ?>
                                                Acceso completo al sistema
                                            <?php elseif($role->name === 'agente'): ?>
                                                Acceso restringido para agentes judiciales
                                            <?php else: ?>
                                                Sin descripción
                                            <?php endif; ?>
                                        </td>
                                        <td class="text-center">
                                            <span class="badge badge-success user-count-<?php echo e($role->id); ?>">
                                                <?php echo e($role->users()->count()); ?>

                                            </span>
                                        </td>
                                        <td class="text-center">
                                            <button class="btn btn-xs btn-info btnEditRole" data-role-id="<?php echo e($role->id); ?>" title="Editar permisos">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            <?php if(!in_array($role->name, ['administrador', 'agente'])): ?>
                                                <button class="btn btn-xs btn-danger btnDeleteRole" data-role-id="<?php echo e($role->id); ?>" title="Eliminar rol">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                    <tr>
                                        <td colspan="4" class="text-center text-muted">No hay roles creados</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        
        <div class="tab-pane fade" id="permissionsSection" role="tabpanel" aria-labelledby="permissions-tab">
            <div class="row">
                <div class="col-12">
                    <p class="text-muted mb-3">
                        <i class="fas fa-info-circle mr-2"></i>
                        Selecciona un rol y configura sus permisos usando la matriz de acceso.
                    </p>
                </div>

                
                <div class="col-12 mb-4">
                    <label for="roleSelector" class="font-weight-bold">Seleccionar rol:</label>
                    <select id="roleSelector" class="form-control form-control-sm" style="max-width: 300px;">
                        <option value="">-- Selecciona un rol --</option>
                        <?php $__currentLoopData = $roles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $role): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($role->id); ?>"><?php echo e($role->name); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>

                
                <div class="col-12" id="permissionMatrixContainer" style="display: none;">
                    <div class="table-responsive">
                        <table class="table table-bordered table-sm" id="permissionMatrix">
                            <thead class="thead-light">
                                <tr>
                                    <th width="30%">Módulo</th>
                                    <th width="17.5%" class="text-center">Ver</th>
                                    <th width="17.5%" class="text-center">Crear</th>
                                    <th width="17.5%" class="text-center">Editar</th>
                                    <th width="17.5%" class="text-center">Eliminar</th>
                                </tr>
                            </thead>
                            <tbody id="permissionMatrixBody">
                            </tbody>
                        </table>
                    </div>
                    <button class="btn btn-primary" id="btnSavePermissions" style="display: none;">
                        <i class="fas fa-save mr-2"></i> Guardar cambios
                    </button>
                </div>
            </div>
        </div>

        
        <div class="tab-pane fade" id="usersSection" role="tabpanel" aria-labelledby="users-tab">
            <div class="row">
                <div class="col-12">
                    <div class="table-responsive">
                        <table class="table table-hover table-striped" id="usersTable">
                            <thead class="thead-dark">
                                <tr>
                                    <th width="25%">Nombre</th>
                                    <th width="35%">Email</th>
                                    <th width="20%">Rol actual</th>
                                    <th width="20%" class="text-center">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__empty_1 = true; $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                    <tr data-user-id="<?php echo e($user->id); ?>">
                                        <td><?php echo e($user->name); ?></td>
                                        <td><?php echo e($user->email); ?></td>
                                        <td>
                                            <?php if($user->roles->count() > 0): ?>
                                                <?php $__currentLoopData = $user->roles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $role): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <span class="badge badge-warning"><?php echo e($role->name); ?></span>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            <?php else: ?>
                                                <span class="text-muted">Sin rol asignado</span>
                                            <?php endif; ?>
                                        </td>
                                        <td class="text-center">
                                            <button class="btn btn-xs btn-primary btnAssignRole" data-user-id="<?php echo e($user->id); ?>" title="Asignar rol">
                                                <i class="fas fa-user-check"></i>
                                            </button>
                                        </td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                    <tr>
                                        <td colspan="4" class="text-center text-muted">No hay usuarios creados</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>




<div class="modal fade" id="roleModal" tabindex="-1" role="dialog" aria-labelledby="roleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="roleModalLabel">Crear nuevo rol</h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Cerrar">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="roleForm">
                <div class="modal-body">
                    <?php echo csrf_field(); ?>
                    <div class="form-group">
                        <label for="roleName">Nombre del rol</label>
                        <input type="text" class="form-control" id="roleName" name="name" required>
                        <small class="form-text text-muted">Use nombres en minúsculas sin espacios (ej: supervisor)</small>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Crear rol</button>
                </div>
            </form>
        </div>
    </div>
</div>


<div class="modal fade" id="assignRoleModal" tabindex="-1" role="dialog" aria-labelledby="assignRoleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="assignRoleModalLabel">Asignar rol a usuario</h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Cerrar">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="assignRoleForm">
                <div class="modal-body">
                    <?php echo csrf_field(); ?>
                    <input type="hidden" id="userIdInput" name="user_id">
                    <div class="form-group">
                        <label for="roleSelect">Seleccionar rol</label>
                        <select class="form-control" id="roleSelect" name="role" required>
                            <option value="">-- Selecciona un rol --</option>
                            <?php $__currentLoopData = $roles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $role): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($role->name); ?>"><?php echo e(ucfirst($role->name)); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Asignar rol</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
<script>
    window.PERMISSIONS_BY_MODULE = <?php echo json_encode($permissionsByModule ?? [], 15, 512) ?>;
</script>
<script src="<?php echo e(asset('js/access-control.js')); ?>"></script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /var/www/html/resources/views/settings/access-control.blade.php ENDPATH**/ ?>