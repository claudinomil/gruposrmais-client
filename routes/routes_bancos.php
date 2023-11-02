<?php

use App\Http\Controllers\BancoController;

//Bancos
Route::prefix('bancos')->group(function () {
    Route::get('', [BancoController::class, 'index'])->name('bancos.index');
    Route::get('/create', [BancoController::class, 'create'])->name('bancos.create');
    Route::post('', [BancoController::class, 'store'])->name('bancos.store');
    Route::get('/{id}', [BancoController::class, 'show'])->name('bancos.show');
    Route::get('/{id}/edit', [BancoController::class, 'edit'])->name('bancos.edit');
    Route::put('/{id}', [BancoController::class, 'update'])->name('bancos.update');
    Route::delete('/{id}', [BancoController::class, 'destroy'])->name('bancos.destroy');
    Route::get('/filter/{array_dados}', [BancoController::class, 'filter'])->name('bancos.filter');
});
