<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

class RenameTablesToFlujos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Renombrar `proceso_flujos` -> `flujos`
        if (Schema::hasTable('proceso_flujos')) {
            Schema::rename('proceso_flujos', 'flujos');
        }

        // Variantes posibles para la tabla de tipos -> renombrar a `tipos_flujos`
        if (Schema::hasTable('tipos_flujos_procesos')) {
            Schema::rename('tipos_flujos_procesos', 'tipos_flujos');
        }

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {

    }
}
