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
        Schema::create('property_locations', function (Blueprint $table) {
            $table->id();
            // clave primaria auto-incremental

            $table->foreignId('valuation_id')
                ->constrained('valuations')
                ->cascadeOnDelete();
            // valuation_id: columna UNSIGNED BIGINT
            // ->constrained('valuations'): genera FOREIGN KEY a valuations.id
            // ->cascadeOnDelete(): si borras la valuación, borra automáticamente la ubicación

            $table->decimal('latitude', 10, 7)->nullable();
            // latitud con precisión de hasta 7 decimales (grado)

            $table->decimal('longitude', 10, 7)->nullable();
            // longitud con precisión de hasta 7 decimales (grado)

            $table->decimal('altitude', 10, 2)->nullable();
            // altitud con 2 decimales (metros)

            $table->timestamps();
            // created_at y updated_at automáticos
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('property_locations');
    }
};
