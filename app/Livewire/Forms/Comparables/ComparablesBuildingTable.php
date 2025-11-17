<?php

namespace App\Livewire\Forms\Comparables;

use App\Models\Forms\Comparable\ComparableModel;
use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Builder;
use PowerComponents\LivewirePowerGrid\Button;
use PowerComponents\LivewirePowerGrid\Column;
use PowerComponents\LivewirePowerGrid\Facades\Filter;
use PowerComponents\LivewirePowerGrid\Facades\PowerGrid;
use PowerComponents\LivewirePowerGrid\PowerGridFields;
use PowerComponents\LivewirePowerGrid\PowerGridComponent;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;

final class ComparablesBuildingTable extends PowerGridComponent
{

    public $idValuation;

    public string $tableName = 'comparables-building-table';

    public function setUp(): array
    {
        /* $this->showCheckBox(); */

        $this->idValuation = Session::get('valuation_id');

        return [
            PowerGrid::header()
                ->showSearchInput(),
            PowerGrid::footer()
                ->showPerPage()
                ->showRecordCount(),
        ];
    }
    /*
    public function datasource(): Builder
    {
        return ComparableModel::query();
    }
*/

    public function datasource(): Builder
    {

        $comparableType = 'building';
        $pivotTableName = 'valuation_building_comparables';

        return ComparableModel::query()
            // *** FILTRO AÑADIDO: Solo registros donde comparable_type es 'building' ***
            ->where('comparable_type', $comparableType)
            // Excluye los comparables ya asignados a este avalúo
            ->whereNotIn('id', function ($query) use ($pivotTableName) {
                $query->select('comparable_id')
                    ->from($pivotTableName)
                    ->where('valuation_id', $this->idValuation);
            })
            // *** AÑADIDO: FILTRO DE VIGENCIA DE 6 MESES ***
            ->where('comparables.created_at', '>=', Carbon::now()->subMonths(6));
    }

    public function relationSearch(): array
    {
        return [];
    }

    public function fields(): PowerGridFields
    {
        return PowerGrid::fields()
             ->add('id')
            ->add('valuation_id')
            /* ->add('comparable_type') */
            /* ->add('comparable_key')

            ->add('comparable_discharged_by')
            ->add('comparable_property') */
            /* ->add('comparable_entity') */
            ->add('comparable_folio')
            ->add('comparable_entity_name')
            /* ->add('comparable_locality') */
            ->add('comparable_locality_name')
            // --- INICIO DE LÓGICA DE COLONIA ---
            ->add('comparable_colony') // Campo original (para búsquedas)
            ->add('comparable_other_colony') // Campo de respaldo
            // Campo virtual para mostrar la colonia correcta
            ->add(
                'colony_display',
                fn(ComparableModel $model) =>
                $model->comparable_colony === 'no-listada'
                    ? $model->comparable_other_colony
                    : $model->comparable_colony
            )
            // --- FIN DE LÓGICA DE COLONIA ---
            ->add('comparable_street')
            /* ->add('comparable_between_street')
            ->add('comparable_and_street') */
            ->add('comparable_cp')
            ->add('comparable_abroad_number')
            /* ->add('comparable_name')
            ->add('comparable_last_name')
            ->add('comparable_phone')

            ->add('comparable_land_use')
            ->add('comparable_desc_services_infraestructure')
            ->add('comparable_services_infraestructure')
            ->add('comparable_shape')
            ->add('comparable_density')
            ->add('comparable_front')
            ->add('comparable_front_type')
            ->add('comparable_description_form')
            ->add('comparable_topography')
            ->add('comparable_characteristics')
            ->add('comparable_characteristics_general')
            ->add('comparable_location_block')
            ->add('comparable_street_location')

            ->add('comparable_urban_proximity_reference')
            ->add('comparable_source_inf_images') */
            /* ->add('comparable_photos') */

            /* ->add('comparable_inside_number') */
            /* ->add('comparable_allowed_levels')
            ->add('comparable_number_fronts')
            ->add('comparable_free_area_required')
            ->add('comparable_slope') */

            // --- INICIO DE FORMATO NUMÉRICO ---
            ->add('comparable_offers')
            ->add('price_offers', fn(ComparableModel $model) => '$' . number_format($model->comparable_offers, 2, '.', ','))

            ->add('comparable_land_area')
            ->add('comparable_land_area_formatted', fn(ComparableModel $model) => number_format($model->comparable_land_area, 2, '.', ','))

            ->add('comparable_built_area')
            ->add('comparable_built_area_formatted', fn(ComparableModel $model) => number_format($model->comparable_built_area, 2, '.', ','))

            ->add('comparable_vut')
            ->add('comparable_vut_formatted', fn(ComparableModel $model) => number_format($model->comparable_vut, 0, '.', ',')) // 0 decimales

            ->add('comparable_unit_value')
            ->add('comparable_unit_value_formatted', fn(ComparableModel $model) => '$' . number_format($model->comparable_unit_value, 2, '.', ','))

            ->add('comparable_age')
            ->add('comparable_age_formatted', fn(ComparableModel $model) => number_format($model->comparable_age, 0, '.', ',')) // 0 decimales
            // --- FIN DE FORMATO NUMÉRICO ---


            ->add('created_at_formatted', fn(ComparableModel $model) => Carbon::parse($model->created_at)->format('d/m/Y'))

            ->add('comparable_general_prop_area')
            ->add(
                'comparable_url',
                fn(ComparableModel $model) =>
                '<a target="_blank" class="underline text-blue-600 hover:text-blue-800" href="' . e($model->comparable_url) . '">' . e($model->comparable_url) . '</a>'
            );



        /* ->add('comparable_url')
            ->add('created_at') */

        /* ->add('comparable_bargaining_factor')
            ->add('is_active')
            ->add('created_by')
            ->add('comparable_number_bedrooms')
            ->add('comparable_number_toilets')
            ->add('comparable_number_halfbaths')
            ->add('comparable_number_parkings')
            ->add('comparable_elevator')
            ->add('comparable_store')
            ->add('comparable_roof_garden')
            ->add('comparable_features_amenities')
            ->add('comparable_floor_level')
            ->add('comparable_quality')
            ->add('comparable_conservation')
            ->add('comparable_levels')
            ->add('comparable_seleable_area')
            ->add('comparable_clasification') */
    }

