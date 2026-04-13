<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('persona_rol', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('persona_id');
            $table->uuid('tipo_actor_id');
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('persona_id')->references('id')->on('personas')->onDelete('cascade');
            $table->foreign('tipo_actor_id')->references('id')->on('tipos_actores')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('persona_rol');
    }
};
