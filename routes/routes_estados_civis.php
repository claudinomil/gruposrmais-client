<?php

use App\Http\Controllers\EstadoCivilController;

//EstadosCivis
Route::prefix('estados_civis')->group(function () {
    Route::get('', [EstadoCivilController::class, 'index'])->name('estados_civis.index');
    Route::get('/create', [EstadoCivilController::class, 'create'])->name('estados_civis.create');
    Route::post('', [EstadoCivilController::class, 'store'])->name('estados_civis.store');
    Route::get('/{id}', [EstadoCivilController::class, 'show'])->name('estados_civis.show');
    Route::get('/{id}/edit', [EstadoCivilController::class, 'edit'])->name('estados_civis.edit');
    Route::put('/{id}', [EstadoCivilController::class, 'update'])->name('estados_civis.update');
    Route::delete('/{id}', [EstadoCivilController::class, 'destroy'])->name('estados_civis.destroy');
    Route::get('/filter/{array_dados}', [EstadoCivilController::class, 'filter'])->name('estados_civis.filter');
});
