<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('proceso_flujo_rol', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('proceso_flujo_id');
            $table->uuid('rol_id');
            $table->text('observaciones')->nullable();
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('proceso_flujo_id')->references('id')->on('proceso_flujos')->cascadeOnDelete();
            $table->foreign('rol_id')->references('id')->on('roles')->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('proceso_flujo_rol');
    }
};
