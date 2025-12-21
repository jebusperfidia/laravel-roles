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
        Schema::create('pre_conclusion_considerations', function (Blueprint $table) {
            $table->id();
            // Relación con tu tabla principal
            $table->foreignId('valuation_id')->constrained()->cascadeOnDelete();
            // Aquí guardamos el texto largo, nullable porque puede ir vacío
            $table->text('additional_considerations')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pre_conclusion_considerations');
    }
};
