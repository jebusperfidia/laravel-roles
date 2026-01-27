<?php

use Illuminate\Support\Facades\Route;

// Livewire Components
use App\Livewire\Markets\MarketData;
use App\Livewire\Settings\Profile;
use App\Livewire\Settings\Password;
use App\Livewire\Users\UserIndex;
use App\Livewire\Users\UserCreate;
use App\Livewire\Users\UserEdit;
use App\Livewire\Valuations\ValuationCreate;
use App\Livewire\Valuations\ValuationDuplicate;
use App\Livewire\Valuations\ValuationsIndex;
use App\Livewire\Forms\FormIndex;
use App\Livewire\Forms\Comparables\ComparablesIndex;
use App\Http\Controllers\ValuationPdfController;
// ========================================
// RUTA RAÍZ - Redirige a login directamente
// ========================================
Route::get('/', function () {
    return redirect()->route('login');
})->name('home');


// ========================================
// RUTAS PROTEGIDAS POR AUTENTICACIÓN + comparablesActive
// ========================================
Route::middleware(['auth', 'comparablesActive'])->group(function () {


    // -----------------------------------------
    // CONFIGURACIÓN DE USUARIO
    // -----------------------------------------
    Route::redirect('settings', 'settings/profile');
    Route::get('settings/profile', Profile::class)->name('settings.profile');
    Route::get('settings/password', Password::class)->name('settings.password');

    // -----------------------------------------
    // GRUPO: Solo accesibles si NO hay formulario activo
    // Middleware: formActive
    // -----------------------------------------
    Route::middleware(['formActive'])->group(function () {

        Route::get('/dashboard', ValuationsIndex::class)->name('dashboard');

        Route::middleware(['admin'])->group(function () {
            Route::get("users", UserIndex::class)->name("user.index");
            Route::get("users/create", UserCreate::class)->name("user.create");
            Route::get("users/edit/{id}", UserEdit::class)->name("user.edit");

            Route::get("valuations/create", ValuationCreate::class)->name("valuation.create");
            Route::get("valuations/duplicate", ValuationDuplicate::class)->name("valuation.duplicate");
        });
    });

    // -----------------------------------------
    // DATOS DE MERCADO
    // -----------------------------------------
    Route::get("markets/data", MarketData::class)->name("market.data");

    // -----------------------------------------
    // FORMULARIO DE VALUACIÓN
    // Middleware: checkValuationId
    // -----------------------------------------
    Route::middleware(['checkValuationId'])->group(function () {
        Route::get("form/index", FormIndex::class)->name("form.index");
    });

    // -----------------------------------------
    // FORMULARIO DE COMPARABLES
    // Middleware: comparablesActive (ya aplicado globalmente)
    // -----------------------------------------
    Route::get('form/comparables/index', ComparablesIndex::class)->name('form.comparables.index');
}); // Fin grupo 'auth' + 'comparablesActive'


// ========================================
// RUTAS DE AUTENTICACIÓN
// ========================================
require __DIR__ . '/auth.php';
