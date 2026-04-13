<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('unidades_responsables', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('descripcion', 100);
            $table->uuid('unidad_madre_id')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });

        // Add self-referencing FK in a separate statement to avoid DB-specific ordering issues
        Schema::table('unidades_responsables', function (Blueprint $table) {
            $table->foreign('unidad_madre_id')->references('id')->on('unidades_responsables')->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('unidades_responsables');
    }
};
