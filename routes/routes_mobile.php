<?php

use App\Http\Controllers\MobileController;

//Mobile
Route::prefix('mobile')->group(function () {
    Route::get('', [MobileController::class, 'index'])->name('mobiles.index');
    Route::get('/create', [MobileController::class, 'create'])->name('mobiles.create');
    Route::post('', [MobileController::class, 'store'])->name('mobiles.store');
    Route::get('/{id}', [MobileController::class, 'show'])->name('mobiles.show');
    Route::get('/{id}/edit', [MobileController::class, 'edit'])->name('mobiles.edit');
    Route::put('/{id}', [MobileController::class, 'update'])->name('mobiles.update');
    Route::delete('/{id}', [MobileController::class, 'destroy'])->name('mobiles.destroy');
    Route::get('/search/{field}/{value}', [MobileController::class, 'search'])->name('mobiles.search');
});
