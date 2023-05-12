<?php

namespace App\Http\Controllers;

class MobileController extends Controller
{
    public function __construct()
    {
        $this->middleware('check-permissao:home_list', ['only' => ['index']]);  //Coloquei home_list só para liberar a Middlewarw
    }
    public function index()
    {
        return view('Mobile.Mobile');
    }
}
