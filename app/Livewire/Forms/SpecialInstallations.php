<?php

namespace App\Livewire\Forms;

use Livewire\Component;
use App\Models\Valuation;
use Illuminate\Support\Facades\Session;
use Masmerise\Toaster\Toaster;
use Flux\Flux;

class SpecialInstallations extends Component
{

    //Propiedades para input select tipo tabla
    public array $select_SI, $select_AE, $select_CW,
                 $select_units,
                 $select_conservation_factor;


    // Estado del tab activo
    public string $activeTab;

    //Generamos una variable para guardar la información del avaluo
    public $valuation;

    //Variables para generar elementos en tablas
    public $key, $descriptionSI, $descriptionAE, $descriptionCW,
    $unit, $quantity, $age, $usefulLife, $newRepUnitCost, $ageFactor, $conservationFactor,
    $netRepUnitCost, $undivided, $amount;

    public function mount()
    {

        //Obtenemos los valores para los input

        //valores para los input de instalaciones especiales
        $this->select_SI = config('properties_inputs.special_installations', []);
        $this->select_AE = config('properties_inputs.elements_accessories', []);
        $this->select_CW = config('properties_inputs.complementary_works', []);
        $this->select_units = config('properties_inputs.special_installations_unit', []);
        $this->select_conservation_factor = config('properties_inputs.special_installations_conservationFactor', []);


        //Inicializamos el valor de la pestaña que se abrirá por defecto
        $this->activeTab = 'privativas';

        //Obtenemos los valores deL avalúo a partir de la variable de sesión del ID
        $this->valuation = Valuation::find(Session::get('valuation_id'));
    }


    //FUNCIONES PARA GRUPOS Y ELEMENTOS DEL MISMO

    //Función de modales para instalaciones especiales (privativas y comunes)
    public function openAddElementSI()
    {
        $this->resetValidation();
        Flux::modal('add-elementSI')->show();
    }

    public function openEditElementSI()
    {

        $this->resetValidation();
        Flux::modal('edit-elementSI')->show();
    }


    public function addElementSI()
    {
        $rules = [
            // Campos de tipo string
            /* 'key' => 'required|string', */
            'descriptionSI' => 'required|string',
            'unit' => 'required|string',

            // Campos de tipo numérico (flotante) que deben ser mayores a 0
            'quantity' => 'nullable|numeric|gt:0',
            'age' => 'required|numeric|gt:0',
            'usefulLife' => 'required|numeric|gt:0',
            'newRepUnitCost' => 'required|numeric|gt:0',
            'ageFactor' => 'required|numeric|gt:0',
            'conservationFactor' => 'required|numeric|gt:0',
            'netRepUnitCost' => 'required|numeric|gt:0',
            'undivided' => 'required|numeric|gt:0',
            'amount' => 'required|numeric|gt:0',
        ];

        $this->validate(
            $rules,
            [],
            $this->validationAttributesItems()
        );

        Toaster::success("Elemento creado con éxito");
        $this->modal('add-elementSI')->close();


        $this->key = '';
        $this->descriptionSI = '';
        $this->unit = '';
        $this->quantity = '';
        $this->age = '';
        $this->usefulLife = '';
        $this->newRepUnitCost = '';
        $this->ageFactor = '';
        $this->conservationFactor = '';
        $this->netRepUnitCost = '';
        $this->undivided = '';
        $this->amount = '';
    }

