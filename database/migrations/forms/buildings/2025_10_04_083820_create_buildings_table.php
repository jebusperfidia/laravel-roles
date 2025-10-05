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
        Schema::create('buildings', function (Blueprint $table) {
            $table->id();

            $table->foreignId('valuation_id')
                ->constrained('valuations')
                ->cascadeOnDelete();


            $table->string('source_replacement_obtained', 150)->nullable();
            $table->string('conservation_status', 35)->nullable();
            $table->text('observations_state_conservation')->nullable();
            $table->string('general_type_properties_zone', 20)->nullable();
            $table->string('general_class_property', 20)->nullable();
            $table->string('year_completed_work', 5)->nullable();

            $table->integer('profitable_units_subject')->nullable();
            $table->integer('profitable_units_general')->nullable();
            $table->integer('profitable_units_condominiums')->nullable();
            $table->integer('number_subject_levels')->nullable();

            $table->float('progress_general_works',4,3)->nullable();
            $table->float('degree_progress_common_areas', 4,3)->nullable();


            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('buildings');
    }
};
