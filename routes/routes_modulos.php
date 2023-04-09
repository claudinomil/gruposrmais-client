<?php

use App\Http\Controllers\ModuloController;

//Modulos
Route::prefix('modulos')->group(function () {
    Route::get('', [ModuloController::class, 'index'])->name('modulos.index');
    Route::get('/create', [ModuloController::class, 'create'])->name('modulos.create');
    Route::post('', [ModuloController::class, 'store'])->name('modulos.store');
    Route::get('/{id}', [ModuloController::class, 'show'])->name('modulos.show');
    Route::get('/{id}/edit', [ModuloController::class, 'edit'])->name('modulos.edit');
    Route::put('/{id}', [ModuloController::class, 'update'])->name('modulos.update');
    Route::delete('/{id}', [ModuloController::class, 'destroy'])->name('modulos.destroy');
    Route::get('/search/{field}/{value}', [ModuloController::class, 'search'])->name('modulos.search');
});
