<?php

use App\Http\Controllers\ClienteServicoController;

Route::prefix('qrcodes')->group(function () {
    Route::prefix('clientes_servicos')->group(function () {
        //SERVIÇO: Brigadas'''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
        //Informações Gerais
        Route::get('/qrcode_brigada_informacoes/{id}', [ClienteServicoController::class, 'qrcode_brigada_informacoes'])->name('clientes_servicos.qrcode_brigada_informacoes');

        //Chegada, Rondas e Saída
        Route::get('/qrcode_brigada_escalas/{id}', [ClienteServicoController::class, 'qrcode_brigada_escalas'])->name('clientes_servicos.qrcode_brigada_escalas');
        Route::put('/qrcode_brigada_escala_operacao_salvar/{brigada_escala_id}', [ClienteServicoController::class, 'qrcode_brigada_escala_operacao_salvar'])->name('clientes_servicos.qrcode_brigada_escala_operacao_salvar');
        //''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
    });
});
