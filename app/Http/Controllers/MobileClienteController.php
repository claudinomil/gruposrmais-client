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

    //Dados Auxiliares
    public $principal_clientes;
    public $responsavel_funcionarios;
    public $generos;
    public $bancos;
    public $identidade_orgaos;
    public $identidade_estados;
    public $edificacao_classificacoes;
    public $incendio_riscos;
    public $seguranca_medidas;

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
                $allData = DataTables::of($this->content)
                    ->addIndexColumn()
                    ->editColumn('foto', function ($row) {
                        $retorno = "<div class='text-center'>";
                        $retorno .= "<img src='".asset($row['foto'])."' alt='' class='img-thumbnail rounded-circle avatar-sm'>";
                        $retorno .= "<br>";
                        $retorno .= "<a href='#' data-bs-toggle='modal' data-bs-target='.modal-cliente' onclick='clienteExtraData(".$row['id'].");'><span class='bg-success badge'><i class='bx bx-user font-size-16 align-middle me-1'></i>Perfil</span></a>";
                        $retorno .= "</div>";

                        return $retorno;
                    })
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
            //Buscando dados Api_Data() - Auxiliary Tables (Combobox)
            $this->responseApi(2, 10, 'clientes/auxiliary/tables', '', '', '', '');

            return view('mobile.mobile-clientes', [
                'principal_clientes' => $this->principal_clientes,
                'responsavel_funcionarios' => $this->responsavel_funcionarios,
                'generos' => $this->generos,
                'bancos' => $this->bancos,
                'identidade_orgaos' => $this->identidade_orgaos,
                'identidade_estados' => $this->identidade_estados,
                'edificacao_classificacoes' => $this->edificacao_classificacoes,
                'incendio_riscos' => $this->incendio_riscos,
                'seguranca_medidas' => $this->seguranca_medidas
            ]);
        }
    }
}
