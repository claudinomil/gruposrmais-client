<?php

use App\Http\Controllers\VisitaTecnicaController;

//VisitasTecnicas
Route::prefix('visitas_tecnicas')->group(function () {
    Route::get('', [VisitaTecnicaController::class, 'index'])->name('visitas_tecnicas.index');
    Route::get('/{id}', [VisitaTecnicaController::class, 'show'])->name('visitas_tecnicas.show');
    Route::get('/{id}/edit', [VisitaTecnicaController::class, 'edit'])->name('visitas_tecnicas.edit');
    Route::put('/{id}', [VisitaTecnicaController::class, 'update'])->name('visitas_tecnicas.update');
    Route::get('/filter/{array_dados}', [VisitaTecnicaController::class, 'filter'])->name('visitas_tecnicas.filter');

    Route::get('/medidas_seguranca/{np}/{atc}/{grupo}/{divisao}', [VisitaTecnicaController::class, 'medidas_seguranca'])->name('visitas_tecnicas.medidas_seguranca');

    Route::post('/documentos_upload/{file}', [VisitaTecnicaController::class, 'documentos_upload'])->name('visitas_tecnicas.documentos_upload');
});
