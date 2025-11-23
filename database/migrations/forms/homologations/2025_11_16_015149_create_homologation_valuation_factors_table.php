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
        // Esta es la TABLA 1 de nuestro Plan v5.0
        // Almacena los factores del "Avalúo Sujeto"
        Schema::create('homologation_valuation_factors', function (Blueprint $table) {
            $table->id();

            // Gancho al avalúo
            $table->foreignId('valuation_id')
                ->constrained('valuations')
                ->onDelete('cascade');

            // --- Columnas de Factores (Estructura Vertical) ---
            $table->string('factor_name', 100);
            $table->string('acronym', 10);
            $table->boolean('is_editable')->default(false);
            // --- Esta columna nos ayudará a identificar los factores personalizados de building ---
            $table->boolean('is_custom')->default(false);

            // --- Columna de Valor (Tu nombre) ---
            $table->decimal('rating', 10, 4)->default(1.0000);

            // --- Columna de Tipo (Tu idea) ---
            $table->string('homologation_type', 10); // 'land' or 'building'

            $table->timestamps();

            // CLAVE ÚNICA CORREGIDA: Ahora incluye 'homologation_type' para permitir FSU tanto en land como en building.
            $table->unique(['valuation_id', 'acronym', 'homologation_type'], 'valuation_factor_unique');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('homologation_valuation_factors');
    }
};
