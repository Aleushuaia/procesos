<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RenameProcesoFlujoIdColumns extends Migration
{
    public function up()
    {
        if (Schema::hasTable('flujo_documento') && Schema::hasColumn('flujo_documento', 'proceso_flujo_id')) {
            Schema::table('flujo_documento', function (Blueprint $table) {
                $table->renameColumn('proceso_flujo_id', 'flujo_id');
            });
        }

        if (Schema::hasTable('flujo_persona') && Schema::hasColumn('flujo_persona', 'proceso_flujo_id')) {
            Schema::table('flujo_persona', function (Blueprint $table) {
                $table->renameColumn('proceso_flujo_id', 'flujo_id');
            });
        }

        if (Schema::hasTable('flujo_rol') && Schema::hasColumn('flujo_rol', 'proceso_flujo_id')) {
            Schema::table('flujo_rol', function (Blueprint $table) {
                $table->renameColumn('proceso_flujo_id', 'flujo_id');
            });
        }
    }

    public function down()
    {
        if (Schema::hasTable('flujo_documento') && Schema::hasColumn('flujo_documento', 'flujo_id')) {
            Schema::table('flujo_documento', function (Blueprint $table) {
                $table->renameColumn('flujo_id', 'proceso_flujo_id');
            });
        }

        if (Schema::hasTable('flujo_persona') && Schema::hasColumn('flujo_persona', 'flujo_id')) {
            Schema::table('flujo_persona', function (Blueprint $table) {
                $table->renameColumn('flujo_id', 'proceso_flujo_id');
            });
        }

        if (Schema::hasTable('flujo_rol') && Schema::hasColumn('flujo_rol', 'flujo_id')) {
            Schema::table('flujo_rol', function (Blueprint $table) {
                $table->renameColumn('flujo_id', 'proceso_flujo_id');
            });
        }
    }
}
