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
        Schema::create('applicable_surfaces', function (Blueprint $table) {
            $table->id();

            $table->foreignId('valuation_id')
                ->constrained('valuations')
                ->cascadeOnDelete();

            // Campos para Superficies y Booleano (Tipos Float/Decimal)
            // Usamos 'decimal' para mayor precisión en cálculos monetarios/superficies
            //$table->decimal('saleable_area', 10, 2); // Superficie vendible (float)
            $table->boolean('calculation_built_area')->default(false); // Cálculo de superficie construida (booleano)
            $table->decimal('built_area', 10, 2)->nullable(); // Superficie construida (float)
            $table->decimal('surface_area', 10, 2); // Total del terreno (float)

            // Campos Condicionales (Asumo que son opcionales y solo se usan si 'useExcessCalculation' es true)
            $table->decimal('private_lot', 10, 2)->nullable(); // Lote privativo (float)
            $table->decimal('private_lot_type', 10, 2)->nullable(); // Lote privativo tipo (float)
            $table->decimal('surplus_land_area', 10, 2)->nullable(); // Sup. terreno excedente (float)

            // Campos de Indiviso y Terreno Proporcional
            $table->decimal('applicable_undivided', 5, 2); // Indiviso aplicable (float, es un porcentaje, 5 dígitos en total, 2 decimales)
            $table->decimal('proporcional_land', 10, 2); // Terreno proporcional (float)


            // Campos para las Fuentes de Información (Tipo String)
            $table->string('source_surface_area', 100);
            $table->string('source_private_lot', 100)->nullable();
            $table->string('source_private_lot_type', 100)->nullable();
            $table->string('source_applicable_undivided', 100)->nullable();
            $table->string('source_proporcional_land', 100)->nullable();


            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('applicable_surfaces');
    }
};
