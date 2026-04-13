<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

class RenameProcesoFlujoTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Renombrar tablas específicas si existen
        if (Schema::hasTable('proceso_flujo_documento')) {
            Schema::rename('proceso_flujo_documento', 'flujo_documento');
        }

        if (Schema::hasTable('proceso_flujo_persona')) {
            Schema::rename('proceso_flujo_persona', 'flujo_persona');
        }

        if (Schema::hasTable('proceso_flujo_rol')) {
            Schema::rename('proceso_flujo_rol', 'flujo_rol');
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
