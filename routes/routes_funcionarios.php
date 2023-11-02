<?php

use App\Http\Controllers\FuncionarioController;

//Funcionarios
Route::prefix('funcionarios')->group(function () {
    Route::get('', [FuncionarioController::class, 'index'])->name('funcionarios.index');
    Route::get('/create', [FuncionarioController::class, 'create'])->name('funcionarios.create');
    Route::post('', [FuncionarioController::class, 'store'])->name('funcionarios.store');
    Route::get('/{id}', [FuncionarioController::class, 'show'])->name('funcionarios.show');
    Route::get('/{id}/edit', [FuncionarioController::class, 'edit'])->name('funcionarios.edit');
    Route::put('/{id}', [FuncionarioController::class, 'update'])->name('funcionarios.update');
    Route::delete('/{id}', [FuncionarioController::class, 'destroy'])->name('funcionarios.destroy');
    Route::get('/filter/{array_dados}', [FuncionarioController::class, 'filter'])->name('funcionarios.filter');

    Route::get('/extradata/{id}', [FuncionarioController::class, 'extradata']);
    Route::post('/uploadfoto', [FuncionarioController::class, 'uploadfoto'])->name('funcionarios.uploadfoto');

    Route::post('/documento_upload/{documento_upload_descricao}', [FuncionarioController::class, 'documento_upload'])->name('funcionarios.documento_upload');
    Route::delete('/deletar_documento/{funcionario_documento_id}', [FuncionarioController::class, 'deletar_documento'])->name('funcionarios.deletar_documento');
});
