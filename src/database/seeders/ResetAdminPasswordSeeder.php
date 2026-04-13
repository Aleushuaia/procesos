<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class ResetAdminPasswordSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        $email = 'admin@procesos.local';

        $user = User::where('email', $email)->first();

        if ($user) {
            // Store hashed password explicitly to avoid casting issues
            $user->password = Hash::make('password123');
            $user->save();
        }
    }
}
