<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('proceso_unidad_responsable', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('proceso_id');
            $table->uuid('unidad_responsable_id');
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('proceso_id')->references('id')->on('procesos')->cascadeOnDelete();
            $table->foreign('unidad_responsable_id')->references('id')->on('unidades_responsables')->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('proceso_unidad_responsable');
    }
};
