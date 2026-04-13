<?php

namespace Database\Seeders;

use Spatie\Permission\Models\Role;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class RolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Crear roles
        $admin = Role::firstOrCreate([
            'name' => 'administrador',
            'guard_name' => 'web',
        ]);

        $agent = Role::firstOrCreate([
            'name' => 'agente',
            'guard_name' => 'web',
        ]);

        // Obtener todos los permisos y asignarlos manualmente al admin
        $allPermissions = \Spatie\Permission\Models\Permission::all();
        
        foreach ($allPermissions as $permission) {
            \DB::table('role_has_permissions')->insertOrIgnore([
                'permission_id' => $permission->id,
                'role_id' => $admin->id,
            ]);
        }

        // Asignar permisos limitados al agente
        $agentPermissionNames = [
            'procesos.view',
            'procesos.create',
            'reports.view',
        ];
        
        $agentPermissions = \Spatie\Permission\Models\Permission::whereIn('name', $agentPermissionNames)->get();
        foreach ($agentPermissions as $permission) {
            \DB::table('role_has_permissions')->insertOrIgnore([
                'permission_id' => $permission->id,
                'role_id' => $agent->id,
            ]);
        }

        // Crear usuarios de prueba y asignar roles
        $adminUser = User::firstOrCreate(
            ['email' => 'admin@prueba.local'],
            [
                'name' => 'Usuario Administrador',
                'password' => Hash::make('password'),
            ]
        );
        $adminUser->assignRole($admin->name);

        $agentUser = User::firstOrCreate(
            ['email' => 'agente@prueba.local'],
            [
                'name' => 'Usuario Agente',
                'password' => Hash::make('password'),
            ]
        );
        $agentUser->assignRole($agent->name);
    }
}
