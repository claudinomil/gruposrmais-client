<?php

use App\Http\Controllers\VisitaTecnicaController;

//VisitasTecnicas
Route::prefix('visitas_tecnicas')->group(function () {
    Route::get('', [VisitaTecnicaController::class, 'index'])->name('visitas_tecnicas.index');
    Route::get('/create', [VisitaTecnicaController::class, 'create'])->name('visitas_tecnicas.create');
    Route::post('', [VisitaTecnicaController::class, 'store'])->name('visitas_tecnicas.store');
    Route::get('/{id}', [VisitaTecnicaController::class, 'show'])->name('visitas_tecnicas.show');
    Route::get('/{id}/edit', [VisitaTecnicaController::class, 'edit'])->name('visitas_tecnicas.edit');
    Route::put('/{id}', [VisitaTecnicaController::class, 'update'])->name('visitas_tecnicas.update');
    Route::delete('/{id}', [VisitaTecnicaController::class, 'destroy'])->name('visitas_tecnicas.destroy');
    Route::get('/search/{field}/{value}', [VisitaTecnicaController::class, 'search'])->name('visitas_tecnicas.search');

    Route::get('/extradata/{id}', [VisitaTecnicaController::class, 'extradata']);

    Route::get('/medidas_seguranca/{np}/{atc}/{grupo}/{divisao}', [VisitaTecnicaController::class, 'medidas_seguranca'])->name('visitas_tecnicas.medidas_seguranca');

    Route::post('/documentos_upload/{file}', [VisitaTecnicaController::class, 'documentos_upload'])->name('visitas_tecnicas.documentos_upload');
});
