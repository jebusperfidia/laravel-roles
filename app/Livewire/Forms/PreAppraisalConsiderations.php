<?php

namespace App\Livewire\Forms;

use Livewire\Component;
use Illuminate\Support\Facades\Validator;
use Masmerise\Toaster\Toaster;

class PreAppraisalConsiderations extends Component
{

    //Variables primer contenedor
    public $additionalConsiderations, $technicalMemory, $technicalReportBreakdownInformation,
           $technicalReportOthersSupport, $technicalReportDescriptionClculations;

    //Variables segundo contenedor
    public $ach_landCalculation, $ahc_costApproach, $ach_incomeApproach, $ach_dueTo;

    public bool $ach_comparativeApproachLand, $ach_comparativeSalesApproach, $applyFIC;





    public function save()
    {

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
                'ach_dueTo'  => 'required',
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
            'ach_dueTo'  => 'debido a, ',
        ];
    }

    public function render()
    {
        return view('livewire.forms.pre-appraisal-considerations');
    }
}
