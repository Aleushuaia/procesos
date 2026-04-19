<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class ProcesoTipoActorSeeder extends Seeder
{
    public function run(): void
    {
        // Ensure tables exist
        if (!Schema::hasTable('procesos') || !Schema::hasTable('tipos_actores') || !Schema::hasTable('proceso_tipo_actor')) {
            $this->command->info('Required tables not found; skipping ProcesoTipoActorSeeder.');
            return;
        }

        $procesos = DB::table('procesos')->pluck('id')->toArray();
        $tipos = DB::table('tipos_actores')->pluck('id')->toArray();

        if (empty($procesos) || empty($tipos)) {
            $this->command->info('No procesos or tipos_actores found; skipping seeder.');
            return;
        }

        $pairs = [];
        $existing = DB::table('proceso_tipo_actor')->select(['proceso_id','tipo_actor_id'])->get()->map(function($r){ return $r->proceso_id . '|' . $r->tipo_actor_id; })->toArray();

        $desired = 50;
        $attempts = 0;
        while (count($pairs) < $desired && $attempts < 1000) {
            $attempts++;
            $p = $procesos[array_rand($procesos)];
            $t = $tipos[array_rand($tipos)];
            $key = $p . '|' . $t;
            if (in_array($key, $existing) || isset($pairs[$key])) continue;
            $pairs[$key] = [
                'proceso_id' => $p,
                'tipo_actor_id' => $t,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        if (!empty($pairs)) {
            DB::table('proceso_tipo_actor')->insert(array_values($pairs));
            $this->command->info('Inserted ' . count($pairs) . ' proceso-tipo_actor records.');
        } else {
            $this->command->info('No new pairs generated.');
        }
    }
}
