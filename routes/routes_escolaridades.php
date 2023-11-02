<?php

use App\Http\Controllers\EscolaridadeController;

//Escolaridades
Route::prefix('escolaridades')->group(function () {
    Route::get('', [EscolaridadeController::class, 'index'])->name('escolaridades.index');
    Route::get('/create', [EscolaridadeController::class, 'create'])->name('escolaridades.create');
    Route::post('', [EscolaridadeController::class, 'store'])->name('escolaridades.store');
    Route::get('/{id}', [EscolaridadeController::class, 'show'])->name('escolaridades.show');
    Route::get('/{id}/edit', [EscolaridadeController::class, 'edit'])->name('escolaridades.edit');
    Route::put('/{id}', [EscolaridadeController::class, 'update'])->name('escolaridades.update');
    Route::delete('/{id}', [EscolaridadeController::class, 'destroy'])->name('escolaridades.destroy');
    Route::get('/filter/{array_dados}', [EscolaridadeController::class, 'filter'])->name('escolaridades.filter');
});
