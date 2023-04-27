<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class MobileVisitaTecnicaController extends Controller
{
    //Variaveis de Retorno da API
    public $message;
    public $code;
    public $validation;
    public $content;

    //Dados Auxiliares
    public $clientes;
    public $edificacao_classificacoes;
    public $incendio_riscos;
    public $seguranca_medidas;

    public function __construct()
    {
        $this->middleware('check-permissao:mobile_visitas_tecnicas_list', ['only' => ['index', 'search']]);
        $this->middleware('check-permissao:mobile_visitas_tecnicas_create', ['only' => ['create', 'store']]);
        $this->middleware('check-permissao:mobile_visitas_tecnicas_show', ['only' => ['show']]);
        $this->middleware('check-permissao:mobile_visitas_tecnicas_edit', ['only' => ['edit', 'update']]);
        $this->middleware('check-permissao:mobile_visitas_tecnicas_destroy', ['only' => ['destroy']]);
    }

    public function index(Request $request)
    {
        //Requisição Ajax
        if ($request->ajax()) {
            //Buscando dados Api_Data() - Lista de Registros
            $this->responseApi(1, 1, 'visitas_tecnicas', '', '', '', '');

            //Dados recebidos com sucesso
            if ($this->code == 2000) {
                $allData = DataTables::of($this->content)
                    ->addIndexColumn()
                    ->editColumn('data_visita', function ($row) {
                        $retorno = date('d/m/Y', strtotime($row['data_visita']));

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
                abort(500, 'Erro Interno Visita Técnica');
            }
        } else {
            //Buscando dados Api_Data() - Auxiliary Tables (Combobox)
            $this->responseApi(2, 10, 'visitas_tecnicas/auxiliary/tables', '', '', '', '');

            return view('mobile.mobile-visitas-tecnicas', [
                'clientes' => $this->clientes,
                'edificacao_classificacoes' => $this->edificacao_classificacoes,
                'incendio_riscos' => $this->incendio_riscos,
                'seguranca_medidas' => $this->seguranca_medidas
            ]);
        }
    }
}
