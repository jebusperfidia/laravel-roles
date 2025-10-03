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
        Schema::create('other_elements', function (Blueprint $table) {
            $table->id();

            $table->foreignId('construction_elements_id')
                ->constrained('construction_elements')
                ->cascadeOnDelete();

            // Campos de Otros Elementos (Todos Requeridos, tipo TEXT)
            $table->text('structure');
            $table->text('locksmith');
            $table->text('facades');
            $table->text('elevator');


            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('other_elements');
    }
};
