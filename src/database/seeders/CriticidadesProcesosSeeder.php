<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CriticidadesProcesosSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        $items = [
            'Baja',
            'Media',
            'Alta',
        ];

        foreach ($items as $descripcion) {
            if (! DB::table('criticidades_procesos')->where('descripcion', $descripcion)->exists()) {
                DB::table('criticidades_procesos')->insert([
                    'id' => (string) Str::uuid(),
                    'descripcion' => $descripcion,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }
}
