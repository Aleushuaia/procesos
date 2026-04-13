<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class EstadosProcesosSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        $items = [
            'Borrador',
            'En análisis',
            'En revisión',
            'Aprobado',
            'Vigente',
            'Observado',
            'Archivado',
        ];

        foreach ($items as $descripcion) {
            if (! DB::table('estados_procesos')->where('descripcion', $descripcion)->exists()) {
                DB::table('estados_procesos')->insert([
                    'id' => (string) Str::uuid(),
                    'descripcion' => $descripcion,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }
}
