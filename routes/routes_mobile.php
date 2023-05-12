<?php

use App\Http\Controllers\MobileController;

//Mobile
Route::prefix('Mobile')->group(function () {
    Route::get('', [MobileController::class, 'index'])->name('Mobile.index');
});
