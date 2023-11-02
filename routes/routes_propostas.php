<?php

use App\Http\Controllers\PropostaController;

//Propostas
Route::prefix('propostas')->group(function () {
    Route::get('', [PropostaController::class, 'index'])->name('propostas.index');
    Route::get('/create', [PropostaController::class, 'create'])->name('propostas.create');
    Route::post('', [PropostaController::class, 'store'])->name('propostas.store');
    Route::get('/{id}', [PropostaController::class, 'show'])->name('propostas.show');
    Route::get('/{id}/edit', [PropostaController::class, 'edit'])->name('propostas.edit');
    Route::put('/{id}', [PropostaController::class, 'update'])->name('propostas.update');
    Route::delete('/{id}', [PropostaController::class, 'destroy'])->name('propostas.destroy');
    Route::get('/filter/{array_dados}', [PropostaController::class, 'filter'])->name('propostas.filter');

    Route::get('/gerar_pdf/proposta/{id}', [PropostaController::class, 'gerar_pdf_proposta'])->name('propostas.gerar_pdf_proposta');
});
