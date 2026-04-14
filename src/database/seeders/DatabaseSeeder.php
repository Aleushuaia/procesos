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
            ProcessConfigSeeder::class,
        ]);

        // Then create test users
        $admin = User::factory()->create([
            'name' => 'Administrador',
            'email' => 'admin@procesos.local',
            'password' => bcrypt('password123'),
        ]);
        
        // Roles management removed; create users without assigning roles here
        // (role assignment was handled by RolesSeeder, which has been removed)
        
        $agent = User::factory()->create([
            'name' => 'Agente',
            'email' => 'agente@procesos.local',
            'password' => bcrypt('password123'),
        ]);
        
        // role assignment removed
    }
}
