<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Truncate tables in correct order (respecting foreign keys)
        $this->truncateTables();

        // First, create permissions and roles configuration
        $this->call([
            PermissionsSeeder::class,
            RolesSeeder::class,
            ProcessConfigSeeder::class,
        ]);

        // Then create core data (tipos and estados)
        $this->call([
            TiposProcesosSeeder::class,
            EstadosProcesosSeeder::class,
            CriticidadesProcesosSeeder::class,
            TiposActoresSeeder::class,
        ]);

        // Create organizational structure
        $this->call([
            UnidadesResponsablesSeeder::class,
            PersonasSeeder::class,
        ]);

        // Create processes and flows
        $this->call([
            ProcesosSeeder::class,
            TipoProcesoDocumentoSeeder::class,
        ]);

        // Create test users with roles assigned
        $admin = User::factory()->create([
            'name' => 'Administrador',
            'email' => 'admin@procesos.local',
            'password' => bcrypt('password123'),
        ]);
        
        // Assign Administrador role to admin user
        $admin->assignRole('Administrador');
        
        $agent = User::factory()->create([
            'name' => 'Agente',
            'email' => 'agente@procesos.local',
            'password' => bcrypt('password123'),
        ]);
        
        // Assign Agente role to agent user
        $agent->assignRole('Agente');

        $this->command->info('✓ Database seeded successfully!');
        $this->command->info('Users created:');
        $this->command->info('  - Admin: admin@procesos.local / password123');
        $this->command->info('  - Agent: agente@procesos.local / password123');
    }

    /**
     * Truncate all tables in the correct order
     */
    private function truncateTables(): void
    {
        $tables = [
            'procesos',
            'personas',
            'unidades_responsables',
            'tipos_actores',
            'criticidades_procesos',
            'estados_procesos',
            'tipos_procesos',
            'roles',
            'permissions',
            'model_has_roles',
            'model_has_permissions',
            'role_has_permissions',
            'users',
        ];

        $connection = DB::connection()->getDriverName();
        
        if ($connection === 'pgsql') {
            // PostgreSQL - disable constraints
            DB::statement('SET CONSTRAINTS ALL DEFERRED;');
        } else {
            // MySQL
            DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        }

        foreach ($tables as $table) {
            if (DB::connection()->getSchemaBuilder()->hasTable($table)) {
                DB::table($table)->truncate();
            }
        }

        if ($connection === 'pgsql') {
            DB::statement('SET CONSTRAINTS ALL IMMEDIATE;');
        } else {
            DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        }
        
        $this->command->info('✓ Tables truncated successfully');
    }
}
