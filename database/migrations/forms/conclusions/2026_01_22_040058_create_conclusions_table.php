<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('conclusions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('valuation_id')->constrained()->onDelete('cascade');

            // VALORES CALCULADOS (SNAPSHOT)
            // Es buena práctica guardarlos por si cambian los cálculos originales en el futuro
            $table->decimal('land_value', 16, 2)->default(0);
            $table->decimal('market_value', 16, 2)->default(0);
            $table->decimal('hypothetical_value', 16, 2)->default(0);
            $table->decimal('physical_value', 16, 2)->default(0);

            // INPUTS DEL USUARIO
            $table->decimal('other_value', 16, 2)->nullable(); // El valor manual
            $table->string('selected_value_type')->default('physical'); // 'land', 'market', etc.

            // MÉTRICAS Y RESULTADO
            $table->decimal('difference', 10, 4)->nullable();
            $table->string('range')->nullable(); // String porque traes '%'
            $table->string('rounding')->default('Sin redondeo');
            $table->decimal('concluded_value', 16, 2)->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('conclusions');
    }
};
