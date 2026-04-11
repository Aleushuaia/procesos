<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('proceso_flujos', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('proceso_id');
            $table->string('descripcion', 100);
            $table->text('observaciones')->nullable();
            $table->uuid('tipo_flujo_proceso_id');
            $table->timestamp('fecha_inicio_analisis')->nullable();
            $table->timestamp('fecha_firma_version')->nullable();
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('proceso_id')->references('id')->on('procesos')->cascadeOnDelete();
            $table->foreign('tipo_flujo_proceso_id')->references('id')->on('tipos_flujos_procesos')->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('proceso_flujos');
    }
};
