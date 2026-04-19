<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        // Recrear la tabla sin la columna id propia
        Schema::dropIfExists('proceso_unidad_responsable');
        
        Schema::create('proceso_unidad_responsable', function (Blueprint $table) {
            $table->uuid('proceso_id');
            $table->uuid('unidad_responsable_id');
            $table->timestamps();

            // Composite primary key
            $table->primary(['proceso_id', 'unidad_responsable_id']);

            $table->foreign('proceso_id')->references('id')->on('procesos')->onDelete('cascade');
            $table->foreign('unidad_responsable_id')->references('id')->on('unidades_responsables')->onDelete('cascade');
            
            // Índice para búsquedas frecuentes
            $table->index('proceso_id');
            $table->index('unidad_responsable_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('proceso_unidad_responsable');
        
        // Restaurar la versión anterior
        Schema::create('proceso_unidad_responsable', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('proceso_id');
            $table->uuid('unidad_responsable_id');
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('proceso_id')->references('id')->on('procesos')->onDelete('cascade');
            $table->foreign('unidad_responsable_id')->references('id')->on('unidades_responsables')->onDelete('cascade');
        });
    }
};
