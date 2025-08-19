<?php

namespace App\Livewire\Forms;

use App\Models\Valuation;
use Livewire\Component;
use Illuminate\Support\Facades\Session;

class FormIndex extends Component
{

     public $id;
    public $valuation;

    // Declaramos la propiedad $section (inicializada en null)
    public $section = null; // Mantenerlo nulo por defecto
    // Lista de secciones permitidas
    public $sections = [
        'general-info',
        'property-location',
        'nerby-valuations',
        'declarations-warnings',
        'urban-features',
        'urban-equipment',
        'land-details',
        'property-description',
        'photo-report',
        'pdf-export',
        'applicable-surfaces',
        'buildings',
        'construction-elements',
        'echo-technologies',
        'finish-capture',
        'pre-appraisal-considerations',
        'pre-conclusion-considerations',
        'special-installations',
        'd-t-c-infonavit',
        'conclusion'
    ];

    // Permitimos que venga ?section=xxx en la URL
    protected $queryString = ['section'];

    public function mount()
    {/*
        $this->IdValuation = $id; */
        //dd('Valoración ID recibida:', $id, gettype($id));

        // 1. Marcar flujo activo
        /* Session::put('valuation-active-form', true); */

        // 2. Recuperar valuation_id de sesión
        $this->id = Session::get('valuation_id');

        /* Session::forget('valuation_id'); */
        //dd(Session::get('valuation-active-form'));

        // 3. Traer el modelo / refrescar
        $this->valuation = Valuation::find($this->id);

        /* dd($this->id); */
        /* $this->valuation = Valuation::find($id); */
        /*  dd('Valoración ID recibida:', $this->valuation); */
        /* Session::put('valuation-active-form', true); */

        // 4. Si llegó ?section=xyz, lo asignamos
        /* $this->section = $section ?: $this->section; */
        // NO hacemos nada con $this->section aquí.
        // Si no viene query-string, $section permanece nulo.
    }

    // Nuevo método para regresar al menú principal
    public function backMain()
    {

        /* $this->js('confirm("¿Estás seguro?") || event.stopImmediatePropagation()'); */
        // 1. Eliminar la variable de sesión
        Session::pull('valuation-active-form');
        Session::pull('valuation_id');

        // 2. Redirigir al usuario a la página principal (raíz)
        return $this->redirect('/', navigate: true);
    }

    public function render()
    {
        return view('livewire.forms.form-index');
    }
}
