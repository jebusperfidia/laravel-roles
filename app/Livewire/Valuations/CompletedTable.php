<?php

namespace App\Livewire\Valuations;

use App\Models\Users\Assignment;
use App\Services\DipomexService;
use Illuminate\Database\Eloquent\Builder;
use PowerComponents\LivewirePowerGrid\Button;
use PowerComponents\LivewirePowerGrid\Column;
use PowerComponents\LivewirePowerGrid\Facades\PowerGrid;
use PowerComponents\LivewirePowerGrid\PowerGridFields;
use PowerComponents\LivewirePowerGrid\PowerGridComponent;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Livewire\Attributes\On;
use App\Services\ValuationReportService;

final class CompletedTable extends PowerGridComponent
{
    public string $state = '';
    public $user;
    public $municipalitiesLookup = [];

    public function setUp(): array
    {
        $this->user = Auth::user();

        $normalizedStateId = str_pad($this->state, 2, '0', STR_PAD_LEFT);

        // CAMBIO 1: Actualizamos llave de caché a _v2 para asegurar limpieza
        $cacheKey = 'dipomex_munis_raw_v2_' . $normalizedStateId;

        $rawMunis = Cache::remember($cacheKey, 60 * 60 * 24, function () use ($normalizedStateId) {
            $dipomex = app(DipomexService::class);
            return $dipomex->getMunicipiosPorEstado($normalizedStateId);
        });

        if (is_array($rawMunis)) {
            foreach ($rawMunis as $item) {
                if (is_array($item) && isset($item['MUNICIPIO_ID'])) {
                    $idEntero = (int)$item['MUNICIPIO_ID'];
                    $this->municipalitiesLookup[$idEntero] = $item['MUNICIPIO'];
                } elseif (is_string($item)) {
                    $key = key($rawMunis);
                }
            }

            if (empty($this->municipalitiesLookup) && count($rawMunis) > 0) {
                foreach ($rawMunis as $key => $val) {
                    $this->municipalitiesLookup[(int)$key] = $val;
                }
            }
        }

        return [
            PowerGrid::header()->showSearchInput()
                ->includeViewOnTop('livewire.valuations.partials.loader'),
            PowerGrid::footer()->showPerPage()->showRecordCount(),
        ];
    }

    public function datasource(): Builder
    {
        $query = Assignment::query()
            ->join('valuations', 'assignments.valuation_id', '=', 'valuations.id')
            ->join('users as appraiserU', 'assignments.appraiser_id', '=', 'appraiserU.id')
            ->where('valuations.status', 3);

        if (!empty($this->state)) {
            $query->where('valuations.property_entity', $this->state);
        }

        return $query->select([
            'valuations.id',
            'valuations.folio',
            'valuations.property_street',
            'valuations.property_abroad_number',
            'valuations.property_colony',
            'valuations.property_other_colony',
            'valuations.property_locality',
            'valuations.property_cp',
            'appraiserU.name as appraiser_name',
        ]);
    }

    public function fields(): PowerGridFields
    {
        return PowerGrid::fields()
            ->add('id')
            ->add('folio')
            ->add('full_address', function ($row) {
                $colonia = $row->property_colony;
                if ($colonia === 'no-listada') {
                    $colonia = $row->property_other_colony ?? 'Sin colonia especificada';
                }
                return $row->property_street . ' #' . $row->property_abroad_number . ', ' . $colonia;
            })

            // --- ¡AQUÍ FALTABA ESTO! ---
            // Definimos qué valor va en la columna 'property_locality_label'
            ->add('property_locality_label', function ($row) {
                $key = (int) $row->property_locality;
                // Buscamos en el array que armamos en el setUp
                return $this->municipalitiesLookup[$key] ?? $row->property_locality;
            })
            // ---------------------------

            ->add('property_cp')
            ->add('appraiser_name')
            ->add('pdf_action', function ($row) {
                // Renderizamos la vista pasando el ID
                return view('livewire.valuations.partials.actions.pdf-btn', ['id' => $row->id])->render();
            });
    }

    public function relationSearch(): array
    {
        return [];
    }

    public function columns(): array
    {
        return [
            Column::make('Folio', 'folio')->searchable()->sortable(),
            Column::make('Dirección', 'full_address', 'property_street'),

            // Esta columna busca 'property_locality_label', que acabamos de agregar arriba
            Column::make('Municipio', 'property_locality_label', 'property_locality')->sortable(),

            Column::make('CP', 'property_cp'),
            Column::make('Valuador', 'appraiser_name')->searchable(),
            Column::make('Acciones', 'pdf_action')
                ->bodyAttribute('text-center'),
            /* Column::action('Acciones') */
        ];
    }

    #[on('downloadPdf')]
    public function downloadPdf($id)
    {
        // Inyectamos el servicio manualmente
        $reportService = app(ValuationReportService::class);

        // Generamos el PDF (Recuerda: Esto ahora es un STRING binario gigante)
        $pdfContent = $reportService->makePdf($id);

        // Descarga directa (Livewire se encarga del stream)
        return response()->streamDownload(function () use ($pdfContent) {
            // CORRECCIÓN: Ya no usamos ->output(), solo escupimos el contenido tal cual
            echo $pdfContent;
        }, 'Avaluo_' . $id . '.pdf');
    }

/*
    public function actions($row): array
    {
        return [
            Button::add('pdf')
                ->slot('PDF')
                ->id()
                ->class('cursor-pointer px-3 py-2 text-xs font-medium text-white bg-green-700 rounded-lg hover:bg-green-800 mr-2')
                ->dispatch('downloadPdf', ['id' => $row->id]),
 */
        /*     Button::add('summary')
                ->slot('Resumen')
                ->id()
                ->class('cursor-pointer px-3 py-2 text-xs font-medium text-white bg-blue-700 rounded-lg hover:bg-blue-800 mr-2')
                ->dispatch('openSummary', ['rowId' => $row->id]),

            Button::add('status')
                ->slot('Cambiar estatus')
                ->id()
                ->class('cursor-pointer px-4 py-2 text-xs font-medium text-white bg-slate-600 rounded-lg hover:bg-slate-700')
                ->dispatch('openStatusModal', ['valuationId' => $row->id, 'currentStatus' => 3])
                ->can($this->user->type === 'Administrador'), */
   /*      ];
    } */
}
