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
        Schema::create('homologation_land_attributes', function (Blueprint $table) {
            $table->id();

            $table->foreignId('valuation_id')->constrained()->cascadeOnDelete();

            // Superficie
            $table->unsignedBigInteger('surface_applicable_id')->nullable();
            $table->decimal('surface_applicable_area', 16, 10)->default(0);

            // Inputs del Sujeto
            $table->decimal('cus', 16, 10)->nullable();
            $table->decimal('cos', 16, 10)->nullable();
            $table->decimal('mode_lot', 16, 10)->nullable();

            // Campo solicitado (Valor Unitario Lote Tipo)
            $table->decimal('unit_value_mode_lot', 16, 10)->default(0);

            $table->string('conclusion_type_rounding', 50)->nullable()->default('Unidades');

            $table->timestamps();
        });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
