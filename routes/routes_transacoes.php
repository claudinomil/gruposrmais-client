<?php

use App\Http\Controllers\TransacaoController;

//Transacoes
Route::prefix('transacoes')->group(function () {
    Route::get('', [TransacaoController::class, 'index'])->name('transacoes.index');
    Route::get('/filter/{array_dados}', [TransacaoController::class, 'filter'])->name('transacoes.filter');

    //DEIXAR ESSAS ROTAS PARA NÃO DAR ERRO NO JAVASCRIPT AJAX
    //Route::get('/create', [TransacaoController::class, 'create'])->name('transacoes.create');
    Route::post('', [TransacaoController::class, 'store'])->name('transacoes.store');
    //Route::get('/{id}', [TransacaoController::class, 'show'])->name('transacoes.show');
    //Route::get('/{id}/edit', [TransacaoController::class, 'edit'])->name('transacoes.edit');
    //Route::put('/{id}', [TransacaoController::class, 'update'])->name('transacoes.update');
    //Route::delete('/{id}', [TransacaoController::class, 'destroy'])->name('transacoes.destroy');
});
