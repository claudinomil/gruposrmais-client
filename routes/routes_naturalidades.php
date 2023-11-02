<?php

use App\Http\Controllers\NaturalidadeController;

//Naturalidades
Route::prefix('naturalidades')->group(function () {
    Route::get('', [NaturalidadeController::class, 'index'])->name('naturalidades.index');
    Route::get('/create', [NaturalidadeController::class, 'create'])->name('naturalidades.create');
    Route::post('', [NaturalidadeController::class, 'store'])->name('naturalidades.store');
    Route::get('/{id}', [NaturalidadeController::class, 'show'])->name('naturalidades.show');
    Route::get('/{id}/edit', [NaturalidadeController::class, 'edit'])->name('naturalidades.edit');
    Route::put('/{id}', [NaturalidadeController::class, 'update'])->name('naturalidades.update');
    Route::delete('/{id}', [NaturalidadeController::class, 'destroy'])->name('naturalidades.destroy');
    Route::get('/filter/{array_dados}', [NaturalidadeController::class, 'filter'])->name('naturalidades.filter');
});
