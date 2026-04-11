<?php

namespace Database\Seeders;

use Spatie\Permission\Models\Permission;
use Illuminate\Database\Seeder;

class PermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Resetear cache de permisos (si existe)
        try {
            if (app()->bound('cache')) {
                app()['cache']->forget('spatie.permission.cache');
            }
        } catch (\Exception $e) {
            // Ignorar errores de cache durante migration
        }

        $modules = [
            'procesos' => ['Procesos'],
            'usuarios' => ['Usuarios'],
            'reports'  => ['Reportes'],
        ];

        $actions = ['view', 'create', 'update', 'delete'];

        foreach ($modules as $module => $labels) {
            foreach ($actions as $action) {
                Permission::firstOrCreate([
                    'name' => "{$module}.{$action}",
                    'guard_name' => 'web',
                ]);
            }
        }
    }
}
