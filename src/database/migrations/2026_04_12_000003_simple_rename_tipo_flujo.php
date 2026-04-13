<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class SimpleRenameTipoFlujo extends Migration
{
    public function up()
    {
        if (Schema::hasTable('flujos') && Schema::hasColumn('flujos', 'tipo_flujo_proceso_id')) {
            Schema::table('flujos', function (Blueprint $table) {
                $table->renameColumn('tipo_flujo_proceso_id', 'tipo_flujo_id');
            });
        }
    }

    public function down()
    {

    }
}
