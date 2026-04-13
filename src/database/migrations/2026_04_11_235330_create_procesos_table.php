<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
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

            $table->foreign('tipo_proceso_id')->references('id')->on('tipos_procesos')->onDelete('restrict');
            $table->foreign('estado_proceso_id')->references('id')->on('estados_procesos')->onDelete('restrict');
            $table->foreign('criticidad_proceso_id')->references('id')->on('criticidades_procesos')->onDelete('restrict');
            $table->foreign('unidad_responsable_id')->references('id')->on('unidades_responsables')->onDelete('restrict');
        });
        
        // Add self-referencing FK for proceso_padre_id after table creation
        Schema::table('procesos', function (\Illuminate\Database\Schema\Blueprint $table) {
            $table->foreign('proceso_padre_id')->references('id')->on('procesos')->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('procesos');
    }
};
