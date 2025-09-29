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
        Schema::create('property_description', function (Blueprint $table) {
            $table->id();

            $table->foreignId('valuation_id')
                ->constrained('valuations')
                ->cascadeOnDelete();

            $table->tinyInteger('urban_proximity');
            $table->text('actual_use');
            $table->string('multiple_use_space', 15)->nullable();
            $table->integer('level_building')->nullable();
            $table->string('project_quality', 30)->nullable();


            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('property_description');
    }
};
