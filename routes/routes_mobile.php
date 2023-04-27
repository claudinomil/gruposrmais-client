<?php

use App\Http\Controllers\MobileController;
use App\Http\Controllers\MobileClienteController;
use App\Http\Controllers\MobileVisitaTecnicaController;

//Mobile
Route::prefix('mobile')->group(function () {
    Route::get('', [MobileController::class, 'index'])->name('mobile.index');
    Route::get('/create', [MobileController::class, 'create'])->name('mobiles.create');
    Route::post('', [MobileController::class, 'store'])->name('mobiles.store');
    Route::get('/{id}', [MobileController::class, 'show'])->name('mobiles.show');
    Route::get('/{id}/edit', [MobileController::class, 'edit'])->name('mobiles.edit');
    Route::put('/{id}', [MobileController::class, 'update'])->name('mobiles.update');
    Route::delete('/{id}', [MobileController::class, 'destroy'])->name('mobiles.destroy');
    Route::get('/search/{field}/{value}', [MobileController::class, 'search'])->name('mobiles.search');
});

//Mobile Clientes
Route::prefix('mobile_clientes')->group(function () {
    Route::get('', [MobileClienteController::class, 'index'])->name('mobile_clientes.index');
    Route::get('/create', [MobileClienteController::class, 'create'])->name('mobile_clientes.create');
    Route::post('', [MobileClienteController::class, 'store'])->name('mobile_clientes.store');
    Route::get('/{id}', [MobileClienteController::class, 'show'])->name('mobile_clientes.show');
    Route::get('/{id}/edit', [MobileClienteController::class, 'edit'])->name('mobile_clientes.edit');
    Route::put('/{id}', [MobileClienteController::class, 'update'])->name('mobile_clientes.update');
    Route::delete('/{id}', [MobileClienteController::class, 'destroy'])->name('mobile_clientes.destroy');
    Route::get('/search/{field}/{value}', [MobileClienteController::class, 'search'])->name('mobile_clientes.search');
});

//Mobile Visitas Tecnicas
Route::prefix('mobile_visitas_tecnicas')->group(function () {
    Route::get('', [MobileVisitaTecnicaController::class, 'index'])->name('mobile_visitas_tecnicas.index');
    Route::get('/create', [MobileVisitaTecnicaController::class, 'create'])->name('mobile_visitas_tecnicas.create');
    Route::post('', [MobileVisitaTecnicaController::class, 'store'])->name('mobile_visitas_tecnicas.store');
    Route::get('/{id}', [MobileVisitaTecnicaController::class, 'show'])->name('mobile_visitas_tecnicas.show');
    Route::get('/{id}/edit', [MobileVisitaTecnicaController::class, 'edit'])->name('mobile_visitas_tecnicas.edit');
    Route::put('/{id}', [MobileVisitaTecnicaController::class, 'update'])->name('mobile_visitas_tecnicas.update');
    Route::delete('/{id}', [MobileVisitaTecnicaController::class, 'destroy'])->name('mobile_visitas_tecnicas.destroy');
    Route::get('/search/{field}/{value}', [MobileVisitaTecnicaController::class, 'search'])->name('mobile_visitas_tecnicas.search');
});
