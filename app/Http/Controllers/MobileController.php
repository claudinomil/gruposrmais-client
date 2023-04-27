<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MobileController extends Controller
{
    public function __construct()
    {
        $this->middleware('check-permissao:mobile_list', ['only' => ['index', 'search']]);
        $this->middleware('check-permissao:mobile_create', ['only' => ['create', 'store']]);
        $this->middleware('check-permissao:mobile_show', ['only' => ['show']]);
        $this->middleware('check-permissao:mobile_edit', ['only' => ['edit', 'update']]);
        $this->middleware('check-permissao:mobile_destroy', ['only' => ['destroy']]);
    }

    public function index(Request $request)
    {
        return view('mobile.mobile');
    }
}
