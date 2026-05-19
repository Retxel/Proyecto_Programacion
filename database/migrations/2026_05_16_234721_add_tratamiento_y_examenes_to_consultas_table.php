<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('consultas', function (Blueprint $table) {
            $table->text('tratamiento_recetado')->nullable()->after('diagnostico');
            $table->text('examenes_solicitados')->nullable()->after('tratamiento_recetado');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('consultas', function (Blueprint $table) {
            $table->dropColumn(['tratamiento_recetado', 'examenes_solicitados']);
        });
    }
};
