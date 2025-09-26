<?php

namespace App\Livewire\Forms;

use Livewire\Component;
use Masmerise\Toaster\Toaster;
use App\Models\PropertyLocationModel;
use Illuminate\Validation\ValidationException;

class PropertyLocation extends Component
{
    public $latitude;
    public $longitude;
    public $altitude;

    /**
     * Se ejecuta al cargar el componente.
     */
    public function mount()
    {
        $valuationId = session('valuation_id');
        $propertyLocation = PropertyLocationModel::where('valuation_id', $valuationId)->first();

        if ($propertyLocation) {
            // Carga los datos existentes
            $this->latitude  = $propertyLocation->latitude;
            $this->longitude = $propertyLocation->longitude;
            $this->altitude  = $propertyLocation->altitude;
        } else {
            // **CORRECCIÓN:** Inicializa con coordenadas numéricas válidas si no hay datos.
            // Los mapas no pueden funcionar con valores nulos o vacíos para latitud/longitud.
            $this->latitude  = '23.6345';  // Centro geográfico de México
            $this->longitude = '-102.5528';
            $this->altitude  = null; // La altitud es opcional, se puede inicializar como null
        }
    }

    /**
     * Valida y envía las coordenadas al mapa en el frontend.
     */
    public function locate()
    {
        $this->validateLocation();

        // **CORRECCIÓN:** El nombre del evento debe coincidir con el de la vista (kebab-case).
        $this->dispatch('location-updated', [
            'lat' => $this->latitude,
            'lon' => $this->longitude
        ]);

        Toaster::success('Ubicación actualizada en el mapa');
    }

    /**
     * Guarda los datos en la base de datos.
     */
    public function save()
    {
        $this->validateLocation();
        $valuationId = session('valuation_id');

        PropertyLocationModel::updateOrCreate(
            ['valuation_id' => $valuationId],
            [
                'latitude'  => $this->latitude,
                'longitude' => $this->longitude,
                'altitude'  => $this->altitude,
            ]
        );

        Toaster::success('Formulario guardado con éxito');
        return redirect()->route('form.index', ['section' => 'declarations-warnings']);
    }

    /**
     * Método centralizado para validar.
     */
    protected function validateLocation()
    {
        // El saneamiento se puede omitir si confías en la validación 'numeric'
        try {
            // **CORRECCIÓN:** Hacemos que la altitud sea opcional (nullable).
            $this->validate([
                'latitude'  => ['required', 'numeric', 'between:-90,90'],
                'longitude' => ['required', 'numeric', 'between:-180,180'],
                'altitude'  => ['nullable', 'numeric'], // `nullable` permite que el campo esté vacío
            ]);
        } catch (ValidationException $e) {
            Toaster::error('Hay errores de validación, por favor corrígelos.');
            throw $e;
        }
    }

    // Tu función sanitizeDecimal es buena, pero la validación 'numeric' de Laravel
    // ya maneja la mayoría de los casos, por lo que se puede simplificar el código.

    public function render()
    {
        return view('livewire.forms.property-location');
    }
}
