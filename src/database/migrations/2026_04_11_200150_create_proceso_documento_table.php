<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('proceso_documento', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('proceso_id');
            $table->uuid('tipo_proceso_documento_id');
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

            $table->foreign('proceso_id')->references('id')->on('procesos')->cascadeOnDelete();
            $table->foreign('tipo_proceso_documento_id')->references('id')->on('tipos_procesos_documentos')->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('proceso_documento');
    }
};