    public function editElementSI()
    {
        $rules = [
            'descriptionSI' => 'required|string',
            'unit' => 'required|string',

            // Campos de tipo numérico (flotante) que deben ser mayores a 0
            'quantity' => 'nullable|numeric|gt:0',
            'age' => 'required|numeric|gt:0',
            'usefulLife' => 'required|numeric|gt:0',
            'newRepUnitCost' => 'required|numeric|gt:0',
            'ageFactor' => 'required|numeric|gt:0',
            'conservationFactor' => 'required|numeric|gt:0',
            'netRepUnitCost' => 'required|numeric|gt:0',
            'undivided' => 'required|numeric|gt:0',
            'amount' => 'required|numeric|gt:0',
        ];

        $this->validate(
            $rules,
            [],
            $this->validationAttributesItems()
        );

        Toaster::success("Elemento editado con éxito");
        $this->modal('edit-elementSI')->close();

        $this->key = '';
        $this->descriptionSI = '';
        $this->unit = '';
        $this->quantity = '';
        $this->age = '';
        $this->usefulLife = '';
        $this->newRepUnitCost = '';
        $this->ageFactor = '';
        $this->conservationFactor = '';
        $this->netRepUnitCost = '';
        $this->undivided = '';
        $this->amount = '';
    }

    public function deleteElementSI()
    {
        Toaster::error("Elemento eliminado con éxito");
    }




    //Función de modales para instalaciones especiales (privativas y comunes)
    public function openAddElementAE()
    {
        $this->resetValidation();
        Flux::modal('add-elementAE')->show();

    }

    public function openEditElementAE()
    {
        $this->resetValidation();
        Flux::modal('edit-elementAE')->show();
    }


    public function addElementAE()
    {
        $rules = [
            // Campos de tipo string
            /* 'key' => 'required|string', */
            'descriptionAE' => 'required|string',
            'unit' => 'required|string',

            // Campos de tipo numérico (flotante) que deben ser mayores a 0
            'quantity' => 'nullable|numeric|gt:0',
            'age' => 'required|numeric|gt:0',
            'usefulLife' => 'required|numeric|gt:0',
            'newRepUnitCost' => 'required|numeric|gt:0',
            'ageFactor' => 'required|numeric|gt:0',
            'conservationFactor' => 'required|numeric|gt:0',
            'netRepUnitCost' => 'required|numeric|gt:0',
            'undivided' => 'required|numeric|gt:0',
            'amount' => 'required|numeric|gt:0',
        ];

        $this->validate(
            $rules,
            [],
            $this->validationAttributesItems()
        );

        Toaster::success("Elemento creado con éxito");
        $this->modal('add-elementAE')->close();


        $this->key = '';
        $this->descriptionAE = '';
        $this->unit = '';
        $this->quantity = '';
        $this->age = '';
        $this->usefulLife = '';
        $this->newRepUnitCost = '';
        $this->ageFactor = '';
        $this->conservationFactor = '';
        $this->netRepUnitCost = '';
        $this->undivided = '';
        $this->amount = '';
    }

    public function editElementAE()
    {
        $rules = [
            'descriptionAE' => 'required|string',
            'unit' => 'required|string',

            // Campos de tipo numérico (flotante) que deben ser mayores a 0
            'quantity' => 'nullable|numeric|gt:0',
            'age' => 'required|numeric|gt:0',
            'usefulLife' => 'required|numeric|gt:0',
            'newRepUnitCost' => 'required|numeric|gt:0',
            'ageFactor' => 'required|numeric|gt:0',
            'conservationFactor' => 'required|numeric|gt:0',
            'netRepUnitCost' => 'required|numeric|gt:0',
            'undivided' => 'required|numeric|gt:0',
            'amount' => 'required|numeric|gt:0',
        ];

        $this->validate(
            $rules,
            [],
            $this->validationAttributesItems()
        );

        Toaster::success("Elemento editado con éxito");
        $this->modal('edit-elementAE')->close();

        $this->key = '';
        $this->descriptionAE = '';
        $this->unit = '';
        $this->quantity = '';
        $this->age = '';
        $this->usefulLife = '';
        $this->newRepUnitCost = '';
        $this->ageFactor = '';
        $this->conservationFactor = '';
        $this->netRepUnitCost = '';
        $this->undivided = '';
        $this->amount = '';
    }

    public function deleteElementAE()
    {
        Toaster::error("Elemento eliminado con éxito");
    }


