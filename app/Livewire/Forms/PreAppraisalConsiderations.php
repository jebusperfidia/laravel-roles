<?php

namespace App\Livewire\Forms;

use Livewire\Component;
use Illuminate\Support\Facades\Validator;
use Masmerise\Toaster\Toaster;
use App\Models\Valuations\Valuation;
use App\Traits\ValuationLockTrait;

use App\Models\Forms\AppraisalConsideration\AppraisalConsiderationModel;


class PreAppraisalConsiderations extends Component
{

    use ValuationLockTrait;

    public $valuationId;

    //Generamos una variable para obtener los datos del modelo
    public $appConElement;

    //Variables primer contenedor
    public $additionalConsiderations, $technicalMemory, $technicalReportBreakdownInformation,
           $technicalReportOthersSupport, $technicalReportDescriptionCalculations;

    //Variables segundo contenedor
    public $ach_landCalculation, $ahc_costApproach, $ach_incomeApproach, $ach_dueTo1, $ach_dueTo2;

    public bool $ach_comparativeApproachLand, $ach_comparativeSalesApproach, $applyFIC;






    public function mount()
    {

        $this->valuationId = session('valuation_id');

        $valuation = Valuation::find($this->valuationId);

        if (!$valuation) return;

        $this->checkReadOnlyStatus($valuation);



        $this->appConElement = AppraisalConsiderationModel::where('valuation_id', $this->valuationId)->first();
        //dd($this->valuationId);

        //dd($this->appConElement);

        if($this->appConElement){
            $this->additionalConsiderations = $this->appConElement->additional_considerations;
            $this->technicalMemory = $this->appConElement->technical_memory;
            $this->technicalReportBreakdownInformation = $this->appConElement->technical_report_breakdown_information;
            $this->technicalReportOthersSupport = $this->appConElement->technical_report_other_support;
            $this->technicalReportDescriptionCalculations = $this->appConElement->technical_report_description_calculations;
            $this->ach_landCalculation = $this->appConElement->land_calculation;
            $this->ahc_costApproach = $this->appConElement->cost_approach;
            $this->ach_incomeApproach = $this->appConElement->income_approach;
            $this->ach_dueTo1 = $this->appConElement->due_to_1;
            $this->ach_dueTo2 = $this->appConElement->due_to_2;
            $this->ach_comparativeApproachLand = $this->appConElement->comparative_approach_land;
            $this->ach_comparativeSalesApproach = $this->appConElement->comparative_sales_approach;
            $this->applyFIC = $this->appConElement->apply_fic;
        } else {
            $this->ach_comparativeApproachLand = false;
            $this->ach_comparativeSalesApproach = false;
            $this->applyFIC = false;
        }
    }



    public function save()
    {
        $this->ensureNotReadOnly();
        //Ejecutar función con todas las reglas de validación y validaciones condicionales, guardando todo en una variable
        $validator = $this->validateAllContainers();

        //Comprobamos si se obtuvieron errores de validación
        if ($validator->fails()) {
            //Enviamos un mensaje en pantalla indicando que existen errores de validación
            Toaster::error('Existen errores de validación');

            //Colocamos los errores en pantalla
            $this->setErrorBag($validator->getMessageBag());

            //Hacemos un return para detener el flujo del sistema
            return;
        }

        //Aquí se ejecutará la lógica de guardado
        $data = [
            'additional_considerations' => $this->additionalConsiderations,
            'technical_memory' => $this->technicalMemory,
            'technical_report_breakdown_information' => $this->technicalReportBreakdownInformation,
            'technical_report_other_support' => $this->technicalReportOthersSupport,
            'technical_report_description_calculations' => $this->technicalReportDescriptionCalculations,
            'land_calculation' => $this->ach_landCalculation,
            'cost_approach' => $this->ahc_costApproach,
            'income_approach' => $this->ach_incomeApproach,
            'due_to_1' => $this->ach_dueTo1,
            'due_to_2' => $this->ach_dueTo2,
            'comparative_approach_land' => $this->ach_comparativeApproachLand,
            'comparative_sales_approach' => $this->ach_comparativeSalesApproach,
            'apply_fic' => $this->applyFIC
        ];

        AppraisalConsiderationModel::updateOrCreate([
            'valuation_id' => $this->valuationId],
             $data
        );


        //Al finalizar, aquí se puede generar un Toaster de guardado o bien, copiar alguna otra función para redireccionar
        //y a la vez enviar un toaster

        Toaster::success('Formulario guardado con éxito');
        return redirect()->route('form.index', ['section' => 'market-focus']);
    }



    public function validateAllContainers()
    {
        //VALIDACIONES CONTAINER 1
        $container1 = [
            "additionalConsiderations" => 'nullable',
            "technicalMemory" => 'nullable',
            "technicalReportBreakdownInformation" => 'nullable',
            "technicalReportOthersSupport" => 'nullable',
            "technicalReportDescriptionClculations" => 'nullable'
        ];

        //VALIDACIONES CONTAINER 2
        $container2 = [
            'ach_landCalculation' => 'required',
            'ahc_costApproach' => 'required',
            'ach_incomeApproach' => 'required',
            /* 'applyFIC' => 'nullable', */
        ];

        //Validaciones específicas si el checkbox de "Si se apllica, usando terrenos directos o residual" está seleccionado
        if ($this->ach_landCalculation === 'Si se apllica, usando terrenos directos o residual') {
            $container2 = array_merge($container2, [
                'ach_comparativeApproachLand'  => 'nullable',
                'ach_comparativeSalesApproach'   => 'nullable',
            ]);
        }

        //Validaciones específicas si el checkbox de "Si se apllica, usando terrenos directos o residual" está seleccionado
        if ($this->ach_landCalculation ===  'No se aplica, no existen comparables debido a...') {
            $container2 = array_merge($container2, [
                'ach_dueTo1'  => 'required',
            ]);
        }

        //Validaciones específicas si el checkbox de "Si se apllica, usando terrenos directos o residual" está seleccionado
        if ($this->ach_incomeApproach ===  'No se aplica, no existen comparables debido a...') {
            $container2 = array_merge($container2, [
                'ach_dueTo2'  => 'required',
            ]);
        }

        //Finalmente, añadiremos las reglas del contenedor 4 y 5 en nuestro arreglo general
        $rules = array_merge($container1, $container2);


        //Genereamos una variable para validar posteriormente si hay algún error de validación desde el método save
        return  Validator::make(
            $this->all(),
            //hacemos la validación final enviando 3 atributos, el primero las reglas
            //el segundo un atributo para no reemplazar los mensajes de validación
            //Y el tercero es para obtener los valores de los atributos traducidos
            $rules,
            [],
            $this->validationAttributes()
        );
    }





    protected function validationAttributes(){
        return [
            'additionalConsiderations' => ' ',
            'technicalMemory' => ' ',
            'technicalReportBreakdownInformation' => ' ',
            'technicalReportOthersSupport' => ' ',
            'technicalReportDescriptionClculations' => ' ',


            'ach_landCalculation' => 'cálculo de terrenos',
            'ahc_costApproach' => 'enfoque de costos',
            'ach_incomeApproach' => 'enfoque de ingresos',
            /*  'applyFIC' => 'regla FIC', */
            /* 'ach_comparativeApproachLand'  => 'comparación de enfoque de terreno',
            'ach_comparativeSalesApproach'   => 'comparación de enfoque de ventas', */
            'ach_dueTo1'  => 'debido a, ',
            'ach_dueTo2'  => 'debido a, ',
        ];
    }

    public function render()
    {
        return view('livewire.forms.pre-appraisal-considerations');
    }
}
