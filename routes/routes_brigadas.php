<?php

use App\Http\Controllers\BrigadaController;

//Brigadas
Route::prefix('brigadas')->group(function () {
    Route::get('', [BrigadaController::class, 'index'])->name('brigadas.index');
    Route::get('/{id}', [BrigadaController::class, 'show'])->name('brigadas.show');
    Route::get('/{id}/edit', [BrigadaController::class, 'edit'])->name('brigadas.edit');
    Route::put('/{id}', [BrigadaController::class, 'update'])->name('brigadas.update');
    Route::get('/search/{field}/{value}', [BrigadaController::class, 'search'])->name('brigadas.search');

    //Escalas
    Route::get('/escalas_index/{brigada_id}/{es_periodo_data_1}/{es_periodo_data_2}', [BrigadaController::class, 'escalas_index'])->name('brigadas.escalas_index');

    Route::get('/ronda_cliente_seguranca_medidas/{op}/{brigada_escala_id}/{brigada_ronda_id}', [BrigadaController::class, 'ronda_cliente_seguranca_medidas'])->name('brigadas.ronda_cliente_seguranca_medidas');
});
