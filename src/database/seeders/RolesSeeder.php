<?php

namespace Database\Seeders;

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Database\Seeder;

class RolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Crear roles
        $adminRole = Role::firstOrCreate([
            'name' => 'Administrador',
            'guard_name' => 'web',
        ]);

        $agentRole = Role::firstOrCreate([
            'name' => 'Agente',
            'guard_name' => 'web',
        ]);

        // Obtener todos los permisos
        $permissions = Permission::all();

        // Asignar todos los permisos al rol Administrador
        $adminRole->syncPermissions($permissions);

        // Asignar solo permisos de visualización y creación al rol Agente
        $agentPermissions = $permissions->filter(function ($permission) {
            return in_array($permission->name, [
                'procesos.view',
                'procesos.create',
                'usuarios.view',
                'reports.view',
            ]);
        });

        $agentRole->syncPermissions($agentPermissions);
    }
}