    public function columns(): array
    {
        return [
             Column::make('Id', 'id'),
            /*Column::make('Valuation id', 'valuation_id'), */
            /* Column::make('Comparable type', 'comparable_type')
                ->sortable()
                ->searchable(), */

            /* Column::make('Comparable key', 'comparable_key')
                ->sortable()
                ->searchable(), */

            Column::make('Folio', 'comparable_folio')
                ->sortable()
                ->searchable(),

            /* Column::make('Comparable discharged by', 'comparable_discharged_by')
                ->sortable()
                ->searchable(),

            Column::make('Comparable property', 'comparable_property')
                ->sortable()
                ->searchable(),

            Column::make('Comparable entity', 'comparable_entity')
                ->sortable()
                ->searchable(), */

            Column::make('Estado', 'comparable_entity_name')
                ->sortable()
                ->searchable(),

            /* Column::make('Comparable locality', 'comparable_locality')
                ->sortable()
                ->searchable(),
*/
            Column::make('Ciudad', 'comparable_locality_name')
                ->sortable()
                ->searchable(),

            Column::make('Colonia', 'colony_display', 'comparable_colony')
                ->sortable()
                ->searchable(),

          /*   Column::make('Otra colonia', 'comparable_other_colony')
                ->sortable()
                ->searchable(), */

            Column::make('Calle', 'comparable_street')
                ->sortable()
                ->searchable(),

            Column::make('N° exterior', 'comparable_abroad_number')
                ->sortable()
                ->searchable(),

            /* Column::make('Comparable inside number', 'comparable_inside_number')
                ->sortable()
                ->searchable(), */

            /* Column::make('Comparable between street', 'comparable_between_street')
                ->sortable()
                ->searchable(),

            Column::make('Comparable and street', 'comparable_and_street')
                ->sortable()
                ->searchable(), */

            Column::make('CP', 'comparable_cp')
                ->sortable()
                ->searchable(),

            /* Column::make('Comparable name', 'comparable_name')
                ->sortable()
                ->searchable(),

            Column::make('Comparable last name', 'comparable_last_name')
                ->sortable()
                ->searchable(),

            Column::make('Comparable phone', 'comparable_phone')
                ->sortable()
                ->searchable(),


*/
            /* Column::make('Comparable land use', 'comparable_land_use')
                ->sortable()
                ->searchable(),

            Column::make('Comparable desc services infraestructure', 'comparable_desc_services_infraestructure')
                ->sortable()
                ->searchable(),

            Column::make('Comparable services infraestructure', 'comparable_services_infraestructure')
                ->sortable()
                ->searchable(),

            Column::make('Comparable shape', 'comparable_shape')
                ->sortable()
                ->searchable(),

            Column::make('Comparable density', 'comparable_density')
                ->sortable()
                ->searchable(),

            Column::make('Comparable front', 'comparable_front')
                ->sortable()
                ->searchable(),

            Column::make('Comparable front type', 'comparable_front_type')
                ->sortable()
                ->searchable(),

            Column::make('Comparable description form', 'comparable_description_form')
                ->sortable()
                ->searchable(),

            Column::make('Comparable topography', 'comparable_topography')
                ->sortable()
                ->searchable(),

            Column::make('Comparable characteristics', 'comparable_characteristics')
                ->sortable()
                ->searchable(),

            Column::make('Comparable characteristics general', 'comparable_characteristics_general')
                ->sortable()
                ->searchable(),

            Column::make('Comparable location block', 'comparable_location_block')
                ->sortable()
                ->searchable(),

            Column::make('Comparable street location', 'comparable_street_location')
                ->sortable()
                ->searchable(),



            Column::make('Comparable urban proximity reference', 'comparable_urban_proximity_reference')
                ->sortable()
                ->searchable(),

            Column::make('Comparable source inf images', 'comparable_source_inf_images')
                ->sortable()
                ->searchable(),

            Column::make('Comparable photos', 'comparable_photos')
                ->sortable()
                ->searchable(),



            Column::make('Comparable allowed levels', 'comparable_allowed_levels')
                ->sortable()
                ->searchable(),

            Column::make('Comparable number fronts', 'comparable_number_fronts')
                ->sortable()
                ->searchable(),

            Column::make('Comparable free area required', 'comparable_free_area_required')
                ->sortable()
                ->searchable(),

            Column::make('Comparable slope', 'comparable_slope')
                ->sortable()
                ->searchable(),
*/
            // --- INICIO DE COLUMNAS FORMATEADAS ---
            Column::make('Oferta', 'price_offers', 'comparable_offers')
                ->sortable(),

            Column::make('m2 Terreno', 'comparable_land_area_formatted', 'comparable_land_area')
                ->sortable(),

            Column::make('m2 Vendible', 'comparable_built_area_formatted', 'comparable_built_area')
                ->sortable(),


            Column::make('VUT', 'comparable_vut_formatted', 'comparable_vut')
                ->sortable(),

            Column::make('$ unitario', 'comparable_unit_value_formatted', 'comparable_unit_value')
                ->sortable(),


            Column::make('Edad', 'comparable_age_formatted', 'comparable_age')
                ->sortable(),
            // --- FIN DE COLUMNAS FORMATEADAS ---


            /* Column::make('Comparable bargaining factor', 'comparable_bargaining_factor')
                ->sortable()
                ->searchable(),

            Column::make('Is active', 'is_active')
                ->sortable()
                ->searchable(),

            Column::make('Created by', 'created_by'),
            Column::make('Comparable number bedrooms', 'comparable_number_bedrooms')
                ->sortable()
                ->searchable(),

            Column::make('Comparable number toilets', 'comparable_number_toilets')
                ->sortable()
                ->searchable(),

            Column::make('Comparable number halfbaths', 'comparable_number_halfbaths')
                ->sortable()
                ->searchable(),

            Column::make('Comparable number parkings', 'comparable_number_parkings')
                ->sortable()
                ->searchable(),

            Column::make('Comparable elevator', 'comparable_elevator')
                ->sortable()
                ->searchable(),

            Column::make('Comparable store', 'comparable_store')
                ->sortable()
                ->searchable(),

            Column::make('Comparable roof garden', 'comparable_roof_garden')
                ->sortable()
                ->searchable(),

            Column::make('Comparable features amenities', 'comparable_features_amenities')
                ->sortable()
                ->searchable(),

            Column::make('Comparable floor level', 'comparable_floor_level')
                ->sortable()
                ->searchable(),

            Column::make('Comparable quality', 'comparable_quality')
                ->sortable()
                ->searchable(),

            Column::make('Comparable conservation', 'comparable_conservation')
                ->sortable()
                ->searchable(),

            Column::make('Comparable levels', 'comparable_levels')
                ->sortable()
                ->searchable(),

            Column::make('Comparable seleable area', 'comparable_seleable_area')
                ->sortable()
                ->searchable(),

            Column::make('Comparable clasification', 'comparable_clasification')
                ->sortable()
                ->searchable(), */


            Column::make('Creado', 'created_at_formatted', 'created_at')
                ->sortable(),

            Column::make('Clase', 'comparable_general_prop_area')
                ->sortable()
                ->searchable(),

            Column::make('URL', 'comparable_url')
                ->sortable()
                ->searchable(),



            /* Column::make('Created at', 'created_at')
                ->sortable()
                ->searchable(), */

            Column::action('Action')
        ];
    }

