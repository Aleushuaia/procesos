<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EnsureTelescopeAdminSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        // Try find a user that already has an admin role
        $user = User::whereHas('roles', function ($q) {
            $q->whereIn('name', ['Administrador', 'administrador', 'admin']);
        })->first();

        // Fallback: try known default admin email used by seeders
        if (! $user) {
            $user = User::where('email', 'admin@procesos.local')->first();
        }

        if ($user) {
            // Ensure role assigned (idempotent)
            if (method_exists($user, 'assignRole')) {
                $user->assignRole('administrador');
            }
        }
    }
}
