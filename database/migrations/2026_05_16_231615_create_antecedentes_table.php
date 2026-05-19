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
        Schema::create('antecedentes', function (Blueprint $table) {
            $table->id('id_antecedente');
            $table->foreignId('id_historia')->constrained('historias_medicas', 'id_historia');
            $table->string('tipo_antecedente', 50);
            $table->text('descripcion');
            $table->date('fecha_diagnostico')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('antecedentes');
    }
};
