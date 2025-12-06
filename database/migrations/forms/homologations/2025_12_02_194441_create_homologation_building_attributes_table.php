<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('homologation_building_attributes', function (Blueprint $table) {
            $table->id();

            // Relación obligatoria al Avalúo
            $table->foreignId('valuation_id')->constrained()->cascadeOnDelete();

            // Campo solicitado (Valor Unitario Concluido / Lote Tipo)
            $table->decimal('unit_value_mode_lot', 16, 10)->default(0);

            // Campo solicitado (Tipo de redondeo)
            $table->string('conclusion_type_rounding', 50)->nullable()->default('Unidades');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('homologation_building_attributes');
    }
};
