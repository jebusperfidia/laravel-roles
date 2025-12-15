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

            // --- CORRECCIÓN AQUÍ ---
            // 1. Usar STRING (no BigInteger) porque las llaves son 'surface_area', 'private_lot'
            // 2. Usar los nombres exactos que tienes en el Controller
            $table->string('subject_surface_option_id', 50)->nullable();
            $table->decimal('subject_surface_value', 16, 10)->default(0);
            // -----------------------

            $table->decimal('cus', 16, 10)->nullable();
            $table->decimal('cos', 16, 10)->nullable();
            $table->decimal('mode_lot', 16, 10)->nullable();
            $table->decimal('unit_value_mode_lot', 16, 10)->default(0);
            $table->string('conclusion_type_rounding', 50)->nullable()->default('Unidades');

            // Los promedios que agregamos hace rato
            $table->decimal('average_arithmetic', 16, 10)->nullable()->default(0);
            $table->decimal('average_homologated', 16, 10)->nullable()->default(0);

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
