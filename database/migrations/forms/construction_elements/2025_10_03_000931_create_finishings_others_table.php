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
        Schema::create('finishings_others', function (Blueprint $table) {
            $table->id();

            // 🔑 CLAVE FORÁNEA CORREGIDA: LIGADA A 'construction_elements'
            $table->foreignId('construction_elements_id')
                ->constrained('construction_elements')
                ->cascadeOnDelete();

            // Campos de Acabados Adicionales (Todos Requeridos)
            $table->string('space'); // Asumo string para el nombre del espacio
            $table->integer('amount'); // Asumo tinyInteger para la cantidad de elementos/áreas
            $table->string('floors');
            $table->string('walls');
            $table->string('ceilings');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('finishings_others');
    }
};
