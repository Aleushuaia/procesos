<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class TipoProcesoDocumentoSeeder extends Seeder
{
    public function run(): void
    {
        $tipos = [
            'Manual de Procedimiento',
            'Diagrama de Flujo',
            'Formulario',
            'Instructivo',
            'Política',
            'Reglamento',
            'Acta',
            'Informe',
            'Anexo',
            'Otro',
        ];

        foreach ($tipos as $descripcion) {
            $exists = DB::table('tipos_procesos_documentos')
                ->where('descripcion', $descripcion)
                ->exists();

            if (!$exists) {
                DB::table('tipos_procesos_documentos')->insert([
                    'id'          => (string) Str::uuid(),
                    'descripcion' => $descripcion,
                    'created_at'  => now(),
                    'updated_at'  => now(),
                ]);
            }
        }
    }
}
