<?php

use App\Livewire\Markets\MarketData;
use App\Livewire\Settings\Appearance;
use App\Livewire\Settings\Password;
use App\Livewire\Settings\Profile;
use Illuminate\Support\Facades\Route;
use App\Livewire\Users\UserIndex;
use App\Livewire\Users\UserCreate;
use App\Livewire\Users\UserEdit;
/* use App\Livewire\Valuations\ValuationArchived; */
use App\Livewire\Valuations\ValuationCreate;
use App\Livewire\Valuations\ValuationDuplicate;
use App\Livewire\Valuations\ValuationsIndex;
use App\Livewire\Forms\FormIndex;

/* Route::get('/', function () {
    return view('welcome');
})->name('home'); */

/* Redireccionamiento al login, evitando el acceso a welcome */
Route::get('/', function () {
    return redirect()->route('login');
})->name('home');


/* Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard'); */

/* Envio a las rutas al dashboard principal */
/* Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard'); */

//Ruta principal, carga la ruta de valuaciones index, con el tablero principal
Route::get('/dashboard', ValuationsIndex::class)->middleware(['auth'])->name('dashboard');

    //Ruta de configuración del perfil de usuario
    Route::middleware(['auth'])->group(function () {
    Route::redirect('settings', 'settings/profile');

    //Rutas usuario
    /*    Route::get("users", UserIndex::class)->name("user.index");
    Route::get("users/create", UserCreate::class)->name("user.create");
    Route::get("users{id}/edit", UserEdit::class)->name("user.edit"); */

    // Rutas de usuario (solo para Administrador)
    Route::middleware(['admin'])->group(function () {
        Route::get("users", UserIndex::class)->name("user.index");
        Route::get("users/create", UserCreate::class)->name("user.create");
        Route::get("users/{id}/edit", UserEdit::class)->name("user.edit");
    });


    //Rutas de avaluos
    Route::get("valuations/create", ValuationCreate::class)->name("valuation.create");
    Route::get("valuations/duplicate", ValuationDuplicate::class)->name("valuation.duplicate");
   /*  Route::get("valuations/archived", ValuationArchived::class)->name("valuation.archived"); */

    //Rutas de mercado
    Route::get("markets/data", MarketData::class)->name("market.data");

    //Rutas de formularios
    Route::get("form/index", FormIndex::class)->name("form.index");


    Route::get('settings/profile', Profile::class)->name('settings.profile');
    Route::get('settings/password', Password::class)->name('settings.password');
    /* Route::get('settings/appearance', Appearance::class)->name('settings.appearance'); */
});

require __DIR__.'/auth.php';
