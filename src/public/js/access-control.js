/**
 * access-control.js
 * Gestión interactiva de usuarios, roles y permisos
 */

(function () {
    'use strict';

    const API = {
        getRoleDetails: (roleId) => `/settings/access-control/role/${roleId}`,
        updatePermissions: (roleId) => `/settings/access-control/role/${roleId}/permissions`,
        createRole: () => `/settings/access-control/role`,
        deleteRole: (roleId) => `/settings/access-control/role/${roleId}`,
        assignRole: (userId) => `/settings/access-control/user/${userId}/role`,
        removeRole: (userId) => `/settings/access-control/user/${userId}/role`,
    };

    // ============================================================================
    // TABS Y ELEMENTOS
    // ============================================================================
    const elements = {
        roleModal: $('#roleModal'),
        assignRoleModal: $('#assignRoleModal'),
        roleForm: $('#roleForm'),
        assignRoleForm: $('#assignRoleForm'),
        roleSelector: $('#roleSelector'),
        permissionMatrixContainer: $('#permissionMatrixContainer'),
        permissionMatrixBody: $('#permissionMatrixBody'),
        btnSavePermissions: $('#btnSavePermissions'),
        btnCreateRole: $('#btnCreateRole'),
        rolesTable: $('#rolesTable'),
        usersTable: $('#usersTable'),
    };

    // ============================================================================
    // UTILIDADES
    // ============================================================================
    function showAlert(message, type = 'info') {
        const alertClass = `alert-${type}`;
        const alertHtml = `
            <div class="alert ${alertClass} alert-dismissible fade show" role="alert">
                <strong>${type === 'success' ? '✓' : '!'}</strong> ${message}
                <button type="button" class="close" data-dismiss="alert" aria-label="Cerrar">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        `;
        $('#accessControlTabs').before(alertHtml);
        setTimeout(() => $('.alert').fadeOut(), 4000);
    }

    function getCsrfToken() {
        return $('meta[name="csrf-token"]').attr('content');
    }

    // ============================================================================
    // SECCIÓN: CREAR ROL
    // ============================================================================
    elements.roleForm.on('submit', function (e) {
        e.preventDefault();

        const data = {
            name: $('#roleName').val(),
            _token: getCsrfToken(),
        };

        $.ajax({
            url: API.createRole(),
            type: 'POST',
            data: data,
            success: function (response) {
                showAlert(response.message, 'success');
                elements.roleForm[0].reset();
                elements.roleModal.modal('hide');
                location.reload(); // Recargar para ver el nuevo rol
            },
            error: function (xhr) {
                const error = xhr.responseJSON?.message || 'Error al crear el rol';
                showAlert(error, 'danger');
            },
        });
    });

    // ============================================================================
    // SECCIÓN: ELIMINAR ROL
    // ============================================================================
    $(document).on('click', '.btnDeleteRole', function () {
        const roleId = $(this).data('role-id');
        const roleName = $(this).closest('tr').find('.badge').text();

        if (!confirm(`¿Confirmas la eliminación del rol "${roleName}"?`)) return;

        $.ajax({
            url: API.deleteRole(roleId),
            type: 'DELETE',
            headers: { 'X-CSRF-TOKEN': getCsrfToken() },
            success: function (response) {
                showAlert(response.message, 'success');
                setTimeout(() => location.reload(), 1000);
            },
            error: function (xhr) {
                const error = xhr.responseJSON?.message || 'Error al eliminar el rol';
                showAlert(error, 'danger');
            },
        });
    });

    // ============================================================================
    // MATRIZ DE PERMISOS
    // ============================================================================
    elements.roleSelector.on('change', function () {
        const roleId = $(this).val();
        if (!roleId) {
            elements.permissionMatrixContainer.hide();
            return;
        }

        $.ajax({
            url: API.getRoleDetails(roleId),
            type: 'GET',
            success: function (response) {
                renderPermissionMatrix(roleId, response.permissions);
                elements.permissionMatrixContainer.show();
            },
            error: function () {
                showAlert('Error al cargar los permisos', 'danger');
            },
        });
    });

    function renderPermissionMatrix(roleId, currentPermissions) {
        const permissionsByModule = window.PERMISSIONS_BY_MODULE || {};

        let html = '';
        Object.keys(permissionsByModule).forEach(function (module) {
            const modulePerms = permissionsByModule[module] || [];
            const actionMap = {};
            modulePerms.forEach(function (perm) {
                const action = (perm.name || '').split('.')[1];
                actionMap[action] = perm.name;
            });

            html += `
                <tr>
                    <td class="font-weight-bold text-primary">${ucFirst(module)}</td>
            `;

            ['view', 'create', 'update', 'delete'].forEach(function (action) {
                const permName = actionMap[action] || '';
                const isChecked = permName && currentPermissions.includes(permName) ? 'checked' : '';
                const inputId = permName ? permName.replace(/[^a-zA-Z0-9_-]/g,'_') : '';
                html += `
                    <td class="text-center">
                        ${permName ? `
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" 
                                   class="custom-control-input permission-checkbox" 
                                   id="${inputId}" 
                                   value="${permName}" 
                                   data-role-id="${roleId}"
                                   ${isChecked}>
                            <label class="custom-control-label" for="${inputId}"></label>
                        </div>` : ''}
                    </td>
                `;
            });

            html += '</tr>';
        });

        elements.permissionMatrixBody.html(html);
        elements.btnSavePermissions.show();
    }

    elements.btnSavePermissions.on('click', function () {
        const roleId = elements.roleSelector.val();
        const permissions = [];

        elements.permissionMatrixBody.find('.permission-checkbox:checked').each(function () {
            permissions.push($(this).val());
        });

        $.ajax({
            url: API.updatePermissions(roleId),
            type: 'POST',
            data: {
                permissions: permissions,
                _token: getCsrfToken(),
            },
            success: function (response) {
                showAlert(response.message, 'success');
            },
            error: function (xhr) {
                const error = xhr.responseJSON?.message || 'Error al actualizar permisos';
                showAlert(error, 'danger');
            },
        });
    });

    // ============================================================================
    // ASIGNAR ROLES A USUARIOS
    // ============================================================================
    $(document).on('click', '.btnAssignRole', function () {
        const userId = $(this).data('user-id');
        const userName = $(this).closest('tr').find('td:first').text();

        $('#userIdInput').val(userId);
        $('#assignRoleModalLabel').text(`Asignar rol a: ${userName}`);
        elements.assignRoleModal.modal('show');
    });

    elements.assignRoleForm.on('submit', function (e) {
        e.preventDefault();

        const userId = $('#userIdInput').val();
        const role = $('#roleSelect').val();

        $.ajax({
            url: API.assignRole(userId),
            type: 'POST',
            data: {
                role: role,
                _token: getCsrfToken(),
            },
            success: function (response) {
                showAlert(response.message, 'success');
                elements.assignRoleModal.modal('hide');
                setTimeout(() => location.reload(), 1000);
            },
            error: function (xhr) {
                const error = xhr.responseJSON?.message || 'Error al asignar rol';
                showAlert(error, 'danger');
            },
        });
    });

    // ============================================================================
    // HELPERS
    // ============================================================================
    function ucFirst(str) {
        return str.charAt(0).toUpperCase() + str.slice(1);
    }

    // Inicialización
    $(document).ready(function () {
        console.log('Access Control Module Initialized');
    });
})();
