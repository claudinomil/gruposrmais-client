<?php

use App\Http\Controllers\IdentidadeOrgaoController;

//Identityorgans
Route::prefix('identidade_orgaos')->group(function () {
    Route::get('', [IdentidadeOrgaoController::class, 'index'])->name('identidade_orgaos.index');
    Route::get('/create', [IdentidadeOrgaoController::class, 'create'])->name('identidade_orgaos.create');
    Route::post('', [IdentidadeOrgaoController::class, 'store'])->name('identidade_orgaos.store');
    Route::get('/{id}', [IdentidadeOrgaoController::class, 'show'])->name('identidade_orgaos.show');
    Route::get('/{id}/edit', [IdentidadeOrgaoController::class, 'edit'])->name('identidade_orgaos.edit');
    Route::put('/{id}', [IdentidadeOrgaoController::class, 'update'])->name('identidade_orgaos.update');
    Route::delete('/{id}', [IdentidadeOrgaoController::class, 'destroy'])->name('identidade_orgaos.destroy');
    Route::get('/filter/{array_dados}', [IdentidadeOrgaoController::class, 'filter'])->name('identidade_orgaos.filter');
});
