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
        Schema::create('valuations', function (Blueprint $table) {
            $table->id();
            $table->date('date');
            $table->string('type', 20);
            $table->string('folio', 100)->unique();
            $table->string('property_type', 100);
            //Tendremos 4 diferentes estados
            //0 unassigned
            //1 capturing
            //2 reviewing
            //3 completed
            $table->unsignedTinyInteger('status')->default(0);

            //Valores para datos del propietario
            $table->string('calculation_type', 20)->nullable();
            $table->boolean('pre_valuation')->default(false);
            $table->string('owner_type_person', 15)->nullable();
            $table->string('owner_rfc', 13)->nullable();
            $table->string('owner_curp', 18)->nullable();
            $table->string('owner_name', 100)->nullable();
            $table->string('owner_first_name', 100)->nullable();
            $table->string('owner_second_name', 100)->nullable();
            $table->string('owner_company_name', 100)->nullable();
            $table->string('owner_cp', 5)->nullable();
            $table->string('owner_entity', 100)->nullable();
            $table->string('owner_locality', 100)->nullable();
            $table->string('owner_colony', 100)->nullable();
            $table->string('owner_other_colony', 100)->nullable();
            $table->string('owner_street', 50)->nullable();
            $table->string('owner_abroad_number', 50)->nullable();
            $table->string('owner_inside_number', 50)->nullable();
            //$table->boolean('owner_copy_from_property')->default(false);


            //Valores para datos del solicitante
            $table->string('applic_type_person')->nullable();
            $table->string('applic_rfc', 13)->nullable();
            $table->string('applic_curp', 18)->nullable();
            $table->string('applic_name', 100)->nullable();
            $table->string('applic_first_name', 100)->nullable();
            $table->string('applic_second_name', 100)->nullable();
            $table->string('applic_cp', 5)->nullable();
            $table->string('applic_entity', 100)->nullable();
            $table->string('applic_locality', 100)->nullable();
            $table->string('applic_colony', 100)->nullable();
            $table->string('applic_other_colony', 100)->nullable();
            $table->string('applic_street', 100)->nullable();
            $table->string('applic_abroad_number', 20)->nullable();
            $table->string('applic_inside_number', 20)->nullable();
            $table->string('applic_phone', 15)->nullable();
            //$table->boolean('applic_copy_from_owner')->default(false);


            //Valores para datos del inmueble
            $table->string('property_cp', 5)->nullable();
            $table->string('property_entity', 100)->nullable();
            $table->string('property_locality', 100)->nullable();
            $table->string('property_city', 100)->nullable();
            $table->string('property_colony', 100)->nullable();
            $table->string('property_other_colony', 100)->nullable();
            $table->string('property_street', 100)->nullable();
            $table->string('property_abroad_number', 20)->nullable();
            $table->string('property_inside_number', 20)->nullable();
            $table->string('property_block', 100)->nullable();
            $table->string('property_super_block', 100)->nullable();
            $table->string('property_lot', 100)->nullable();
            $table->string('property_building', 100)->nullable();
            $table->string('property_departament', 100)->nullable();
            $table->string('property_access', 100)->nullable();
            $table->string('property_level', 20)->nullable();
            $table->string('property_condominium', 100)->nullable();
            $table->string('property_street_between', 100)->nullable();
            $table->string('property_and_street', 100)->nullable();
            $table->string('property_housing_complex', 100)->nullable();
            $table->string('property_tax', 100)->nullable();
            $table->string('property_water_account', 100)->nullable();
            /* $table->string('property_type')->nullable(); */
            $table->string('property_land_use', 100)->nullable();
            $table->string('property_type_housing', 100)->nullable();
            $table->string('property_constructor', 100)->nullable();
            $table->string('property_rfc_constructor', 100)->nullable();
            $table->string('property_additional_data', 100)->nullable();

            //Valores para datos importantes
            $table->string('purpose_other', 100)->nullable();
            $table->string('purpose', 100)->nullable();
            /* $table->string('purpose_sigapred', 100)->nullable(); */
            $table->string('objective', 100)->nullable();
            $table->string('owner_ship_regime', 20)->nullable();


            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('valuations');
    }
};