    /* public function filters(): array
    {
        return [
        ];
    }

    #[\Livewire\Attributes\On('edit')]
    public function edit($rowId): void
    {
        $this->js('alert('.$rowId.')');
    } */

    public function actions(ComparableModel $row): array
    {

        // *** INICIO DE LÓGICA CORREGIDA ***
        $currentUserId = Auth::id();

        // Condición: ¿El usuario actual es el creador del comparable?
        //
        // ¡¡AQUÍ ESTÁ EL CAMBIO!!
        // Forzamos ambos lados a (int) para asegurar que comparamos números,
        // ya que el hosting devuelve created_by como string ("1") y Auth::id() es int (1).
        // El triple igual (===) fallaba porque (int)1 no es idéntico a (string)"1".
        //
        $isCreator = ((int)$currentUserId == (int)$row->created_by);

        // Lógica para deshabilitar EDICIÓN y ELIMINACIÓN
        // Solo se puede editar o eliminar si el usuario es el creador.
        $disableActions = !$isCreator;
        // *** FIN DE LÓGICA CORREGIDA ***

        return [
            Button::add()
                ->slot(
                    'Resumen'
                    // Renderizamos el componente Blade manualmente
                    /* Blade::render('<x-icons.document-text class="w-[24px] h-[24px] inline-block" />') */
                )
                ->id()
                ->class('cursor-pointer btn-change')
                ->dispatch('openSummary', ['id' => $row->id]),

            Button::add()
                ->slot('Asignar')
                ->id()
                ->class('cursor-pointer btn-primary')
                ->dispatch('assignedElement', ['idComparable' => $row->id]),

            Button::add('edit')
                ->slot('Editar')
                ->class(
                    'btn-intermediary ' .
                        ($disableActions ? 'opacity-50 cursor-not-allowed pointer-events-none' : 'cursor-pointer')
                )
                ->dispatch('editComparable', ['idComparable' => $row->id]),


            Button::add('delete')
                ->slot('Eliminar')
                ->confirm('¿Estás seguro de eliminar el comparable?')
                ->class(
                    'btn-deleted ' .
                        ($disableActions ? 'opacity-50 cursor-not-allowed pointer-events-none' : 'cursor-pointer')
                )
                ->dispatch('deleteElement', ['idComparable' => $row->id])


        ];

        /* return [
            Button::add('edit')
                ->slot('Edit: '.$row->id)
                ->id()
                ->class('pg-btn-white dark:ring-pg-primary-600 dark:border-pg-primary-600 dark:hover:bg-pg-primary-700 dark:ring-offset-pg-primary-800 dark:text-pg-primary-300 dark:bg-pg-primary-700')
                ->dispatch('edit', ['rowId' => $row->id])
        ]; */
    }

    /*
    public function actionRules($row): array
    {
        return [
            // Hide button edit for ID 1
            Rule::button('edit')
                ->when(fn($row) => $row->id === 1)
                ->hide(),
        ];
    }
    */
}
