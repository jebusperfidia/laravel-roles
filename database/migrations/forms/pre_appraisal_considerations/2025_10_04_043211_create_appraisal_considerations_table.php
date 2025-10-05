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
        Schema::create('appraisal_considerations', function (Blueprint $table) {
            $table->id();

            $table->foreignId('valuation_id')
                ->constrained('valuations')
                ->cascadeOnDelete();

            $table->text('additional_considerations')->nullable();
            $table->text('technical_memory')->nullable();
            $table->text('technical_report_breakdown_information')->nullable();
            $table->text('technical_report_other_support')->nullable();
            $table->text('technical_report_description_calculations')->nullable();
            $table->text('land_calculation')->nullable();
            $table->text('cost_approach')->nullable();
            $table->text('income_approach')->nullable();
            $table->text('due_to_1')->nullable();
            $table->text('due_to_2')->nullable();
            $table->text('comparative_approach_land')->nullable();
            $table->text('comparative_sales_approach')->nullable();
            $table->text('apply_fic')->nullable();



            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('appraisal_considerations');
    }
};
