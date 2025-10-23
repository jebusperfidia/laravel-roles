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
        Schema::create('special_installations', function (Blueprint $table) {
            $table->id();


            $table->foreignId('valuation_id')
                ->constrained('valuations')
                ->cascadeOnDelete();

            // Discriminadores de Tipo (Necesarios para las 6 tablas/pestañas)
            $table->string('classification_type', 20); // 'privativa' o 'comun'
            $table->string('element_type', 50);        // 'instalaciones', 'accesorios', 'obras'

            // Campos basados en tus variables públicas
            $table->string('key')->nullable(); // Campo $key

            // Campo de descripción unificado (en lugar de descriptionSI, descriptionAE, descriptionCW)
            $table->string('description')->nullable();

            $table->string('description_other')->nullable(); // Campo adicional para asignar una descricción personalizada

            $table->string('unit', 50)->nullable();
            $table->unsignedInteger('quantity')->nullable();
            $table->unsignedSmallInteger('age')->nullable();
            $table->unsignedSmallInteger('useful_life')->nullable();

            // Costos y Factores (Decimales)
            $table->decimal('new_rep_unit_cost', 15, 4)->nullable();
            $table->decimal('age_factor', 5, 4)->nullable();
            $table->decimal('conservation_factor', 5, 4)->nullable();
            $table->decimal('net_rep_unit_cost', 15, 4)->nullable();

            // Valores finales
            $table->decimal('undivided', 10, 6)->nullable();
            $table->decimal('amount', 15, 6)->nullable();


            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('special_installations');
    }
};
