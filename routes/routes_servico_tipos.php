<?php

use App\Http\Controllers\ServicoTipoController;

//ServicoTipos
Route::prefix('servico_tipos')->group(function () {
    Route::get('', [ServicoTipoController::class, 'index'])->name('servico_tipos.index');
    Route::get('/create', [ServicoTipoController::class, 'create'])->name('servico_tipos.create');
    Route::post('', [ServicoTipoController::class, 'store'])->name('servico_tipos.store');
    Route::get('/{id}', [ServicoTipoController::class, 'show'])->name('servico_tipos.show');
    Route::get('/{id}/edit', [ServicoTipoController::class, 'edit'])->name('servico_tipos.edit');
    Route::put('/{id}', [ServicoTipoController::class, 'update'])->name('servico_tipos.update');
    Route::delete('/{id}', [ServicoTipoController::class, 'destroy'])->name('servico_tipos.destroy');
    Route::get('/filter/{array_dados}', [ServicoTipoController::class, 'filter'])->name('servico_tipos.filter');
});
