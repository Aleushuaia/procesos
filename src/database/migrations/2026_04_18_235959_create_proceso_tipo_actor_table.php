<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('proceso_tipo_actor', function (Blueprint $table) {
            $table->uuid('proceso_id');
            $table->uuid('tipo_actor_id');
            $table->timestamps();

            $table->primary(['proceso_id', 'tipo_actor_id']);

            $table->foreign('proceso_id')->references('id')->on('procesos')->onDelete('cascade');
            $table->foreign('tipo_actor_id')->references('id')->on('tipos_actores')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('proceso_tipo_actor');
    }
};
