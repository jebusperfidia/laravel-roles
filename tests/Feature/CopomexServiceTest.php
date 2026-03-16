<?php

use App\Services\CopomexService;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

// Forzamos el uso del token de prueba si no hay uno configurado
beforeEach(function () {
    if (empty(config('services.copomex.token'))) {
        config(['services.copomex.token' => 'pruebas']);
    }
});

// ────────────────────────────────────────────────────────────────────────────
// Pruebas de getEstados()
// ────────────────────────────────────────────────────────────────────────────

test('getEstados retorna un array no vacío de strings', function () {
    Cache::flush(); // Limpiamos caché para forzar la llamada real

    $service = app(CopomexService::class);
    $estados = $service->getEstados();

    expect($estados)
        ->toBeArray()
        ->not->toBeEmpty();

    // Todos los elementos deben ser strings
    foreach ($estados as $estado) {
        expect($estado)->toBeString();
    }
});

test('getEstados usa caché en llamadas subsecuentes', function () {
    Cache::flush();

    // Primera llamada: real
    Http::fake([
        'api.copomex.com/query/get_estados*' => Http::response([
            'error'      => false,
            'code_error' => 0,
            'response'   => ['estado' => ['Jalisco', 'Guanajuato', 'Aguascalientes']],
        ], 200),
    ]);

    $service = app(CopomexService::class);
    $primeraLlamada = $service->getEstados();

    // Segunda llamada: debe venir del caché (no debe hacer petición HTTP)
    Http::fake([
        'api.copomex.com/query/get_estados*' => Http::response([], 500), // Si hace request, fallaría
    ]);

    $segundaLlamada = $service->getEstados();

    expect($primeraLlamada)->toBe($segundaLlamada);
    expect($primeraLlamada)->toContain('Aguascalientes');
});

// ────────────────────────────────────────────────────────────────────────────
// Pruebas de buscarPorCodigoPostal()
// ────────────────────────────────────────────────────────────────────────────

test('buscarPorCodigoPostal devuelve estado, municipio y colonias', function () {
    Cache::flush();

    $service = app(CopomexService::class);
    $data = $service->buscarPorCodigoPostal('37000');

    // Con token 'pruebas' los datos vienen ofuscados, pero la estructura SÍ importa
    expect($data)->toBeArray();

    if (! empty($data)) {
        expect($data)->toHaveKeys(['estado', 'municipio', 'ciudad', 'colonias', 'asentamientos']);
        expect($data['colonias'])->toBeArray();
    }
});

test('buscarPorCodigoPostal cachea el resultado por CP', function () {
    Cache::flush();

    Http::fake([
        'api.copomex.com/query/info_cp/37000*' => Http::response([
            [
                'error'      => false,
                'code_error' => 0,
                'response'   => [
                    'cp'          => '37000',
                    'asentamiento' => 'Centro',
                    'municipio'   => 'León',
                    'estado'      => 'Guanajuato',
                    'ciudad'      => 'León de los Aldama',
                    'pais'        => 'México',
                ],
            ],
        ], 200),
    ]);

    $service  = app(CopomexService::class);
    $primera  = $service->buscarPorCodigoPostal('37000');

    // Segunda llamada falla en HTTP pero debe servirse del cache
    Http::fake([
        'api.copomex.com/query/info_cp/37000*' => Http::response([], 500),
    ]);

    $segunda = $service->buscarPorCodigoPostal('37000');

    expect($primera)->toBe($segunda);
    expect($primera['estado'])->toBe('Guanajuato');
    expect($primera['municipio'])->toBe('León');
    expect($primera['colonias'])->toContain('Centro');
});

test('buscarPorCodigoPostal retorna array vacío con CP inexistente', function () {
    Cache::flush();

    Http::fake([
        'api.copomex.com/query/info_cp/00000*' => Http::response([
            ['error' => true, 'code_error' => 1, 'error_message' => 'Not found', 'response' => []],
        ], 200),
    ]);

    $service = app(CopomexService::class);
    $data    = $service->buscarPorCodigoPostal('00000');

    expect($data)->toBeArray()->toBeEmpty();
});

// ────────────────────────────────────────────────────────────────────────────
// Pruebas de getMunicipiosPorEstado()
// ────────────────────────────────────────────────────────────────────────────

test('getMunicipiosPorEstado devuelve array de strings', function () {
    Cache::flush();

    Http::fake([
        'api.copomex.com/query/get_municipio_por_estado*' => Http::response([
            'error'      => false,
            'code_error' => 0,
            'response'   => ['municipios' => ['León', 'Guanajuato', 'Irapuato']],
        ], 200),
    ]);

    $service    = app(CopomexService::class);
    $municipios = $service->getMunicipiosPorEstado('Guanajuato');

    expect($municipios)->toBeArray()->not->toBeEmpty();
    foreach ($municipios as $m) {
        expect($m)->toBeString();
    }
});

test('getMunicipiosPorEstado retorna array vacío cuando el estado está vacío', function () {
    $service    = app(CopomexService::class);
    $municipios = $service->getMunicipiosPorEstado('');

    expect($municipios)->toBe([]);
});

// ────────────────────────────────────────────────────────────────────────────
// Pruebas de getColoniasPorMunicipio()
// ────────────────────────────────────────────────────────────────────────────

test('getColoniasPorMunicipio devuelve array de strings', function () {
    Cache::flush();

    Http::fake([
        'api.copomex.com/query/get_colonia_por_municipio*' => Http::response([
            'error'      => false,
            'code_error' => 0,
            'response'   => ['colonia' => ['Centro', 'Las Joyas', 'Medina']],
        ], 200),
    ]);

    $service  = app(CopomexService::class);
    $colonias = $service->getColoniasPorMunicipio('Guanajuato', 'León');

    expect($colonias)->toBeArray()->not->toBeEmpty();
    foreach ($colonias as $c) {
        expect($c)->toBeString();
    }
});

test('getColoniasPorMunicipio retorna array vacío con estado o municipio vacíos', function () {
    $service = app(CopomexService::class);

    expect($service->getColoniasPorMunicipio('', 'León'))->toBe([]);
    expect($service->getColoniasPorMunicipio('Guanajuato', ''))->toBe([]);
});
