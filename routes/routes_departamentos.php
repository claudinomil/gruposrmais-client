<?php

use App\Http\Controllers\DepartamentoController;

//Departamentos
Route::prefix('departamentos')->group(function () {
    Route::get('', [DepartamentoController::class, 'index'])->name('departamentos.index');
    Route::get('/create', [DepartamentoController::class, 'create'])->name('departamentos.create');
    Route::post('', [DepartamentoController::class, 'store'])->name('departamentos.store');
    Route::get('/{id}', [DepartamentoController::class, 'show'])->name('departamentos.show');
    Route::get('/{id}/edit', [DepartamentoController::class, 'edit'])->name('departamentos.edit');
    Route::put('/{id}', [DepartamentoController::class, 'update'])->name('departamentos.update');
    Route::delete('/{id}', [DepartamentoController::class, 'destroy'])->name('departamentos.destroy');
    Route::get('/search/{field}/{value}',[DepartamentoController::class, 'search'])->name('departamentos.search');
});
