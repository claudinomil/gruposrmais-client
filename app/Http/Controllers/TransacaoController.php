<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class TransacaoController extends Controller
{
    //Variaveis de Retorno da API
    public $message;
    public $code;
    public $validation;
    public $content;

    public function __construct()
    {
        $this->middleware('check-permissao:transacoes_list', ['only' => ['index', 'search']]);
    }

    public function index(Request $request)
    {
        //Requisição Ajax
        if ($request->ajax()) {
            //Buscando dados Api_Data() - Lista de Registros
            $this->responseApi(1, 1, 'transacoes', '', '', '', '');

            //Dados recebidos com sucesso
            if ($this->code == 2000) {
                $allData = DataTables::of($this->content)
                    ->addIndexColumn()
                    ->editColumn('date', function ($row) {
                        $date = date('d/m/Y', strtotime($row['date']));
                        $time = $row['time'];

                        $retorno = "<h5 class='text-truncate font-size-14'>".$date."</h5>";
                        $retorno .= "<p class='text-muted mb-0'>".$time."</p>";

                        return $retorno;
                    })
                    ->editColumn('submoduloName', function ($row) {
                        $submodulo = $row['submoduloName'];
                        $operacao = $row['operacaoName'];

                        $retorno = "<h5 class='text-truncate font-size-14'>".$submodulo."</h5>";
                        $retorno .= "<p class='text-muted mb-0'>".$operacao."</p>";

                        return $retorno;
                    })
                    ->escapeColumns([])
                    ->make(true);

                return $allData;
            } else {
                abort(500, 'Erro Interno Transacao');
            }
        } else {
            return view('transacoes.index');
        }
    }

    public function search(Request $request, $field = '', $value = '')
    {
        //Requisição Ajax
        if ($request->ajax()) {
            //Buscando dados Api_Data() - Pesquisar Registros
            $this->responseApi(1, 3, 'transacoes', '', $field, $value, '');

            //Dados recebidos com sucesso
            if ($this->code == 2000) {
                $allData = DataTables::of($this->content)
                    ->addIndexColumn()
                    ->editColumn('date', function ($row) {
                        $date = date('d/m/Y', strtotime($row['date']));
                        $time = $row['time'];

                        $retorno = "<h5 class='text-truncate font-size-14'>".$date."</h5>";
                        $retorno .= "<p class='text-muted mb-0'>".$time."</p>";

                        return $retorno;
                    })
                    ->editColumn('submoduloName', function ($row) {
                        $submodulo = $row['submoduloName'];
                        $operacao = $row['operacaoName'];

                        $retorno = "<h5 class='text-truncate font-size-14'>".$submodulo."</h5>";
                        $retorno .= "<p class='text-muted mb-0'>".$operacao."</p>";

                        return $retorno;
                    })
                    ->escapeColumns([])
                    ->make(true);

                return $allData;
            } else {
                abort(500, 'Erro Interno Transacao');
            }
        } else {
            return view('transacoes.index');
        }
    }
}
