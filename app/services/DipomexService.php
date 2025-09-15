<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Http\Client\PendingRequest;

class DipomexService
{
    protected $baseUrl;
    protected $apiKey;

    /**
     * El constructor ahora también obtiene la API Key desde el archivo de configuración.
     */
    public function __construct()
    {
        $this->apiKey = config('services.dipomex.key');
        $this->baseUrl = 'https://api.tau.com.mx/dipomex/v1/';
    }

    /**
     * Método privado para crear un cliente HTTP ya configurado con la API Key.
     * Esto nos evita repetir el código del encabezado en cada método.
     *
     * @return \Illuminate\Http\Client\PendingRequest
     */
    private function httpClient(): PendingRequest
    {
        // Si por alguna razón la API Key no está configurada, la petición fallará.
        // Esto es una salvaguarda para detectar errores de configuración.
        abort_if(empty($this->apiKey), 500, 'La API Key de DIPOMEX no está configurada.');

        // Usamos withHeaders para añadir el encabezado 'x-api-key' en cada petición.
        return Http::withHeaders([
            'APIKEY' => $this->apiKey
        ]);
    }

    /**
     * Obtiene la lista de todos los estados de México.
     */
    public function getEstados(): array
    {
        // Usamos nuestro cliente pre-configurado para hacer la llamada.
        $response = $this->httpClient()->get($this->baseUrl . '/estados');

        if ($response->successful()) {
            return collect($response->json()['estados'])->pluck('ESTADO', 'ESTADO_ID')->all();
        }

        return [];
    }

    /**
     * Busca la información de un Código Postal.
     */
    public function buscarPorCodigoPostal(string $codigoPostal): array
    {
        $response = $this->httpClient()->get($this->baseUrl . '/codigo_postal', [
            'cp' => $codigoPostal,
        ]);

        if ($response->successful() && isset($response->json()['codigo_postal'])) {
            return $response->json()['codigo_postal'];
        }

        return [];
    }

    /**
     * Obtiene los municipios de un estado específico.
     */
    public function getMunicipiosPorEstado(string $estadoId): array
    {
        $response = $this->httpClient()->get($this->baseUrl . '/municipios', [
            'id_estado' => $estadoId, // <-- cambio aquí
        ]);

        if ($response->successful() && isset($response->json()['municipios'])) {
            return collect($response->json()['municipios'])->pluck('MUNICIPIO', 'MUNICIPIO_ID')->all();
        }

        return [];
    }


    public function getColoniasPorMunicipio(string $estadoId, string $municipioId): array
    {
        $response = $this->httpClient()->get($this->baseUrl . '/colonias', [
            'id_estado' => $estadoId,
            'id_mun' => $municipioId,
        ]);

        if ($response->successful() && isset($response->json()['colonias'])) {
            return collect($response->json()['colonias'])->pluck('COLONIA')->all();
        }

        return [];
    }


    public function getRawMunicipiosPorEstado(string $estadoId): array
    {
        $response = $this->httpClient()->get($this->baseUrl . '/municipios', [
            'id_estado' => $estadoId,
        ]);

        if ($response->successful() && isset($response->json()['municipios'])) {
            return $response->json()['municipios'];
        }

        return [];
    }
}
