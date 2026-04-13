<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class TiposFlujosProcesosSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        $items = [
            'Inicial',
            'Revision',
        ];

        foreach ($items as $descripcion) {
            if (! DB::table('tipos_flujos_procesos')->where('descripcion', $descripcion)->exists()) {
                DB::table('tipos_flujos_procesos')->insert([
                    'id' => (string) Str::uuid(),
                    'descripcion' => $descripcion,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }
}
