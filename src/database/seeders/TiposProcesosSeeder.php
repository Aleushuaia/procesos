<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class TiposProcesosSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        $types = [
            'Estratégico',
            'Operativo',
            'Soporte',
        ];

        foreach ($types as $type) {
            DB::table('tipos_procesos')->updateOrInsert(
                ['descripcion' => $type],
                [
                    'id' => (string) Str::uuid(),
                    'descripcion' => $type,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]
            );
        }
    }
}
