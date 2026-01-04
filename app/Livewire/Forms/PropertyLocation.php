<?php

namespace App\Livewire\Forms;

use Livewire\Component;
use Masmerise\Toaster\Toaster;
use App\Models\Forms\PropertyLocation\PropertyLocationModel;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

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
            $this->altitude  = '0'; // La altitud es opcional, se puede inicializar como null
        }
    }

    /**
     * Valida y envía las coordenadas al mapa en el frontend.
     */
public function locate()
{
    $this->validateLocation();

    // Enviar lat, lon y alt al frontend
    $this->dispatch('location-updated', [
        'lat' => $this->latitude,
        'lon' => $this->longitude,
        'alt' => $this->altitude ?? 0, // si no hay altitud, 0
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
                'altitude'  => ['required', 'numeric'],
            ],
            [],
            [
                'latitude' => 'latitud',
                'longitude' => 'longitud',
                'altitude' => 'altitud'
            ]

        );
        } catch (ValidationException $e) {
            Toaster::error('Hay errores de validación, por favor corrígelos.');
            throw $e;
        }
    }

    // Tu función sanitizeDecimal es buena, pero la validación 'numeric' de Laravel
    // ya maneja la mayoría de los casos, por lo que se puede simplificar el código.


    public function saveMapImages($macroBase64, $microBase64)
    {
        // Validación simple para no procesar si llegan vacíos
        if (empty($macroBase64) && empty($microBase64)) {
            return;
        }

        $valuationId = session('valuation_id');

        // Función anónima para procesar el guardado y evitar repetir código
        $processImage = function ($base64Data, $suffix) use ($valuationId) {
            if (!$base64Data) return;

            // 1. Limpiar el encabezado del string Base64 (data:image/png;base64,...)
            if (strpos($base64Data, ',') !== false) {
                $base64Data = explode(',', $base64Data)[1];
            }

            // 2. Decodificar
            $imageContent = base64_decode($base64Data);

            if ($imageContent === false) {
                Log::error("Error al decodificar la imagen $suffix para valuación $valuationId");
                return;
            }

            // 3. Definir nombre y ruta
            // Guardamos en: storage/app/public/location_maps/
            $filename = "map_{$valuationId}_{$suffix}.png";
            $path = "location_maps/{$filename}";

            // 4. Guardar en disco 'public'
            Storage::disk('public')->put($path, $imageContent);
        };

        // Procesar ambas imágenes
        $processImage($macroBase64, 'macro');
        $processImage($microBase64, 'micro');
    }

    public function render()
    {
        return view('livewire.forms.property-location');
    }
}
