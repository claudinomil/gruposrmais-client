<?php

use App\Http\Controllers\EnviarEmailController;

//Emails
Route::prefix('enviar_email')->group(function () {
    Route::get('users/primeiro_acesso/{email}/{senha}', [EnviarEmailController::class, 'primeiro_acesso'])->name('enviar_email.primeiro_acesso');
});
