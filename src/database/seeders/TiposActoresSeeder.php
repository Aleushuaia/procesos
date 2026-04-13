<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class TiposActoresSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        $types = [
            'analista',
        ];

        foreach ($types as $type) {
            $descripcion = ucfirst($type);

            $exists = DB::table('tipos_actores')->where('descripcion', $descripcion)->exists();

            if (! $exists) {
                DB::table('tipos_actores')->insert([
                    'id' => (string) Str::uuid(),
                    'descripcion' => $descripcion,
                    'observaciones' => null,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }
}
