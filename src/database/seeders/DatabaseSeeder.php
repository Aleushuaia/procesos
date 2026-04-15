<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // First, create permissions and roles
        $this->call([
            PermissionsSeeder::class,
            RolesSeeder::class,
            ProcessConfigSeeder::class,
        ]);

        // Then create test users with roles assigned
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
    }
}
