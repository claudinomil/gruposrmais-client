<?php
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\APAGARPasswordResetLinkController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ConfirmEmailController;

//Sem estar Logado''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
Route::get('login', [LoginController::class, 'login'])->name('login');
Route::post('login', [LoginController::class, 'loginApi']);

//Route::get('forgot-password', [PasswordResetLinkController::class, 'create'])->name('password.request');
//Route::post('forgot-password', [PasswordResetLinkController::class, 'store'])->name('password.email');

Route::get('forget-password', [ForgotPasswordController::class, 'showForgetPasswordForm'])->name('forget.password.get');
Route::post('forget-password', [ForgotPasswordController::class, 'submitForgetPasswordForm'])->name('forget.password.post');
Route::get('reset-password/{token}', [ForgotPasswordController::class, 'showResetPasswordForm'])->name('reset.password.get');
Route::post('reset-password', [ForgotPasswordController::class, 'submitResetPasswordForm'])->name('reset.password.post');

Route::get('confirm-email', [ConfirmEmailController::class, 'showConfirmEmailForm'])->name('confirm.email.get');
Route::post('confirm-email', [ConfirmEmailController::class, 'submitConfirmEmailForm'])->name('confirm.email.post');
Route::get('code-confirm-email/{email}', [ConfirmEmailController::class, 'showCodeConfirmEmaildForm'])->name('code.confirm.email.get');
Route::post('code-confirm-email', [ConfirmEmailController::class, 'submitCodeConfirmEmailForm'])->name('code.confirm.email.post');
//''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''

//Logado''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''

//Logout
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

//''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
