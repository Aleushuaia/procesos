<?php

namespace App\Http\Controllers;

use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Http\Request;
use Illuminate\Authorization\Access\AuthorizationException;

class AccessControlController extends Controller
{
    /**
     * Constructor - aplicar middleware de autenticación y autorización
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:Administrador|administrador|admin');
    }

    /**
     * Mostrar página principal de gestión de acceso
     */
    public function index()
    {
        $roles = Role::all();
        $permissions = Permission::all();
        $users = User::with('roles')->get();

        // Agrupar permisos por módulo
        $permissionsByModule = $permissions->groupBy(function ($permission) {
            return explode('.', $permission->name)[0];
        });

        return view('settings.access-control', [
            'roles' => $roles,
            'permissions' => $permissions,
            'permissionsByModule' => $permissionsByModule,
            'users' => $users,
        ]);
    }

    /**
     * Obtener detalles de un rol (JSON)
     */
    public function getRoleDetails(Role $role)
    {
        $permissions = $role->permissions()->pluck('name')->toArray();
        $userCount = $role->users()->count();

        return response()->json([
            'id' => $role->id,
            'name' => $role->name,
            'permissions' => $permissions,
            'userCount' => $userCount,
        ]);
    }

    /**
     * Actualizar permisos de un rol
     */
    public function updateRolePermissions(Request $request, Role $role)
    {
        $request->validate([
            'permissions' => 'array',
            'permissions.*' => 'exists:permissions,name',
        ]);

        $role->syncPermissions($request->permissions ?? []);

        return response()->json([
            'success' => true,
            'message' => "Permisos del rol '{$role->name}' actualizados correctamente.",
        ]);
    }

    /**
     * Asignar rol a usuario
     */
    public function assignRoleToUser(Request $request, User $user)
    {
        $request->validate([
            'role' => 'required|exists:roles,name',
        ]);

        $user->syncRoles($request->role);

        return response()->json([
            'success' => true,
            'message' => "Rol '{$request->role}' asignado a {$user->name} correctamente.",
        ]);
    }

    /**
     * Remover rol de usuario
     */
    public function removeRoleFromUser(Request $request, User $user)
    {
        $request->validate([
            'role' => 'required|exists:roles,name',
        ]);

        $user->removeRole($request->role);

        return response()->json([
            'success' => true,
            'message' => "Rol '{$request->role}' removido de {$user->name} correctamente.",
        ]);
    }

    /**
     * Crear nuevo rol
     */
    public function createRole(Request $request)
    {
        $request->validate([
            'name' => 'required|string|unique:roles,name|max:255',
        ]);

        $role = Role::create([
            'name' => $request->name,
            'guard_name' => 'web',
        ]);

        return response()->json([
            'success' => true,
            'message' => "Rol '{$role->name}' creado correctamente.",
            'role' => $role,
        ]);
    }

    /**
     * Eliminar rol
     */
    public function deleteRole(Role $role)
    {
        // Prevenir eliminación de roles críticos
        if (in_array($role->name, ['administrador', 'agente'])) {
            return response()->json([
                'success' => false,
                'message' => "No se puede eliminar el rol '{$role->name}'.",
            ], 403);
        }

        $name = $role->name;
        $role->forceDelete();

        return response()->json([
            'success' => true,
            'message' => "Rol '{$name}' eliminado correctamente.",
        ]);
    }
}