    //Función de modales para instalaciones especiales (privativas y comunes)
    public function openAddElementCW()
    {
        $this->resetValidation();
        Flux::modal('add-elementCW')->show();
    }

    public function openEditElementCW()
    {
        $this->resetValidation();
        Flux::modal('edit-elementCW')->show();
    }


    public function addElementCW()
    {
        $rules = [
            // Campos de tipo string
            /* 'key' => 'required|string', */
            'descriptionCW' => 'required|string',
            'unit' => 'required|string',

            // Campos de tipo numérico (flotante) que deben ser mayores a 0
            'quantity' => 'nullable|numeric|gt:0',
            'age' => 'required|numeric|gt:0',
            'usefulLife' => 'required|numeric|gt:0',
            'newRepUnitCost' => 'required|numeric|gt:0',
            'ageFactor' => 'required|numeric|gt:0',
            'conservationFactor' => 'required|numeric|gt:0',
            'netRepUnitCost' => 'required|numeric|gt:0',
            'undivided' => 'required|numeric|gt:0',
            'amount' => 'required|numeric|gt:0',
        ];

        $this->validate(
            $rules,
            [],
            $this->validationAttributesItems()
        );

        Toaster::success("Elemento creado con éxito");
        $this->modal('add-elementCW')->close();


        $this->key = '';
        $this->descriptionCW = '';
        $this->unit = '';
        $this->quantity = '';
        $this->age = '';
        $this->usefulLife = '';
        $this->newRepUnitCost = '';
        $this->ageFactor = '';
        $this->conservationFactor = '';
        $this->netRepUnitCost = '';
        $this->undivided = '';
        $this->amount = '';
    }

    public function editElementCW()
    {
        $rules = [
            'descriptionCW' => 'required|string',
            'unit' => 'required|string',

            // Campos de tipo numérico (flotante) que deben ser mayores a 0
            'quantity' => 'nullable|numeric|gt:0',
            'age' => 'required|numeric|gt:0',
            'usefulLife' => 'required|numeric|gt:0',
            'newRepUnitCost' => 'required|numeric|gt:0',
            'ageFactor' => 'required|numeric|gt:0',
            'conservationFactor' => 'required|numeric|gt:0',
            'netRepUnitCost' => 'required|numeric|gt:0',
            'undivided' => 'required|numeric|gt:0',
            'amount' => 'required|numeric|gt:0',
        ];

        $this->validate(
            $rules,
            [],
            $this->validationAttributesItems()
        );

        Toaster::success("Elemento editado con éxito");
        $this->modal('edit-elementCW')->close();

        $this->key = '';
        $this->descriptionCW = '';
        $this->unit = '';
        $this->quantity = '';
        $this->age = '';
        $this->usefulLife = '';
        $this->newRepUnitCost = '';
        $this->ageFactor = '';
        $this->conservationFactor = '';
        $this->netRepUnitCost = '';
        $this->undivided = '';
        $this->amount = '';
    }

    public function deleteElementCW()
    {
        Toaster::error("Elemento eliminado con éxito");
    }

    //Método para cambiar de tab
    public function setTab(string $tab)
    {
        $this->activeTab = $tab;
    }


    protected function validationAttributesItems(): array
    {
        return [
            'key' => 'clave',
            'descriptionSI' => 'descripción',
            'descriptionAE' => 'descripción',
            'descriptionCW' => 'descripción',
            'unit' => 'unidad',
            'quantity' => 'cantidad',
            'age' => 'edad',
            'usefulLife' => 'vida útil',
            'newRepUnitCost' => 'costo unit de rep nuevo',
            'ageFactor' => 'factor de edad',
            'conservationFactor' => 'factor de conservación',
            'netRepUnitCost' => 'costo unit de rep neto',
            'undivided' => 'indiviso',
            'amount' => 'importe',
        ];
    }


    public function render()
    {
        return view('livewire.forms.special-installations');
    }
}
