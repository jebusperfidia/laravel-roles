<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('homologation_comparable_equipments', function (Blueprint $table) {
            $table->id();

            // 1. CREAMOS LAS COLUMNAS PRIMERO (Sin constraints automáticos)
            $table->unsignedBigInteger('valuation_equipment_id');
            $table->unsignedBigInteger('valuation_building_comparable_id');

            // Campos de datos
            $table->string('description', 255);
            $table->string('unit', 10);

            $table->decimal('quantity', 10, 4);
            $table->decimal('difference', 20, 6);
            $table->decimal('percentage', 12, 6);

            $table->timestamps();

            // 2. CREAMOS LOS CONSTRAINTS MANUALMENTE (Con nombres cortos explícitos)

            // FK 1: Nombre corto 'hce_ve_fk'
            $table->foreign('valuation_equipment_id', 'hce_ve_fk')
                ->references('id')
                ->on('homologation_valuation_equipments')
                ->onDelete('cascade');

            // FK 2: Nombre corto 'hce_vbc_fk'
            $table->foreign('valuation_building_comparable_id', 'hce_vbc_fk')
                ->references('id')
                ->on('valuation_building_comparables')
                ->onDelete('cascade');

            // UNIQUE: Nombre corto 'hce_unique'
            $table->unique(['valuation_equipment_id', 'valuation_building_comparable_id'], 'hce_unique');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('homologation_comparable_equipments');
    }
};
