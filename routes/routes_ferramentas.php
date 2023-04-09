<?php

use App\Http\Controllers\FerramentaController;

//Tools
Route::prefix('ferramentas')->group(function () {
    Route::get('', [FerramentaController::class, 'index'])->name('ferramentas.index');
    Route::get('/create', [FerramentaController::class, 'create'])->name('ferramentas.create');
    Route::post('', [FerramentaController::class, 'store'])->name('ferramentas.store');
    Route::get('/{id}', [FerramentaController::class, 'show'])->name('ferramentas.show');
    Route::get('/{id}/edit', [FerramentaController::class, 'edit'])->name('ferramentas.edit');
    Route::put('/{id}', [FerramentaController::class, 'update'])->name('ferramentas.update');
    Route::delete('/{id}', [FerramentaController::class, 'destroy'])->name('ferramentas.destroy');
    Route::get('/search/{field}/{value}', [FerramentaController::class, 'search'])->name('ferramentas.search');
});
