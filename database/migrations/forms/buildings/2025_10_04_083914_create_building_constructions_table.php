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
        Schema::create('building_constructions', function (Blueprint $table) {
            $table->id();

            $table->foreignId('building_id')
                ->constrained('buildings')
                ->cascadeOnDelete();

            $table->string('description', 100)->nullable();
            $table->string('clasification',20)->nullable();
            $table->string('use', 2)->nullable();
            $table->integer('building_levels')->nullable();
            $table->integer('levels_construction_type')->nullable();
            $table->integer('age')->nullable();
            $table->float('surface', 10,2)->nullable();
            $table->string('source_information', 30)->nullable();
            $table->float('unit_cost_replacement', 10, 2)->nullable();
            $table->float('progress_work', 10, 2)->nullable();
            $table->string('conservation_state')->nullable();
            /* $table->boolean('range_based_height')->nullable(); */
            $table->string('surface_vad')->nullable();


            $table->string('type', 12)->nullable();

            $table->boolean('surface_apply')->default(false);




            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('building_constructions');
    }
};
