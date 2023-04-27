<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MobileController extends Controller
{
    public function __construct()
    {
        $this->middleware('check-permissao:bancos_list', ['only' => ['index', 'search']]);
        $this->middleware('check-permissao:bancos_create', ['only' => ['create', 'store']]);
        $this->middleware('check-permissao:bancos_show', ['only' => ['show']]);
        $this->middleware('check-permissao:bancos_edit', ['only' => ['edit', 'update']]);
        $this->middleware('check-permissao:bancos_destroy', ['only' => ['destroy']]);
    }

    public function index(Request $request)
    {
        return view('mobile.app-mobile');
    }
}
