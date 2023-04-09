<?php

use App\Http\Controllers\DashboardController;

//Dashboards
Route::prefix('dashboards')->group(function () {
    Route::get('', [DashboardController::class, 'index'])->name('dashboards.index');
});
