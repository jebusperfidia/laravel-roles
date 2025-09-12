<?php

namespace App\Livewire\Forms;

use Livewire\Component;
use Illuminate\Support\Facades\Validator;
use Masmerise\Toaster\Toaster;

class PropertyLocation extends Component
{

    public $latitud, $longitud, $altitud;

    public function mount()
    {
        // Coordenadas iniciales (puedes ajustarlas a una ubicación por defecto más útil)
        $this->latitud = '19.4326';
        $this->longitud = '-99.1332';
        $this->altitud = '2240';
    }

    public function save()
    {

        $rules = [
            'latitud'  => ['required', 'numeric', 'between:-90,90'],
            'longitud' => ['required', 'numeric', 'between:-180,180'],
            'altitud'  => ['required', 'numeric']
        ];

        $validator = Validator::make(
            $this->all(),
            $rules,
            []
            /* $this->validationAttributes() */
        );

        //Comprobamos si se obtuvieron errores de validación
        if ($validator->fails()) {
            //Enviamos un mensaje en pantalla indicando que existen errores de validación
            Toaster::error('Existen errores de validación');

            //Colocamos los errores en pantalla
            $this->setErrorBag($validator->getMessageBag());

            //Hacemos un return para detener el flujo del sistema
            return;
        }


        Toaster::success('Formulario guardado con éxito');
        return redirect()->route('form.index', ['section' => 'nerby-valuations']);
    }



    //Watchers para las variables
    public function updatedLatitud($value)
    {
        if ($value === '') {
            $this->latitud = 0;
            // AÑADIDO: Despachar evento para actualizar el mapa
            $this->dispatchLocationUpdate();
            return;
        }
        $this->latitud = $this->sanitizeDecimal($value);
        // AÑADIDO: Despachar evento para actualizar el mapa
        $this->dispatchLocationUpdate();
    }

    //Watchers para las variables
    public function updatedLongitud($value)
    {
        if ($value === '') {
            $this->longitud = 0;
            // AÑADIDO: Despachar evento para actualizar el mapa
            $this->dispatchLocationUpdate();
            return;
        }
        $this->longitud = $this->sanitizeDecimal($value);
        // AÑADIDO: Despachar evento para actualizar el mapa
        $this->dispatchLocationUpdate();
    }

    //Watchers para las variables
    public function updatedAltitud($value)
    {
        if ($value === '') {
            $this->altitud = 0;
            return;
        }
        $this->altitud = $this->sanitizeDecimal($value);
    }

    // AÑADIDO: Método para despachar el evento de actualización de ubicación al navegador.
    // Esto permite que nuestro JavaScript reaccione a los cambios en el backend.
    private function dispatchLocationUpdate()
    {
        $this->dispatch('locationUpdated', ['lat' => $this->latitud, 'lon' => $this->longitud]);
    }

    private function sanitizeDecimal(string $value): string
    {
        // Detectar guión al inicio
        $hasNegative = str_starts_with($value, '-');

        // Eliminar todos los guiones posteriores
        $value = str_replace('-', '', $value);

        // Quitar cualquier caracter que no sea dígito o punto
        $clean = preg_replace('/[^0-9.]/', '', $value);

        // Conservar solo el primer punto
        $parts = explode('.', $clean);
        if (count($parts) > 1) {
            $clean = $parts[0] . '.' . implode('', array_slice($parts, 1));
        }

        // Reponer el guión al inicio si correspondía
        if ($hasNegative && $clean !== '') {
            $clean = '-' . $clean;
        }

        return $clean;
    }

    public function render()
    {
        return view('livewire.forms.property-location');
    }
}
