<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class MobileClienteController extends Controller
{
    //Variaveis de Retorno da API
    public $message;
    public $code;
    public $validation;
    public $content;

    public function __construct()
    {
        $this->middleware('check-permissao:mobile_clientes_list', ['only' => ['index', 'search']]);
        $this->middleware('check-permissao:mobile_clientes_create', ['only' => ['create', 'store']]);
        $this->middleware('check-permissao:mobile_clientes_show', ['only' => ['show']]);
        $this->middleware('check-permissao:mobile_clientes_edit', ['only' => ['edit', 'update']]);
        $this->middleware('check-permissao:mobile_clientes_destroy', ['only' => ['destroy']]);
    }

    public function index(Request $request)
    {
        //Requisição Ajax
        if ($request->ajax()) {
            //Buscando dados Api_Data() - Lista de Registros
            $this->responseApi(1, 1, 'clientes', '', '', '', '');

            //Dados recebidos com sucesso
            if ($this->code == 2000) {
                //Montar Dados Tabela
                $allData = DataTables::of($this->content)
                    ->addIndexColumn()
                    ->addColumn('action', function ($row, Request $request) {
                        return $this->columnAction($row['id'], $request['userLoggedPermissoes']);
                    })
                    ->rawColumns(['action'])
                    ->escapeColumns([])
                    ->make(true);

                return $allData;
            } else {
                abort(500, 'Erro Interno Client');
            }
        } else {
            return view('mobile.mobile-clientes', [
                'evento' => 'index'
            ]);
        }
    }
}
