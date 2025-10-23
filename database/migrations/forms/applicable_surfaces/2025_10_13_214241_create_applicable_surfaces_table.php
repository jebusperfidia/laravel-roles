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


            $table->boolean('calculation_built_area')->default(false); // Cálculo de superficie construida (booleano)
            $table->decimal('built_area', 15, 10)->nullable(); // Superficie construida (float)


            $table->decimal('surface_area', 15, 10); // Total del terreno (float)
            $table->decimal('private_lot', 15, 10)->nullable(); // Lote privativo (float)
            $table->decimal('private_lot_type', 15, 10)->nullable(); // Lote privativo tipo (float)

            // Campos de Indiviso y Terreno Proporcional
            $table->decimal('applicable_undivided', 20, 10); // Indiviso aplicable (float, es un porcentaje, 5 dígitos en total, 2 decimales)
            $table->decimal('proporcional_land', 20, 10); // Terreno proporcional (float)
            $table->decimal('surplus_land_area', 15, 10)->nullable(); // Sup. terreno excedente (float)


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
