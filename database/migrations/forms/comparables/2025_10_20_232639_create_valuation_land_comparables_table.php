<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('valuation_land_comparables', function (Blueprint $table) {
            $table->id();

            //Ligar con la valoración
            $table->foreignId('valuation_id')
            ->constrained('valuations')
            ->cascadeOnDelete();

            //Ligar con el comparable
            $table->foreignId('comparable_id')
            ->constrained('comparables')
            ->cascadeOnDelete();


            $table->unsignedSmallInteger('position')->default(0)->index();
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->boolean('is_active')->default(true);
            $table->unique(['valuation_id', 'comparable_id']);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('valuation_land_comparables');
    }
};
