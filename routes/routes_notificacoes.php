<?php

use App\Http\Controllers\NotificacaoController;

//Notificacoes
Route::prefix('notificacoes')->group(function () {
    Route::get('', [NotificacaoController::class, 'index'])->name('notificacoes.index');
    Route::get('/create', [NotificacaoController::class, 'create'])->name('notificacoes.create');
    Route::post('', [NotificacaoController::class, 'store'])->name('notificacoes.store');
    Route::get('/{id}', [NotificacaoController::class, 'show'])->name('notificacoes.show');
    Route::get('/{id}/edit', [NotificacaoController::class, 'edit'])->name('notificacoes.edit');
    Route::put('/{id}', [NotificacaoController::class, 'update'])->name('notificacoes.update');
    Route::delete('/{id}', [NotificacaoController::class, 'destroy'])->name('notificacoes.destroy');
    Route::get('/search/{field}/{value}', [NotificacaoController::class, 'search'])->name('notificacoes.search');
});
