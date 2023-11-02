<?php

use App\Http\Controllers\UserController;

//Users
Route::prefix('users')->group(function () {
    Route::get('', [UserController::class, 'index'])->name('users.index');
    Route::get('/create', [UserController::class, 'create'])->name('users.create');
    Route::post('', [UserController::class, 'store'])->name('users.store');
    Route::get('/{id}', [UserController::class, 'show'])->name('users.show');
    Route::get('/{id}/edit', [UserController::class, 'edit'])->name('users.edit');
    Route::put('/{id}', [UserController::class, 'update'])->name('users.update');
    Route::delete('/{id}', [UserController::class, 'destroy'])->name('users.destroy');
    Route::get('/filter/{array_dados}', [UserController::class, 'filter'])->name('users.filter');

    Route::post('/uploadavatar', [UserController::class, 'uploadavatar'])->name('users.uploadavatar');
    Route::post('/editpassword', [UserController::class, 'editpassword'])->name('users.editpassword');
    Route::post('/editemail', [UserController::class, 'editemail'])->name('users.editemail');

    Route::put('/editmodestyle/{mode}/{style}/{id}', [UserController::class, 'editmodestyle'])->name('users.editmodestyle');

    Route::get('/escolher_empresa/{empresa_id}', [UserController::class, 'escolher_empresa'])->name('users.escolher_empresa');
});

Route::get('/profiledata', [UserController::class, 'profiledata']);
