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
use Illuminate\Support\Facades\Blade;


final class ComparablesLandTable extends PowerGridComponent
{

    public $idValuation;

    public string $tableName = 'comparables-land-table';

    //public bool $loadingIndicator = true;

    public function setUp(): array
    {
        /* $this->showCheckBox(); */
    $this->idValuation = Session::get('valuation_id');


        return [
            //'loadingIndicator' => true,
            PowerGrid::header()
                ->showSearchInput(),
            PowerGrid::footer()
                ->showPerPage()
                ->showRecordCount()
        ];
    }

    /*  public function datasource(): Builder
    {
        return ComparableModel::query();
    }
 */

    public function datasource(): Builder
    {

        $comparableType = 'land';
        $pivotTableName = 'valuation_land_comparables';

        return ComparableModel::query()
            // *** FILTRO AÑADIDO: Solo registros donde comparable_type es 'building' ***
            ->where('comparable_type', $comparableType)
            // Excluye los comparables ya asignados a este avalúo
            ->whereNotIn('id', function ($query) use ($pivotTableName) {
                $query->select('comparable_id')
                    ->from($pivotTableName)
                    ->where('valuation_id', $this->idValuation);
            });
    }

    public function relationSearch(): array
    {
        return [];
    }

    public function fields(): PowerGridFields
    {
        return PowerGrid::fields()
            ->add('id')
            //->add('valuation_id')
            /* ->add('comparable_key') */
            ->add('comparable_folio')
          /*   ->add('comparable_discharged_by') */
            ->add('comparable_property')
            /* ->add('comparable_entity') */
            ->add('comparable_entity_name')
            /* ->add('comparable_locality') */
            ->add('comparable_locality_name')
            ->add('comparable_colony')
            ->add('comparable_other_colony')
            ->add('comparable_street')
           /*  ->add('comparable_between_street') */
           /*  ->add('comparable_and_street') */
           ->add('comparable_abroad_number')
           ->add('comparable_cp')
            ->add('comparable_offers')
            /* ->add('price_offers', fn (ComparableModel $model) => Number::currency($model->comparable_offers, in: 'EUR', locale: 'pt_PT')) */
            ->add('price_offers', fn (ComparableModel $model) =>  '$' . rtrim(rtrim(number_format($model->comparable_offers, 6, '.', ','), '0'), '.'))
            ->add('comparable_land_area')
            ->add('comparable_unit_value')
            ->add('comparable_land_use')
            ->add('comparable_built_area')
            ->add('created_at_formatted', fn (ComparableModel $model) => Carbon::parse($model->created_at)->format('d/m/Y'))
            ->add(
                'comparable_url',
                fn(ComparableModel $model) =>
                '<a target="_blank" class="underline text-blue-600 hover:text-blue-800" href="' . e($model->comparable_url) . '">' . e($model->comparable_url) . '</a>'
            )

            /*   ->add('comparable_name')
            ->add('comparable_last_name')
            ->add('comparable_phone') */
            /*        ->add('comparable_desc_services_infraestructure')
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
            ->add('comparable_general_prop_area')
            ->add('comparable_urban_proximity_reference')
            ->add('comparable_source_inf_images')
            ->add('comparable_photos')

            ->add('comparable_inside_number')
            ->add('comparable_allowed_levels')
            ->add('comparable_number_fronts')
            ->add('comparable_free_area_required')
            ->add('comparable_slope') */




            ->add('comparable_bargaining_factor')
           /*  ->add('comparable_latitude')
            ->add('comparable_longitude') */
            ->add('is_active');

    }

