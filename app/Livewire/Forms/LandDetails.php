<?php

namespace App\Livewire\Forms;

use Livewire\Component;
use Illuminate\Support\Facades\Validator;
use Masmerise\Toaster\Toaster;
use Livewire\WithFileUploads;
use Flux\Flux;

class LandDetails extends Component
{

    use WithFileUploads;
    public $photos = []; // Propiedad para almacenar múltiples archivos

    //PRIMER CONTENEDOR
    public $sli_sourceLegalInformation;
    //Variables select escritura
    public $sli_notaryOfficeDeed, $sli_deedDeed, $sli_volumeDeed, $sli_dateDeed, $sli_notaryDeed, $sli_judicialDistricDeed;
    //Variables select sentencia
    public $sli_fileJudgment, $sli_dateJudgment, $sli_courtJudgment, $sli_municipalityJudgment;
    //Variables select contrato privado
    public $sli_datePrivCont, $sli_namePrivContAcq, $sli_firstNamePrivContAcq, $sli_secondNamePrivContAcq,
        $sli_namePrivContAlt, $sli_firstNamePrivContAlt, $sli_secondNamePrivContAlt;
    //Variante select alineamiento y numero oficial
    public $sli_folioAon, $sli_dateAon, $sli_municipalityAon;
    //Variante select título de propiedad
    public $sli_recordPropReg, $sli_datePropReg, $sli_instrumentPropReg, $sli_placePropReg;
    //Variante select otra fuente de informacion legal
    public $sli_especifyAsli, $sli_dateAsli, $sli_emittedByAsli, $sli_folioAsli;


    //SEGUNDO CONTENEDOR







    //Vatiable para crear grupo
    public $group;

    //Variables para crear elemento de grupo
    public $orientation, $adjacent;
    public float $extent;





    //TERCER CONTENEDOR
    public $ct_streetWithFront, $ct_CrossStreet1, $ct_crossStreetOrientation1, $ct_CrossStreet2, $ct_crossStreetOrientation2,
        $ct_borderStreet1, $ct_borderStreetOrientation1, $ct_borderStreet2, $ct_borderStreetOrientation2, $ct_location,
        $ct_configuration, $ct_topography, $ct_typeOfRoad, $ct_panoramicFeatures, $ct_EasementRestrictions;

