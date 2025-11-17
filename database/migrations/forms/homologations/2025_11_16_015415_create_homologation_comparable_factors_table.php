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
        // Esta es la TABLA 2 de nuestro Plan v5.0
        // Almacena los factores de TODOS los comparables (Land y Building)
        Schema::create('homologation_comparable_factors', function (Blueprint $table) {
            $table->id();

            // --- Ganchos a las "HojasDeConexion" (Tablas Pivote) ---
            // Se usa si homologation_type = 'land'
            $table->unsignedBigInteger('valuation_land_comparable_id')->nullable();

            // Se usa si homologation_type = 'building'
            $table->unsignedBigInteger('valuation_building_comparable_id')->nullable();

            // --- Columnas de Factores (Estructura Vertical) ---
            $table->string('factor_name', 100);
            $table->string('acronym', 10);
            $table->boolean('is_editable')->default(false);

            // --- Columnas de Valor (Tus nombres) ---
            $table->decimal('rating', 10, 4)->default(1.0000);
            $table->decimal('applicable', 10, 4)->default(1.0000);

            // --- Columna de Tipo (Tu idea) ---
            $table->string('homologation_type', 10); // 'land' or 'building'

            $table->timestamps();

            // --- CONSTRAINTS CON NOMBRES CORTOS ---

            // Constraint para Land (Nombre corto: hcf_land_fk)
            $table->foreign('valuation_land_comparable_id', 'hcf_land_fk')
                ->references('id')
                ->on('valuation_land_comparables')
                ->onDelete('cascade');

            // Constraint para Building (Nombre corto: hcf_building_fk)
            $table->foreign('valuation_building_comparable_id', 'hcf_building_fk')
                ->references('id')
                ->on('valuation_building_comparables')
                ->onDelete('cascade');

            // Unique constraints para cada tipo
            $table->unique(['valuation_land_comparable_id', 'acronym'], 'land_comparable_factor_unique');
            $table->unique(['valuation_building_comparable_id', 'acronym'], 'building_comparable_factor_unique');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('homologation_comparable_factors');
    }
};