    public function columns(): array
    {
        return [
            Column::make('Id', 'id'),
            /* Column::make('Valuation id', 'valuation_id'), */
           /*  Column::make('Comparable key', 'comparable_key')
                ->sortable()
                ->searchable(),
 */
            Column::make('Folio', 'comparable_folio')
                ->sortable()
                ->searchable()
                ->bodyAttribute('text-md'),

     /*        Column::make('Comparable discharged by', 'comparable_discharged_by')
                ->sortable()
                ->searchable(), */

            Column::make('Propiedad', 'comparable_property')
                ->sortable()
                ->searchable(),
/*
            Column::make('Comparable entity', 'comparable_entity')
                ->sortable()
                ->searchable(),
 */
            Column::make('Estado', 'comparable_entity_name')
                ->sortable()
                ->searchable(),

           /*  Column::make('Comparable locality', 'comparable_locality')
                ->sortable()
                ->searchable(), */

            Column::make('Ciudad', 'comparable_locality_name')
                ->sortable()
                ->searchable(),

            Column::make('Colonia', 'comparable_colony')
                ->sortable()
                ->searchable(),

            /* Column::make('Otra colonia', 'comparable_other_colony')
                ->sortable()
                ->searchable(), */

            Column::make('Calle', 'comparable_street')
                ->sortable()
                ->searchable(),

            /*   Column::make('Comparable between street', 'comparable_between_street')
                ->sortable()
                ->searchable(),

            Column::make('Comparable and street', 'comparable_and_street')
                ->sortable()
                ->searchable(), */

            Column::make('N°', 'comparable_abroad_number')
                ->sortable()
                ->searchable(),


            Column::make('CP', 'comparable_cp')
                ->sortable()
                ->searchable(),


            Column::make('Oferta', 'price_offers' ,'comparable_offers')
                ->sortable()
                ->searchable(),


            Column::make('Terreno', 'comparable_land_area')
                ->sortable()
                ->searchable(),

            Column::make('Unitario', 'comparable_unit_value')
                ->sortable()
                ->searchable(),

            Column::make('Uso', 'comparable_land_use')
                ->sortable()
                ->searchable(),


            Column::make('Construida', 'comparable_built_area')
                ->sortable()
                ->searchable(),

            Column::make('Creado', 'created_at_formatted','created_at')
                ->sortable()
                ->searchable(),


            /*
            Column::make('Comparable name', 'comparable_name')
                ->sortable()
                ->searchable(),

            Column::make('Comparable last name', 'comparable_last_name')
                ->sortable()
                ->searchable(),

            Column::make('Comparable phone', 'comparable_phone')
                ->sortable()
                ->searchable(), */

            Column::make('URL', 'comparable_url')
                ->sortable()
                ->searchable(),

/*

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

            Column::make('Comparable general prop area', 'comparable_general_prop_area')
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


            Column::make('Comparable inside number', 'comparable_inside_number')
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

            Column::make('Comparable bargaining factor', 'comparable_bargaining_factor')
                ->sortable()
                ->searchable(),
 */
           /*  Column::make('Comparable latitude', 'comparable_latitude')
                ->sortable()
                ->searchable(),

            Column::make('Comparable longitude', 'comparable_longitude')
                ->sortable()
                ->searchable(), */

      /*       Column::make('Is active', 'is_active')
                ->sortable()
                ->searchable(), */

          /*   Column::make('Created at', 'created_at_formatted', 'created_at')
                ->sortable(),

             */

            Column::action('Acciones')
        ];
    }

    public function filters(): array
    {
        return [
        ];
    }
/*
    #[\Livewire\Attributes\On('edit')]
    public function edit($rowId): void
    {
        $this->js('alert('.$rowId.')');
    }
 */
    public function actions(ComparableModel $row): array
    {
        return [
            Button::add()
                ->slot('Resumen'
                    // Renderizamos el componente Blade manualmente
                   /*  Blade::render('<x-icons.document-text class="w-[24px] h-[24px] inline-block" />') */
                )
                ->id()
                ->class('cursor-pointer btn-change')
                ->dispatch('openSummary', ['id' => $row->id]),

            Button::add()
                ->slot('Asignar')
                ->id()
                ->class('cursor-pointer btn-primary')
                ->dispatch('assignedElement', ['idComparable' => $row->id]),

            Button::add()
                ->slot('Editar')
                ->id()
                ->class('cursor-pointer btn-intermediary')
                ->dispatch('editComparable', ['idComparable' => $row->id]),

            Button::add()
                ->slot('Eliminar')
                ->confirm('¿Estás seguro de eliminar el comparable?')
                ->slot('Eliminar')
                ->id()
                ->class('cursor-pointer btn-deleted btn-table')
                ->dispatch('deleteElement', ['idComparable' => $row->id]),


        ];
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
