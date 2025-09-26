<?php

namespace App\Livewire\Forms;

use Livewire\Component;
use Masmerise\Toaster\Toaster;
use Illuminate\Support\Facades\Validator;
use App\Models\DeclarationsWarningsModel;

class DeclarationsWarnings extends Component
{

    public $valuation_id;

    // Variables primer contenedor
    public $dec_idDoc, $dec_areaDoc, $dec_constState, $dec_occupancy, $dec_urbanPlan,
        $dec_inahMonument, $dec_inbaHeritage;

    // Variables segundo contenedor
    public $war_noRelevantDoc, $war_InsufficientComparable, $war_UncertainUsage,
        $war_serviceImpact, $war_otherNotes;

    // Variables tercer contenedor
    public $cyb_conclusionValue, $cyb_inmediateTypology, $cyb_immediateMarketing, $cyb_surfaceIncludesExtras;

    // Variable cuarto contenedor
    public $additionalLimits;


    public function mount()
    {
        $valuationId = session('valuation_id');

        // Guardar el valuationId en una propiedad pública
        $this->valuation_id = $valuationId;

        // Asignar el modelo solo si valuationId existe para evitar errores
        $declarationWarning = DeclarationsWarningsModel::where('valuation_id', $valuationId)->first();


        if ($declarationWarning) {


            $this->dec_idDoc = $declarationWarning->id_doc;
            $this->dec_areaDoc = $declarationWarning->area_doc;
            $this->dec_constState = $declarationWarning->const_state;
            $this->dec_occupancy = $declarationWarning->occupancy;
            $this->dec_urbanPlan = $declarationWarning->urban_plan;
            $this->dec_inahMonument = $declarationWarning->inah_monument;
            $this->dec_inbaHeritage = $declarationWarning->inba_heritage;


            $this->war_noRelevantDoc = $declarationWarning->no_relevant_doc;
            $this->war_InsufficientComparable = $declarationWarning->insufficient_comparable;
            $this->war_UncertainUsage = $declarationWarning->uncertain_usage;
            $this->war_serviceImpact = $declarationWarning->service_impact;
            $this->war_otherNotes = $declarationWarning->other_notes;

            $this->cyb_conclusionValue = $declarationWarning->conclusion_value;
            $this->cyb_inmediateTypology = $declarationWarning->inmediate_typology;
            $this->cyb_immediateMarketing = $declarationWarning->immediate_marketing;
            $this->cyb_surfaceIncludesExtras = $declarationWarning->surface_includes_extras;

            // --- Mapeo de Limitaciones ---
            $this->additionalLimits = $declarationWarning->additional_limits;
        } else {
            // Valores por defecto
            $this->dec_idDoc = 1;
            $this->dec_areaDoc = 1;
            $this->dec_constState = 1;
            $this->dec_occupancy = 1;
            $this->dec_urbanPlan = 1;
            $this->dec_inahMonument = 2;
            $this->dec_inbaHeritage = 2;

            $this->war_noRelevantDoc = false;
            $this->war_InsufficientComparable = false;
            $this->war_UncertainUsage = false;
            $this->war_serviceImpact = false;
            $this->war_otherNotes = "";


            $this->additionalLimits = "";

        }
    }

    public function save()
    {
        $rules = [
            "cyb_conclusionValue" => 'required',
            "cyb_inmediateTypology" => 'required',
            "cyb_immediateMarketing" => 'required',
            "cyb_surfaceIncludesExtras" => 'required',
        ];

        $validator = Validator::make(
            $this->all(),
            $rules,
            [],
            $this->validationAttributes()
        );

        // Comprobamos si se obtuvieron errores de validación
        if ($validator->fails()) {
            // Enviamos un mensaje en pantalla indicando que existen errores de validación
            Toaster::error('Existen errores de validación');

            // Colocamos los errores en pantalla
            $this->setErrorBag($validator->getMessageBag());

            // Hacemos un return para detener el flujo del sistema
            return;
        }

        // Mapea las propiedades del componente a un array con nombres de columnas de la DB
        $data = [
            // Ahora $this->valuation_id está disponible
            'valuation_id' => $this->valuation_id,

            // Mapeo de declaraciones
            'id_doc' => $this->dec_idDoc,
            'area_doc' => $this->dec_areaDoc,
            'const_state' => $this->dec_constState,
            'occupancy' => $this->dec_occupancy,
            'urban_plan' => $this->dec_urbanPlan,
            'inah_monument' => $this->dec_inahMonument,
            'inba_heritage' => $this->dec_inbaHeritage,

            // Mapeo de advertencias
            'no_relevant_doc' => $this->war_noRelevantDoc,
            // CORREGIDO: war_InsufficientComparable (variable ahora existe)
            'insufficient_comparable' => $this->war_InsufficientComparable,
            'uncertain_usage' => $this->war_UncertainUsage,
            'service_impact' => $this->war_serviceImpact,
            'other_notes' => $this->war_otherNotes,

            // Mapeo de cibergestión
            'conclusion_value' => $this->cyb_conclusionValue,
            'inmediate_typology' => $this->cyb_inmediateTypology,
            'immediate_marketing' => $this->cyb_immediateMarketing,
            'surface_includes_extras' => $this->cyb_surfaceIncludesExtras,

            // Mapeo de limitaciones
            'additional_limits' => $this->additionalLimits,
        ];

        // Verifica si ya existe un registro con el valuation_id.
        // Si existe, lo actualiza. Si no, crea uno nuevo.
        DeclarationsWarningsModel::updateOrCreate(
            ['valuation_id' => $this->valuation_id],
            $data
        );

        //
        Toaster::success('Formulario guardado con éxito');
        return redirect()->route('form.index', ['section' => 'urban-features']);
    }

    // ... (El resto de tus métodos)

    protected function validationAttributes(): array
    {
        return [
            'cyb_conclusionValue' => 'Valor Conclusión', // Agregué el nombre
            'cyb_inmediateTypology' => 'Tipología Inmediata', // Agregué el nombre
            'cyb_immediateMarketing' => 'Comercialización Inmediata', // Agregué el nombre
            'cyb_surfaceIncludesExtras' => 'Superficie Incluye Extras', // Agregué el nombre
        ];
    }

    public function render()
    {
        return view('livewire.forms.declarations-warnings');
    }
}
