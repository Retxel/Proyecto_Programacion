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
        Schema::create('historias_medicas', function (Blueprint $table) {
            $table->id('id_historia');
            $table->foreignId('id_paciente')->unique()->constrained('pacientes', 'id_paciente');
            $table->string('numero_expediente', 50)->unique();
            $table->string('tipo_sangre', 5)->nullable();
            $table->string('factor_rh', 10)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('historias_medicas');
    }
};
