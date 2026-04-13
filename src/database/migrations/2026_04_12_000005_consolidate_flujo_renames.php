<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ConsolidateFlujoRenames extends Migration
{
    /**
     * Run the migrations.
     * Asegura que TODOS los renombres esperados se hayan completado.
     * Idempotente: seguro ejecutar múltiples veces.
     *
     * @return void
     */
    public function up()
    {
        // TABLAS PRINCIPALES
        if (Schema::hasTable('proceso_flujos') && !Schema::hasTable('flujos')) {
            Schema::rename('proceso_flujos', 'flujos');
        }

        if (Schema::hasTable('tipos_flujos_procesos') && !Schema::hasTable('tipos_flujos')) {
            Schema::rename('tipos_flujos_procesos', 'tipos_flujos');
        }

        if (Schema::hasTable('tipos_procesos') && !Schema::hasTable('tipos_flujos')) {
            Schema::rename('tipos_procesos', 'tipos_flujos');
        }

        // TABLAS RELACIONADAS
        if (Schema::hasTable('proceso_flujo_documento') && !Schema::hasTable('flujo_documento')) {
            Schema::rename('proceso_flujo_documento', 'flujo_documento');
        }

        if (Schema::hasTable('proceso_flujo_persona') && !Schema::hasTable('flujo_persona')) {
            Schema::rename('proceso_flujo_persona', 'flujo_persona');
        }

        if (Schema::hasTable('proceso_flujo_rol') && !Schema::hasTable('flujo_rol')) {
            Schema::rename('proceso_flujo_rol', 'flujo_rol');
        }

        // COLUMNA EN flujos
        if (Schema::hasTable('flujos') && Schema::hasColumn('flujos', 'tipo_flujo_proceso_id') && !Schema::hasColumn('flujos', 'tipo_flujo_id')) {
            Schema::table('flujos', function (Blueprint $table) {
                $table->renameColumn('tipo_flujo_proceso_id', 'tipo_flujo_id');
            });
        }
    }

    /**
     * Reverse the migrations.
     * Revierte únicamente los cambios de esta migración.
     *
     * @return void
     */
    public function down()
    {
        // Revertir renombres en orden inverso (si es necesario)
        if (Schema::hasTable('flujo_documento') && !Schema::hasTable('proceso_flujo_documento')) {
            Schema::rename('flujo_documento', 'proceso_flujo_documento');
        }

        if (Schema::hasTable('flujo_persona') && !Schema::hasTable('proceso_flujo_persona')) {
            Schema::rename('flujo_persona', 'proceso_flujo_persona');
        }

        if (Schema::hasTable('flujo_rol') && !Schema::hasTable('proceso_flujo_rol')) {
            Schema::rename('flujo_rol', 'proceso_flujo_rol');
        }

        if (Schema::hasTable('flujos') && !Schema::hasTable('proceso_flujos')) {
            Schema::rename('flujos', 'proceso_flujos');
        }

        if (Schema::hasTable('tipos_flujos') && !Schema::hasTable('tipos_flujos_procesos') && !Schema::hasTable('tipos_procesos')) {
            Schema::rename('tipos_flujos', 'tipos_flujos_procesos');
        }

        if (Schema::hasTable('flujos') && Schema::hasColumn('flujos', 'tipo_flujo_id') && !Schema::hasColumn('flujos', 'tipo_flujo_proceso_id')) {
            Schema::table('flujos', function (Blueprint $table) {
                $table->renameColumn('tipo_flujo_id', 'tipo_flujo_proceso_id');
            });
        }
    }
}
