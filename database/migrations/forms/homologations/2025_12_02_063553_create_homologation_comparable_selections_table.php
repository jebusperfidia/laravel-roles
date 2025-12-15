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
        Schema::create('homologation_comparable_selections', function (Blueprint $table) {
            $table->id();

            // Relación obligatoria con el pivote de Building (ACORTADA)
            $table->unsignedBigInteger('valuation_building_comparable_id');

            $table->string('variable', 50); // 'clase', 'conservacion', 'localizacion'
            $table->string('value')->nullable(); // 'Media', 'Buena', 'Esquina'
            $table->decimal('factor', 10, 4)->nullable(); // 1.0000

            $table->string('homologation_type')->default('building');
            $table->timestamps();

            // Definición de la clave foránea con un nombre corto
            $table->foreign('valuation_building_comparable_id', 'hcs_vbc_id_fk')
                ->references('id')
                ->on('valuation_building_comparables')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('homologation_comparable_selections');
    }
};
