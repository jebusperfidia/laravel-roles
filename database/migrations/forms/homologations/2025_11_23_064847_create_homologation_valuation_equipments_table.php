<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('homologation_valuation_equipments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('valuation_id')->constrained('valuations')->onDelete('cascade');

            $table->string('description', 255);
            // Sin campo unit (según tu indicación anterior)

            // Eliminamos default(0), ahora son OBLIGATORIOS
            $table->decimal('quantity', 10, 4);
            $table->decimal('total_value', 15, 2);

            $table->timestamps();

            $table->unique(['valuation_id', 'description'], 'valuation_equip_unique');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('homologation_valuation_equipments');
    }
};
