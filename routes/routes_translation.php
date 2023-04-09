<?php

//Language Translation
use Illuminate\Support\Facades\Session;

Route::get('/change-language/{locale}', function ($locale) {
    if ($locale) {
        \Illuminate\Support\Facades\App::setLocale($locale);

        Session::put('lang', $locale);
        Session::save();

        return redirect()->back()->with('locale', $locale);
    } else {
        return redirect()->back();
    }
});
