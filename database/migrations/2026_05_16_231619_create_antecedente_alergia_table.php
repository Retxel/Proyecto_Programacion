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
        Schema::create('antecedente_alergia', function (Blueprint $table) {
            $table->foreignId('id_antecedente')->constrained('antecedentes', 'id_antecedente');
            $table->foreignId('id_alergia')->constrained('alergias', 'id_alergia');
            $table->string('severidad', 20)->nullable();
            $table->primary(['id_antecedente', 'id_alergia']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('antecedente_alergia');
    }
};
