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
        Schema::create('consultas', function (Blueprint $table) {
            $table->id('id_consulta');
            $table->foreignId('id_historia')->constrained('historias_medicas', 'id_historia');
            $table->foreignId('id_medico')->constrained('usuarios', 'id_usuario');
            $table->timestamp('fecha_consulta');
            $table->text('motivo_consulta');
            $table->text('signos_vitales')->nullable();
            $table->text('examen_fisico')->nullable();
            $table->text('diagnostico');
            $table->text('plan_tratamiento')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('consultas');
    }
};
