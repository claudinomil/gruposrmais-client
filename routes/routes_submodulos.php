<?php

use App\Http\Controllers\SubmoduloController;

//Submodulos
Route::prefix('submodulos')->group(function () {
    Route::get('', [SubmoduloController::class, 'index'])->name('submodulos.index');
    Route::get('/create', [SubmoduloController::class, 'create'])->name('submodulos.create');
    Route::post('', [SubmoduloController::class, 'store'])->name('submodulos.store');
    Route::get('/{id}', [SubmoduloController::class, 'show'])->name('submodulos.show');
    Route::get('/{id}/edit', [SubmoduloController::class, 'edit'])->name('submodulos.edit');
    Route::put('/{id}', [SubmoduloController::class, 'update'])->name('submodulos.update');
    Route::delete('/{id}', [SubmoduloController::class, 'destroy'])->name('submodulos.destroy');
    Route::get('/search/{field}/{value}', [SubmoduloController::class, 'search'])->name('submodulos.search');
});
