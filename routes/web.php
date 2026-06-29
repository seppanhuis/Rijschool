<?php

use App\Http\Controllers\LeerlingController;
use App\Http\Controllers\FacaturenController;
use Illuminate\Support\Facades\Route;


Route::view('/', 'welcome')->name('home');


Route::middleware(['auth', 'verified'])->group(function () {

    Route::view('dashboard', 'dashboard')->name('dashboard');


    // LEERLINGEN
    Route::get('/leerlingen', [LeerlingController::class, 'index'])
        ->name('leerlingen.index');

    Route::get('/leerlingen/create', [LeerlingController::class, 'create'])
        ->name('leerlingen.create');

    Route::post('/leerlingen', [LeerlingController::class, 'store'])
        ->name('leerlingen.store');

    Route::get('/leerlingen/{id}', [LeerlingController::class, 'show'])
        ->name('leerlingen.show');

    Route::get('/leerlingen/{id}/edit', [LeerlingController::class, 'edit'])
        ->name('leerlingen.edit');

    Route::put('/leerlingen/{id}', [LeerlingController::class, 'update'])
        ->name('leerlingen.update');

    Route::delete('/leerlingen/{id}', [LeerlingController::class, 'destroy'])
        ->name('leerlingen.destroy');



    // FACATUREN CRUD

    // overzicht
    Route::get('/facaturen', [FacaturenController::class, 'index'])
        ->name('facaturen.index');


    // betaal/create pagina
    Route::get('/facaturen/betaal/{id}', [FacaturenController::class, 'create'])
        ->name('facaturen.create');


    // opslaan
    Route::post('/facaturen/betaal', [FacaturenController::class, 'store'])
        ->name('facaturen.store');



    // EDIT
    Route::get('/facaturen/{id}/edit', [FacaturenController::class, 'edit'])
        ->name('facaturen.edit');


    // UPDATE
    Route::put('/facaturen/{id}', [FacaturenController::class, 'update'])
        ->name('facaturen.update');


    // DELETE
    Route::delete('/facaturen/{id}', [FacaturenController::class, 'destroy'])
        ->name('facaturen.destroy');

});


require __DIR__ . '/settings.php';