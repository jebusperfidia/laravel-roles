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
        Schema::create('urban_equipment', function (Blueprint $table) {
            $table->id();

            $table->foreignId('valuation_id')
                ->constrained('valuations')
                ->cascadeOnDelete();

            $table->integer('church');
            $table->integer('market');
            $table->integer('super_market');
            $table->integer('commercial_spaces');
            $table->integer('number_commercial_spaces');
            $table->integer('public_square');
            $table->integer('parks');
            $table->integer('gardens');
            $table->integer('sports_courts');
            $table->integer('sports_center');
            $table->integer('primary_school');
            $table->integer('middle_school');
            $table->integer('high_school');
            $table->integer('university');
            $table->integer('other_nearby_schools');
            $table->integer('first_level');
            $table->integer('second_level');
            $table->integer('third_level');
            $table->integer('bank');
            $table->integer('community_center');
            $table->integer('urban_distance');
            $table->integer('urban_frequency');
            $table->integer('suburban_distance');
            $table->integer('suburban_frequency');


            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('urban_equipment');
    }
};
