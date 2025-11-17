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
use PowerComponents\LivewirePowerGrid\Facades\Rule;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Auth;


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

    /* public function datasource(): Builder
    {
        return ComparableModel::query();
    }
*/

    public function datasource(): Builder
    {

        $comparableType = 'land';
        $pivotTableName = 'valuation_land_comparables';

        return ComparableModel::query()
            // *** FILTRO AÑADIDO: Solo registros donde comparable_type es 'land' ***
            ->where('comparable_type', $comparableType)
            // Excluye los comparables ya asignados a este avalúo
            ->whereNotIn('id', function ($query) use ($pivotTableName) {
                $query->select('comparable_id')
                    ->from($pivotTableName)
                    ->where('valuation_id', $this->idValuation);
            })
            // *** FILTRO DE VIGENCIA DE 6 MESES ***
            // Solo muestra comparables creados en los últimos 6 meses.
            ->where('comparables.created_at', '>=', Carbon::now()->subMonths(6));
    }


    public function relationSearch(): array
    {
        return [];
    }

    public function fields(): PowerGridFields
    {
        // *** SE ELIMINARON LAS FUNCIONES AUXILIARES ***

        return PowerGrid::fields()
            ->add('id')
            //->add('valuation_id')
            /* ->add('comparable_key') */
            ->add('comparable_folio')
            /* ->add('comparable_discharged_by') */
            ->add('comparable_property')
            /* ->add('comparable_entity') */
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
            /* ->add('comparable_between_street') */
            /* ->add('comparable_and_street') */
            ->add('comparable_abroad_number')
            ->add('comparable_cp')

            ->add('comparable_offers')
            // *** CAMBIO: Formato de Oferta (inline) ***
            ->add('price_offers', fn(ComparableModel $model) => '$' . number_format($model->comparable_offers, 2, '.', ','))

            ->add('comparable_land_area')
            // *** CAMBIO: Formato de Área de Terreno (inline) ***
            ->add('comparable_land_area_formatted', fn(ComparableModel $model) => number_format($model->comparable_land_area, 2, '.', ','))

            ->add('comparable_unit_value')
            // *** CAMBIO: Formato de Valor Unitario (inline) ***
            ->add('comparable_unit_value_formatted', fn(ComparableModel $model) => '$' . number_format($model->comparable_unit_value, 2, '.', ','))

            ->add('comparable_land_use')

            ->add('comparable_built_area')
            // *** CAMBIO: Formato de Área Construida (inline) ***
            ->add('comparable_built_area_formatted', fn(ComparableModel $model) => number_format($model->comparable_built_area, 2, '.', ','))

            // Este es tu formato de fecha (el ejemplo que debí seguir)
            ->add('created_at_formatted', fn(ComparableModel $model) => Carbon::parse($model->created_at)->format('d/m/Y'))

            ->add(
                'comparable_url',
                fn(ComparableModel $model) =>
                '<a target="_blank" class="underline text-blue-600 hover:text-blue-800" href="' . e($model->comparable_url) . '">' . e($model->comparable_url) . '</a>'
            )

            /* ->add('comparable_name')
            ->add('comparable_last_name')
            ->add('comparable_phone') */
            /* ->add('comparable_desc_services_infraestructure')
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
            /* ->add('comparable_latitude')
            ->add('comparable_longitude') */
            ->add('is_active');
    }

    public function columns(): array
    {
        return [
            Column::make('Id', 'id'),
            /* Column::make('Valuation id', 'valuation_id'),
            /* Column::make('Comparable key', 'comparable_key')
                ->sortable()
                ->searchable(),
*/
            Column::make('Folio', 'comparable_folio')
                ->sortable()
                ->searchable()
                ->bodyAttribute('text-md'),

            /* Column::make('Comparable discharged by', 'comparable_discharged_by')
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

            /* Column::make('Comparable locality', 'comparable_locality')
                ->sortable()
                ->searchable(), */

            Column::make('Ciudad', 'comparable_locality_name')
                ->sortable()
                ->searchable(),

            Column::make('Colonia', 'colony_display', 'comparable_colony')
                ->sortable()
                ->searchable(),

            /* Column::make('Otra colonia', 'comparable_other_colony')
                ->sortable()
                ->searchable(), */

            Column::make('Calle', 'comparable_street')
                ->sortable()
                ->searchable(),

            /* Column::make('Comparable between street', 'comparable_between_street')
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


            // *** CAMBIO: Muestra 'price_offers' (formateado) y ordena/busca por 'comparable_offers' ***
            Column::make('Oferta', 'price_offers', 'comparable_offers')
                ->sortable(),

            // *** CAMBIO: Muestra 'comparable_land_area_formatted' (formateado) y ordena/busca por 'comparable_land_area' ***
            Column::make('Terreno', 'comparable_land_area_formatted', 'comparable_land_area')
                ->sortable(),

            // *** CAMBIO: Muestra 'comparable_unit_value_formatted' (formateado) y ordena/busca por 'comparable_unit_value' ***
            Column::make('Unitario', 'comparable_unit_value_formatted', 'comparable_unit_value')
                ->sortable(),

            Column::make('Uso', 'comparable_land_use')
                ->sortable()
                ->searchable(),


            // *** CAMBIO: Muestra 'comparable_built_area_formatted' (formateado) y ordena/busca por 'comparable_built_area' ***
            Column::make('Construida', 'comparable_built_area_formatted', 'comparable_built_area')
                ->sortable(),

            Column::make('Creado', 'created_at_formatted', 'created_at')
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
            /* Column::make('Comparable latitude', 'comparable_latitude')
                ->sortable()
                ->searchable(),

            Column::make('Comparable longitude', 'comparable_longitude')
                ->sortable()
                ->searchable(), */

            /* Column::make('Is active', 'is_active')
                ->sortable()
                ->searchable(), */

            /* Column::make('Created at', 'created_at_formatted', 'created_at')
                ->sortable(),

            */

            Column::action('Acciones')
        ];
    }

    public function filters(): array
    {
        return [];
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
            Button::add('summary')
                ->slot('Resumen')
                ->class('cursor-pointer btn-change')
                ->dispatch('openSummary', ['id' => $row->id]),

            Button::add('assign')
                ->slot('Asignar')
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
            /* ->can(!$isDisabled), */ // evita que se dispare el evento
        ];
    }
}
