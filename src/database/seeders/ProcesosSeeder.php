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
        $unidadesResponsables = DB::table('unidades_responsables')->pluck('id')->toArray();
        $tiposFlujo = DB::table('tipos_flujos')->pluck('id')->toArray();
        $tiposActor = DB::table('tipos_actores')->pluck('id')->toArray();
        $personas = DB::table('personas')->pluck('id')->toArray();

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
                'unidad_responsable_id' => $unidadesResponsables[array_rand($unidadesResponsables)],
                'codigo' => 'PROC-' . str_pad($i + 1, 3, '0', STR_PAD_LEFT),
                'objetivo' => $faker->sentence(10),
                'responsable_proceso_id' => null,
                'proceso_padre_id' => null,
                'requiere_revision' => rand(0, 1),
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            // Crear 1-3 flujos para cada proceso
            $numFlujos = rand(1, 3);
            for ($j = 0; $j < $numFlujos; $j++) {
                $flujoId = (string) Str::uuid();
                
                DB::table('flujos')->insert([
                    'id' => $flujoId,
                    'proceso_id' => $procesoId,
                    'descripcion' => 'Flujo ' . ($j + 1) . ': ' . $faker->sentence(5),
                    'observaciones' => rand(0, 1) ? $faker->sentence(4) : null,
                    'tipo_flujo_id' => $tiposFlujo[array_rand($tiposFlujo)],
                    'fecha_inicio_analisis' => rand(0, 1) ? now()->subDays(rand(1, 90)) : null,
                    'fecha_firma_version' => rand(0, 1) ? now()->subDays(rand(1, 30)) : null,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);

                // Asociar 1-2 roles al flujo
                $numRoles = rand(1, 2);
                $rolesSeleccionados = array_rand($tiposActor, min($numRoles, count($tiposActor)));
                if (!is_array($rolesSeleccionados)) {
                    $rolesSeleccionados = [$rolesSeleccionados];
                }
                
                foreach ($rolesSeleccionados as $rolIndex) {
                    DB::table('flujo_rol')->insert([
                        'id' => (string) Str::uuid(),
                        'flujo_id' => $flujoId,
                        'tipo_actor_id' => $tiposActor[$rolIndex],
                        'observaciones' => rand(0, 1) ? $faker->sentence(3) : null,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }

                // Asociar 1-3 personas al flujo
                $numPersonas = rand(1, 3);
                $personasSeleccionadas = array_rand($personas, min($numPersonas, count($personas)));
                if (!is_array($personasSeleccionadas)) {
                    $personasSeleccionadas = [$personasSeleccionadas];
                }
                
                foreach ($personasSeleccionadas as $personaIndex) {
                    DB::table('flujo_persona')->insert([
                        'id' => (string) Str::uuid(),
                        'flujo_id' => $flujoId,
                        'persona_id' => $personas[$personaIndex],
                        'observaciones' => rand(0, 1) ? $faker->sentence(3) : null,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }
            }
        }
    }
}
