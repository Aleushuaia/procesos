<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class UnidadesResponsablesSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        $unidades = [
            'Dirección General',
            'Recursos Humanos',
            'Finanzas',
            'Operaciones',
            'Tecnología',
            'Ventas',
            'Logística',
            'Calidad',
        ];

        foreach ($unidades as $descripcion) {
            if (! DB::table('unidades_responsables')->where('descripcion', $descripcion)->exists()) {
                DB::table('unidades_responsables')->insert([
                    'id' => (string) Str::uuid(),
                    'descripcion' => $descripcion,
                    'unidad_madre_id' => null,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }
}
