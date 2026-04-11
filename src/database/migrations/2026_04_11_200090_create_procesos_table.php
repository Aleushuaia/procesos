<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('procesos', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('descripcion', 100);
            $table->text('observaciones')->nullable();
            $table->uuid('tipo_proceso_id');
            $table->uuid('estado_proceso_id');
            $table->uuid('criticidad_proceso_id');
            $table->uuid('unidad_responsable_id');
            $table->string('codigo', 50)->nullable();
            $table->text('objetivo')->nullable();
            $table->uuid('responsable_proceso_id')->nullable();
            $table->uuid('proceso_padre_id')->nullable();
            $table->boolean('requiere_revision')->default(false);
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('tipo_proceso_id')->references('id')->on('tipos_procesos')->cascadeOnDelete();
            $table->foreign('estado_proceso_id')->references('id')->on('estados_procesos')->cascadeOnDelete();
            $table->foreign('criticidad_proceso_id')->references('id')->on('criticidades_procesos')->cascadeOnDelete();
            $table->foreign('unidad_responsable_id')->references('id')->on('unidades_responsables')->cascadeOnDelete();
            $table->foreign('responsable_proceso_id')->references('id')->on('personas')->nullOnDelete();
            $table->foreign('proceso_padre_id')->references('id')->on('procesos')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('procesos');
    }
};
