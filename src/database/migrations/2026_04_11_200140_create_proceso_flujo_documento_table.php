<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('proceso_flujo_documento', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('proceso_flujo_id');
            $table->string('descripcion', 100);
            $table->string('nombre_archivo', 255);
            $table->string('ruta_almacenamiento', 255);
            $table->string('tipo_mime', 100);
            $table->string('extension', 10);
            $table->bigInteger('tamanio_bytes');
            $table->string('hash_archivo', 255);
            $table->string('storage_disk', 50);
            $table->string('bucket', 100);
            $table->json('metadata')->nullable();
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('proceso_flujo_id')->references('id')->on('proceso_flujos')->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('proceso_flujo_documento');
    }
};
