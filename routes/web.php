<?php

use App\Http\Controllers\LeerlingController;
use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome')->name('home');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::view('dashboard', 'dashboard')->name('dashboard');

    Route::get('/leerlingen', [LeerlingController::class, 'index'])->name('leerlingen.index');
    Route::get('/leerlingen/create', [LeerlingController::class, 'create'])->name('leerlingen.create');
    Route::post('/leerlingen', [LeerlingController::class, 'store'])->name('leerlingen.store');
    Route::get('/leerlingen/{id}', [LeerlingController::class, 'show'])->name('leerlingen.show');
    Route::get('/leerlingen/{id}/edit', [LeerlingController::class, 'edit'])->name('leerlingen.edit');
    Route::put('/leerlingen/{id}', [LeerlingController::class, 'update'])->name('leerlingen.update');
    Route::delete('/leerlingen/{id}', [LeerlingController::class, 'destroy'])->name('leerlingen.destroy');
});

require __DIR__.'/settings.php';
