<?php

use App\Http\Controllers\GeneroController;

//Generos
Route::prefix('generos')->group(function () {
    Route::get('', [GeneroController::class, 'index'])->name('generos.index');
    Route::get('/create', [GeneroController::class, 'create'])->name('generos.create');
    Route::post('', [GeneroController::class, 'store'])->name('generos.store');
    Route::get('/{id}', [GeneroController::class, 'show'])->name('generos.show');
    Route::get('/{id}/edit', [GeneroController::class, 'edit'])->name('generos.edit');
    Route::put('/{id}', [GeneroController::class, 'update'])->name('generos.update');
    Route::delete('/{id}', [GeneroController::class, 'destroy'])->name('generos.destroy');
    Route::get('/search/{field}/{value}', [GeneroController::class, 'search'])->name('generos.search');
});
