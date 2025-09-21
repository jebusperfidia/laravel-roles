<?php

namespace App\Livewire\Forms;

use Livewire\Component;
use Masmerise\Toaster\Toaster;
use Illuminate\Validation\ValidationException;

class PropertyLocation extends Component
{
    // Propiedades públicas que se enlazan al formulario (con wire:model)
    public $latitud;
    public $longitud;
    public $altitud;

    // Se ejecuta al cargar el componente
    public function mount()
    {
        // Coordenadas por defecto (CDMX)
        $this->latitud = '19.4326';
        $this->longitud = '-99.1332';
        $this->altitud = '2240';
    }

    // Método que actualiza los mapas desde el botón "Localizar"
    public function locate()
    {
        // Valida los datos
        $this->validateLocation();

        // Envía un evento personalizado al frontend con las coordenadas
        $this->dispatch('locationUpdated', [
            'lat' => $this->latitud,
            'lon' => $this->longitud
        ]);

        // Muestra notificación (opcional)
        Toaster::success('Ubicación actualizada en el mapa');
    }

    // Método que guarda el formulario completo
    public function save()
    {
        // Valida los datos
        $this->validateLocation();

        // Guardar en la base de datos (no implementado aquí)

        // Muestra mensaje y redirige
        Toaster::success('Formulario guardado con éxito');
        return redirect()->route('form.index', ['section' => 'nerby-valuations']);
    }

    // Valida latitud, longitud y altitud con reglas estrictas
    protected function validateLocation()
    {
        // Limpia y convierte los valores antes de validar
        $this->latitud = $this->sanitizeDecimal((string) $this->latitud);
        $this->longitud = $this->sanitizeDecimal((string) $this->longitud);
        $this->altitud = $this->sanitizeDecimal((string) $this->altitud);

        try {
            $this->validate([
                'latitud'  => ['required', 'numeric', 'between:-90,90'],
                'longitud' => ['required', 'numeric', 'between:-180,180'],
                'altitud'  => ['required', 'numeric'],
            ]);
        } catch (ValidationException $e) {
            Toaster::error('Hay errores de validación, por favor corrígelos.');
            throw $e;
        }
    }

    // Limpieza personalizada de campos decimales (quita símbolos y convierte comas a puntos)
    private function sanitizeDecimal(string $value): string
    {
        $hasNegative = str_starts_with($value, '-');
        $clean = preg_replace('/[^0-9,.]/', '', $value);
        $clean = str_replace(',', '.', $clean);

        $parts = explode('.', $clean);
        if (count($parts) > 1) {
            $clean = $parts[0] . '.' . implode('', array_slice($parts, 1));
        }

        if ($hasNegative && $clean !== '' && $clean !== '0') {
            $clean = '-' . $clean;
        }

        return $clean;
    }

    // Renderiza la vista Blade asociada
    public function render()
    {
        return view('livewire.forms.property-location');
    }
}
