<?php

use App\Http\Controllers\EmpresaController;

//Empresas
Route::prefix('empresas')->group(function () {
    Route::get('', [EmpresaController::class, 'index'])->name('empresas.index');
    Route::get('/create', [EmpresaController::class, 'create'])->name('empresas.create');
    Route::post('', [EmpresaController::class, 'store'])->name('empresas.store');
    Route::get('/{id}', [EmpresaController::class, 'show'])->name('empresas.show');
    Route::get('/{id}/edit', [EmpresaController::class, 'edit'])->name('empresas.edit');
    Route::put('/{id}', [EmpresaController::class, 'update'])->name('empresas.update');
    Route::delete('/{id}', [EmpresaController::class, 'destroy'])->name('empresas.destroy');
    Route::get('/filter/{array_dados}', [EmpresaController::class, 'filter'])->name('empresas.filter');
});
