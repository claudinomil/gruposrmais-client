<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use Yajra\DataTables\Facades\DataTables;

class MobileVisitaTecnicaController extends Controller
{
    //Variaveis de Retorno da API
    public $message;
    public $code;
    public $validation;
    public $content;

    //Dados Auxiliares
    public $visita_tecnica_status;
    public $clientes;
    public $funcionarios;

    public function __construct()
    {
        $this->middleware('check-permissao:mobile_visitas_tecnicas_list', ['only' => ['index', 'search']]);
        $this->middleware('check-permissao:mobile_visitas_tecnicas_create', ['only' => ['create', 'store']]);
        $this->middleware('check-permissao:mobile_visitas_tecnicas_show', ['only' => ['show']]);
        $this->middleware('check-permissao:mobile_visitas_tecnicas_edit', ['only' => ['edit', 'update']]);
    }

    public function index(Request $request)
    {
        //Requisição Ajax
        if ($request->ajax()) {
            //Buscando dados Api_Data() - Lista de Registros
            $this->responseApi(1, 1, 'visitas_tecnicas', '', '', '', '');

            //Dados recebidos com sucesso
            if ($this->code == 2000) {
                //Montar Dados Tabela
                $allData = DataTables::of($this->content)
                    ->addIndexColumn()
                    ->editColumn('data_visita', function ($row) {
                        if ($row['data_visita'] !== null) {
                            $retorno = date('d/m/Y', strtotime($row['data_visita']));
                        } else {
                            $retorno = '';
                        }

                        return $retorno;
                    })
                    ->addColumn('action', function ($row, Request $request) {
                        return $this->columnAction($row['id'], $request['userLoggedPermissoes'], 1, 4);
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
                'visita_tecnica_status' => $this->visita_tecnica_status,
                'clientes' => $this->clientes,
                'funcionarios' => $this->funcionarios
            ]);
        }
    }

    public function show(Request $request, $id)
    {
        //Requisição Ajax
        if ($request->ajax()) {
            //Buscando dados Api_Data() - Registro pelo id
            $this->responseApi(1, 2, 'visitas_tecnicas', $id, '', '', '');

            //Registro recebido com sucesso
            if ($this->code == 2000) {
                //Preparando Dados para a View
                if ($this->content['data_visita'] != '') {
                    $this->content['data_visita'] = Carbon::createFromFormat('Y-m-d', substr($this->content['data_visita'], 0, 10))->format('d/m/Y');
                }

                return response()->json(['success' => $this->content]);
            } else if ($this->code == 4040) { //Registro não encontrado
                return response()->json(['error_not_found' => $this->message]);
            } else {
                abort(500, 'Erro Interno Visita Técnica');
            }
        }
    }

    public function edit(Request $request, $id)
    {
        //Requisição Ajax
        if ($request->ajax()) {
            //Buscando dados Api_Data() - Registro pelo id
            $this->responseApi(1, 2, 'visitas_tecnicas', $id, '', '', '');

            //Registro recebido com sucesso
            if ($this->code == 2000) {
                //Preparando Dados para a View
                if ($this->content['data_visita'] != '') {
                    $this->content['data_visita'] = Carbon::createFromFormat('Y-m-d', substr($this->content['data_visita'], 0, 10))->format('d/m/Y');
                }

                return response()->json(['success' => $this->content]);
            } else if ($this->code == 4040) { //Registro não encontrado
                return response()->json(['error_not_found' => $this->message]);
            } else {
                abort(500, 'Erro Interno Visita Técnica');
            }
        }
    }

    public function update(Request $request, $id)
    {
        //Requisição Ajax
        if ($request->ajax()) {
            //Buscando dados Api_Data() - Alterar Registro
            $this->responseApi(1, 5, 'visitas_tecnicas', $id, '', '', $request->all());

            //Registro alterado com sucesso
            if ($this->code == 2000) {
                return response()->json(['success' => $this->message]);
            } else if ($this->code == 2020) { //Falha na validação dos dados
                return response()->json(['error_validation' => $this->validation]);
            } else if ($this->code == 4040) { //Registro não encontrado
                return response()->json(['error_not_found' => $this->message]);
            } else {
                abort(500, 'Erro Interno Visita Técnica');
            }
        }
    }

    public function search(Request $request, $field = '', $value = '')
    {
        //Requisição Ajax
        if ($request->ajax()) {
            //Buscando dados Api_Data() - Pesquisar Registros
            $this->responseApi(1, 3, 'visitas_tecnicas', '', $field, $value, '');

            //Dados recebidos com sucesso
            if ($this->code == 2000) {
                //Montar Dados Tabela
                $allData = DataTables::of($this->content)
                    ->addIndexColumn()
                    ->editColumn('data_visita', function ($row) {
                        if ($row['data_visita'] !== null) {
                            $retorno = date('d/m/Y', strtotime($row['data_visita']));
                        } else {
                            $retorno = '';
                        }

                        return $retorno;
                    })
                    ->addColumn('action', function ($row, Request $request) {
                        return $this->columnAction($row['id'], $request['userLoggedPermissoes'], 1);
                    })
                    ->rawColumns(['action'])
                    ->escapeColumns([])
                    ->make(true);

                return $allData;
            } else {
                abort(500, 'Erro Interno Visita Técnica');
            }
        } else {
            return view('visitas_tecnicas.index');
        }
    }
}
