<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Faker\Factory as Faker;

class ProcesosSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        $faker = Faker::create('es_ES');

        // Obtener IDs necesarios
        $tiposProceso = DB::table('tipos_procesos')->pluck('id')->toArray();
        $estadosProceso = DB::table('estados_procesos')->pluck('id')->toArray();
        $criticidadesProceso = DB::table('criticidades_procesos')->pluck('id')->toArray();

        // Catálogo de procesos en español
        $descriptoresProceso = [
            'Gestión de Ventas', 'Aprovisionamiento de Materiales', 'Control de Calidad',
            'Capacitación de Personal', 'Gestión de Nómina', 'Mantenimiento de Equipos',
            'Logística de Distribución', 'Auditoría Interna', 'Atención al Cliente',
            'Facturación y Cobro', 'Gestión de Inventario', 'Procuración de Contratos',
            'Planificación Estratégica', 'Análisis de Riesgos', 'Cumplimiento Normativo',
            'Desarrollo de Productos', 'Gestión de Proyectos', 'Seguridad Industrial',
            'Administración de Activos', 'Gestión de Permisos', 'Evaluación de Desempeño',
            'Investigación de Mercado', 'Gestión de Documentos', 'Comunicaciones Internas',
            'Análisis Financiero', 'Planificación de Recursos', 'Evaluación de Proveedores',
            'Gestión de Cambios', 'Recuperación ante Desastres', 'Seguridad de Datos',
            'Optimización de Procesos', 'Gestión de Partes Interesadas'
        ];

        // Crear 32 procesos
        for ($i = 0; $i < 32; $i++) {
            $procesoId = (string) Str::uuid();
            
            DB::table('procesos')->insert([
                'id' => $procesoId,
                'descripcion' => $descriptoresProceso[$i % count($descriptoresProceso)],
                'observaciones' => $faker->sentence(8),
                'tipo_proceso_id' => $tiposProceso[array_rand($tiposProceso)],
                'estado_proceso_id' => $estadosProceso[array_rand($estadosProceso)],
                'criticidad_proceso_id' => $criticidadesProceso[array_rand($criticidadesProceso)],
                'codigo' => 'PROC-' . str_pad($i + 1, 3, '0', STR_PAD_LEFT),
                'objetivo' => $faker->sentence(10),
                'proceso_padre_id' => null,
                'requiere_revision' => rand(0, 1),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