    public function mount(){
        $this->extent = 0;
    }

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
        return redirect()->route('form.index', ['section' => 'property-description']);
    }




    //FUNCIONES PARA GRUPOS Y ELEMENTOS DEL MISMO

    public function openAddGroup()
    {
        $this->resetValidation();
        Flux::modal('add-group')->show();      // 3) Abre el modal

    }

    public function openAddElement()
    {
        $this->resetValidation();
        Flux::modal('add-element')->show();      // 3) Abre el modal
    }

    public function openEditElement()
    {
        $this->resetValidation();
        Flux::modal('edit-element')->show();      // 3) Abre el modal

    }


    public function addGroup(){


        $rules = [
            'group' => 'required'
        ];

        $this->validate(
            $rules,
            [],
            $this->validationAttributeGroup()
        );

        Toaster::success('Grupo agregado con éxito');
        $this->modal('add-group')->close();
    }



    public function deleteGroup(){

        Toaster::error('Grupo eliminado con éxito');

    }

    public function addItem()
    {
        $rules = [
            'orientation' => 'required',
            'extent' => 'required',
            'adjacent' => 'required',
        ];

        $this->validate(
            $rules,
            [],
            $this->validationAttributesItem()
        );


        $this->orientation = '';
        $this->extent = 0;
        $this->orientation = '';

        Toaster::success('Elemento agregado con éxito');
        $this->modal('add-item')->close();
    }


    public function editItem(){


        $rules = [
            'orientation' => 'required',
            'extent' => 'required',
            'adjacent' => 'required',
        ];

        $this->validate(
            $rules,
            [],
            $this->validationAttributesItem()
        );


        $this->orientation = '';
        $this->extent = 0;
        $this->orientation = '';

        Toaster::success('Elemento editado con éxito');
        $this->modal('edit-item')->close();
    }


    public function deleteItem(){
        Toaster::error('Elemento eliminado con éxito');
    }





    public function validateAllContainers()
    {
        //VALIDACIONES CONTAINER 1
        $container1 = [
            'sli_sourceLegalInformation' => 'required',
        ];

        //Validaciones si el tipo de fuente de informacion legal es escritura
        if ($this->sli_sourceLegalInformation === 'Escritura') {
            $container1 = array_merge($container1, [
                'sli_notaryOfficeDeed'  => 'required',
                'sli_deedDeed'   => 'required',
                'sli_volumeDeed' => 'required',
                'sli_dateDeed' => 'required',
                'sli_notaryDeed' => 'required',
                'sli_judicialDistricDeed' => 'required',
            ]);
        }

        //Validaciones si el tipo de fuente de información legal es sentencia
        if ($this->sli_sourceLegalInformation === 'Sentencia') {
            $container1 = array_merge($container1, [
                'sli_fileJudgment'  => 'required',
                'sli_dateJudgment'   => 'required',
                'sli_courtJudgment' => 'required',
                'sli_municipalityJudgment' => 'required',

            ]);
        }

        //Validaciones si el tipo de fuente de información legal es contrato privado
        if ($this->sli_sourceLegalInformation === 'Contrato privado') {
            $container1 = array_merge($container1, [
                'sli_datePrivCont'  => 'required',
                'sli_namePrivContAcq'   => 'required',
                'sli_firstNamePrivContAcq' => 'required',
                'sli_secondNamePrivContAcq' => 'required',
                'sli_namePrivContAlt' => 'required',
                'sli_firstNamePrivContAlt' => 'required',
                'sli_secondNamePrivContAlt' => 'required',

            ]);
        }


        //Validaciones si el tipo de fuente de información legal es alineamiento y numero oficial
        if ($this->sli_sourceLegalInformation === 'Alineamiento y numero oficial') {
            $container1 = array_merge($container1, [
                'sli_folioAon'  => 'required',
                'sli_dateAon'   => 'required',
                'sli_municipalityAon' => 'required'
            ]);
        }


        //Validaciones si el tipo de fuente de información legal es titulo de propiedad
        if ($this->sli_sourceLegalInformation === 'Titulo de propiedad') {
            $container1 = array_merge($container1, [
                'sli_recordPropReg'  => 'required',
                'sli_datePropReg'   => 'required',
                'sli_instrumentPropReg' => 'required',
                'sli_placePropReg' => 'required',
            ]);
        }


        //Validaciones si el tipo de fuente de información legal es otra fuente de informacion legal
        if ($this->sli_sourceLegalInformation === 'Otra fuente de informacion legal') {
            $container1 = array_merge($container1, [
                'sli_especifyAsli'  => 'required',
                'sli_dateAsli'   => 'required',
                'sli_emittedByAsli' => 'required',
                'sli_folioAsli' => 'required',
            ]);
        }

        //VALIDACIONES CONTAINER 3
        $container3 = [
            'ct_streetWithFront' => 'required',
            'ct_CrossStreet1' => 'required',
            'ct_crossStreetOrientation1' => 'required',
            'ct_CrossStreet2' => 'required',
            'ct_crossStreetOrientation2' => 'required',
            'ct_borderStreet1' => 'required',
            'ct_borderStreetOrientation1' => 'required',
            'ct_borderStreet2' => 'required',
            'ct_borderStreetOrientation2' => 'required',
            'ct_location' => 'required',
            'ct_configuration' => 'required',
            'ct_topography' => 'required',
            'ct_typeOfRoad' => 'required',
            'ct_panoramicFeatures' => 'required',
            'ct_EasementRestrictions' => 'required'
        ];

        $rules = array_merge($container1, $container3);

        return  Validator::make(
            $this->all(),
            $rules,
            [],
            $this->validationAttributes()
        );

    }

    protected function validationAttributes(): array
    {
        return [
            'sli_sourceLegalInformation' => 'fuente de información legal',


            'sli_notaryOfficeDeed'  => 'notaria',
            'sli_deedDeed'   => 'escritura',
            'sli_volumeDeed' => 'volumen',
            'sli_dateDeed' => 'fecha',
            'sli_notaryDeed' => 'notario',
            'sli_judicialDistricDeed' => 'distrito judicial',


            'sli_fileJudgment'  => 'expediente',
            'sli_dateJudgment'   => 'fecha',
            'sli_courtJudgment' => 'juzgado',
            'sli_municipalityJudgment' => 'municipio/alcaldia',


            'sli_datePrivCont'  => 'fecha',
            'sli_namePrivContAcq'   => 'nombre',
            'sli_firstNamePrivContAcq' => 'apellido paterno',
            'sli_secondNamePrivContAcq' => 'apellido materno',
            'sli_namePrivContAlt' => 'nombre',
            'sli_firstNamePrivContAlt' => 'apellido paterno',
            'sli_secondNamePrivContAlt' => 'apellido materno',


            'sli_folioAon'  => 'folio',
            'sli_dateAon'   => 'fecha',
            'sli_municipalityAon' => 'municipio/alcaldia',


            'sli_recordPropReg'  => 'expediente',
            'sli_datePropReg'   => 'fecha',
            'sli_instrumentPropReg' => '# instrumento',
            'sli_placePropReg' => 'lugar',


            'sli_especifyAsli'  => 'especifique',
            'sli_dateAsli'   => 'fecha',
            'sli_emittedByAsli' => 'emitido por',
            'sli_folioAsli' => 'folio',



            'ct_streetWithFront' => 'calle con frente',
            'ct_CrossStreet1' => 'calle transversal',
            'ct_crossStreetOrientation1' => 'orientacion calle transversal',
            'ct_CrossStreet2' => 'calle transversal',
            'ct_crossStreetOrientation2' => 'orientacion calle transversal',
            'ct_borderStreet1' => 'calle limitrofe',
            'ct_borderStreetOrientation1' => 'orientacion calle limitrofe',
            'ct_borderStreet2' => 'calle limitrofe',
            'ct_borderStreetOrientation2' => 'orientacion calle limitrofe',
            'ct_location' => 'ubicacion',
            'ct_configuration' => 'configuracion',
            'ct_topography' => 'topografia',
            'ct_typeOfRoad' => 'tipo de vialidad',
            'ct_panoramicFeatures' => 'caracteristicas panoramicas',
            'ct_EasementRestrictions' => 'servidumbre y/o restricciones'


        ];
    }


    protected function validationAttributeGroup(): array
    {
        return [
            'group' => 'grupo'
        ];
    }


    protected function validationAttributesItem(): array
    {
        return [
            'orientation' => 'orientacion',
            'extent' => ' medida',
            'adjacent' => 'colindancia',
        ];
    }

    //FUNCION PARA LA CARGA DE ARCHIVOS
    public function updatedPhotos()
    {
        $this->validate([
            'photos.*' => 'required|mimes:pdf,jpg,jpeg|max:2048', // Valida cada archivo en el array
        ]);
    }


    /**
     * Función principal para cargar y guardar los archivos en el servidor.
     * Esta función es llamada por el botón 'Cargar archivo'
     */
    public function uploadFiles()
    {
        // 3: Validación para el campo vacío: se utiliza 'required' en la propiedad 'photos'.
        $this->validate([
            'photos' => 'required', // Se asegura de que al menos un archivo haya sido seleccionado.
            'photos.*' => 'mimes:pdf,jpg,jpeg|max:2048',
        ], [
            // Mensaje de error personalizado para la validación del campo vacío
            'photos.required' => 'Por favor, selecciona al menos un archivo para cargar.',
        ]);

        // Itera sobre cada archivo en el array de 'photos'.
        foreach ($this->photos as $photo) {
            // Guarda cada archivo en el disco 'public' dentro de la carpeta 'attachments'.
            $path = $photo->store('attachments', 'public');

            // TODO: Aquí debes agregar la lógica para guardar la ruta del archivo ($path) en tu base de datos.
            // Por ejemplo:
            // Attachment::create([
            //     'file_name' => $photo->getClientOriginalName(),
            //     'path' => $path,
            //     'user_id' => auth()->id(),
            // ]);
        }

        // Limpia el array de archivos para resetear el input.
        $this->photos = [];

        // Muestra un mensaje de éxito que se puede mostrar en la vista.
        session()->flash('message', '¡Archivos cargados correctamente!');
    }


    public function render()
    {
        return view('livewire.forms.land-details');
    }
}
