<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('tipos_procesos', function (Blueprint $table) {
            $table->string('color', 7)->default('#0c5aa0')->after('descripcion');
            $table->string('icono', 50)->default('fa-folder')->after('color');
        });
    }

    public function down(): void
    {
        Schema::table('tipos_procesos', function (Blueprint $table) {
            $table->dropColumn('color');
            $table->dropColumn('icono');
        });
    }
};
