<?php

use App\Http\Controllers\GrupoController;

//Grupos
Route::prefix('grupos')->group(function () {
    Route::get('', [GrupoController::class, 'index'])->name('grupos.index');
    Route::get('/create', [GrupoController::class, 'create'])->name('grupos.create');
    Route::post('', [GrupoController::class, 'store'])->name('grupos.store');
    Route::get('/{id}', [GrupoController::class, 'show'])->name('grupos.show');
    Route::get('/{id}/edit', [GrupoController::class, 'edit'])->name('grupos.edit');
    Route::put('/{id}', [GrupoController::class, 'update'])->name('grupos.update');
    Route::delete('/{id}', [GrupoController::class, 'destroy'])->name('grupos.destroy');
    Route::get('/filter/{array_dados}', [GrupoController::class, 'filter'])->name('grupos.filter');
});
