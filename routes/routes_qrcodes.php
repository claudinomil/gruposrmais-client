<?php

use App\Http\Controllers\ClienteServicoController;

Route::prefix('qrcodes')->group(function () {
    Route::prefix('clientes_servicos')->group(function () {
        Route::get('/qrcode_informacoes/{id}', [ClienteServicoController::class, 'qrcode_informacoes'])->name('clientes_servicos.qrcode_informacoes');
        Route::get('/qrcode_brigada_presenca/{id}', [ClienteServicoController::class, 'qrcode_brigada_presenca'])->name('clientes_servicos.qrcode_brigada_presenca');

        //Gravar a Presença do Brigadista
        Route::put('/qrcode_gravar_presenca/{brigada_escala_id}', [ClienteServicoController::class, 'qrcode_gravar_presenca'])->name('clientes_servicos.qrcode_gravar_presenca');
    });
});
