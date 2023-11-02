<?php

use App\Http\Controllers\ClienteServicoController;

//Clientes Serviços
Route::prefix('clientes_servicos')->group(function () {
    Route::get('', [ClienteServicoController::class, 'index'])->name('clientes_servicos.index');
    Route::get('/create', [ClienteServicoController::class, 'create'])->name('clientes_servicos.create');
    Route::post('', [ClienteServicoController::class, 'store'])->name('clientes_servicos.store');
    Route::get('/{id}', [ClienteServicoController::class, 'show'])->name('clientes_servicos.show');
    Route::get('/{id}/edit', [ClienteServicoController::class, 'edit'])->name('clientes_servicos.edit');
    Route::put('/{id}', [ClienteServicoController::class, 'update'])->name('clientes_servicos.update');
    Route::delete('/{id}', [ClienteServicoController::class, 'destroy'])->name('clientes_servicos.destroy');
    Route::get('/filter/{array_dados}', [ClienteServicoController::class, 'filter'])->name('clientes_servicos.filter');
});
