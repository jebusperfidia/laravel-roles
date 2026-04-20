<?php

namespace App\Services;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class CopomexService
{
    protected string $baseUrl = 'https://api.copomex.com/query';
    protected string $token;
    protected int $cacheTtl;

    public function __construct()
    {
        $this->token    = config('services.copomex.token');
        $this->cacheTtl = 60 * 60 * 24 * 90; // 90 días
    }

    private function request(string $endpoint): mixed
    {
        abort_if(empty($this->token), 500, 'El token de COPOMEX no está configurado.');

        try {
            $response = Http::timeout(10)->get("{$this->baseUrl}/{$endpoint}", [
                'token' => $this->token,
            ]);

            $json = $response->json();

            // 1. Si el servidor tronó (Ej. 500) o no devolvió JSON
            if ($response->serverError() || $json === null) {
                return false;
            }

            // 2. Si es 400 Bad Request (Como tus capturas de error)
            if (! $response->successful()) {
                if (is_array($json) && isset($json['error']) && $json['error'] === true) {

                    // Error 3: El token es inválido. Esto SÍ es una caída real del sistema.
                    if (isset($json['code_error']) && $json['code_error'] == 3) {
                        Log::error('Copomex Token Error: ' . ($json['error_message'] ?? 'Token inválido'));
                        return false;
                    }

                    // Error 104 (o cualquier otro): CP inválido. No es caída, solo no hay datos.
                    return [];
                }

                // Si dio 400 pero no es el formato de Copomex, es caída de red/servidor.
                return false;
            }

            // 3. Si fue 200 OK, pero viene con error adentro por si las moscas
            if (is_array($json) && isset($json[0]['error']) && $json[0]['error'] === true) {
                return [];
            } elseif (is_array($json) && isset($json['error']) && $json['error'] === true) {
                return [];
            }

            // 4. Todo perfecto (200 OK con datos como en tu captura del 37549)
            return $json;
        } catch (\Exception $e) {
            Log::error('Copomex API Request Error: ' . $e->getMessage());
            return false;
        }
    }

    private function slug(string $value): string
    {
        return Str::slug($value, '_');
    }

    public function getEstados(): array|false
    {
        $cacheKey = 'copomex_estados_v1';

        $cached = Cache::get($cacheKey);
        if ($cached !== null) return $cached;

        $json = $this->request('get_estados');

        if ($json === false) return false;
        if (empty($json) || !isset($json['response']['estado'])) return [];

        $estados = array_map(function ($estado) {
            return mb_strtoupper($estado, 'UTF-8');
        }, $json['response']['estado']);

        sort($estados);
        Cache::put($cacheKey, $estados, $this->cacheTtl);

        return $estados;
    }

    public function buscarPorCodigoPostal(string $cp): array|false
    {
        $cp = trim($cp);
        $cacheKey = "copomex_cp_{$cp}_v1";

        $cached = Cache::get($cacheKey);
        if ($cached !== null) return $cached;

        $json = $this->request("info_cp/{$cp}");

        if ($json === false) return false;

        if (empty($json) || ! is_array($json)) {
            Cache::put($cacheKey, [], $this->cacheTtl);
            return [];
        }

        $primero = $json[0]['response'] ?? null;
        if (! $primero) return [];

        $asentamientos = collect($json)
            ->pluck('response.asentamiento')
            ->filter()
            ->unique()
            ->sort()
            ->map(function ($colonia) {
                return mb_strtoupper($colonia, 'UTF-8');
            })
            ->values()
            ->all();

        $result = [
            'estado'        => mb_strtoupper($primero['estado'] ?? '', 'UTF-8'),
            'municipio'     => mb_strtoupper($primero['municipio'] ?? '', 'UTF-8'),
            'ciudad'        => mb_strtoupper($primero['ciudad'] ?? '', 'UTF-8'),
            'asentamientos' => $asentamientos,
            'colonias'      => $asentamientos,
        ];

        Cache::put($cacheKey, $result, $this->cacheTtl);
        return $result;
    }

    public function getMunicipiosPorEstado(string $estado): array|false
    {
        $estado = trim($estado);
        if (empty($estado)) return [];

        $cacheKey = 'copomex_municipios_' . $this->slug($estado) . '_v1';

        $cached = Cache::get($cacheKey);
        if ($cached !== null) return $cached;

        // CAMBIO CLAVE: rawurlencode en lugar de urlencode
        $json = $this->request('get_municipio_por_estado/' . rawurlencode($estado));

        if ($json === false) return false;
        if (empty($json) || !isset($json['response']['municipios'])) return [];

        $municipios = array_map(function ($mun) {
            return mb_strtoupper($mun, 'UTF-8');
        }, $json['response']['municipios']);

        sort($municipios);
        Cache::put($cacheKey, $municipios, $this->cacheTtl);

        return $municipios;
    }
    public function getColoniasPorMunicipio(string $estado, string $municipio): array|false
    {
        $estado    = trim($estado);
        $municipio = trim($municipio);

        if (empty($estado) || empty($municipio)) return [];

        $cacheKey = 'copomex_colonias_' . $this->slug($estado) . '_' . $this->slug($municipio) . '_v1';

        $cached = Cache::get($cacheKey);
        if ($cached !== null) return $cached;

        // CAMBIO CLAVE: rawurlencode en lugar de urlencode
        $json = $this->request('get_colonia_por_municipio/' . rawurlencode($municipio));

        if ($json === false) return false;
        if (empty($json) || !isset($json['response']['colonia'])) return [];

        $colonias = array_map(function ($col) {
            return mb_strtoupper($col, 'UTF-8');
        }, $json['response']['colonia']);

        sort($colonias);
        Cache::put($cacheKey, $colonias, $this->cacheTtl);

        return $colonias;
    }
}
