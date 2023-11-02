<?php

use App\Http\Controllers\FornecedorController;

//Fornecedores
Route::prefix('fornecedores')->group(function () {
    Route::get('', [FornecedorController::class, 'index'])->name('fornecedores.index');
    Route::get('/create', [FornecedorController::class, 'create'])->name('fornecedores.create');
    Route::post('', [FornecedorController::class, 'store'])->name('fornecedores.store');
    Route::get('/{id}', [FornecedorController::class, 'show'])->name('fornecedores.show');
    Route::get('/{id}/edit', [FornecedorController::class, 'edit'])->name('fornecedores.edit');
    Route::put('/{id}', [FornecedorController::class, 'update'])->name('fornecedores.update');
    Route::delete('/{id}', [FornecedorController::class, 'destroy'])->name('fornecedores.destroy');
    Route::get('/filter/{array_dados}', [FornecedorController::class, 'filter'])->name('fornecedores.filter');

    Route::get('/extradata/{id}', [FornecedorController::class, 'extradata']);
});
