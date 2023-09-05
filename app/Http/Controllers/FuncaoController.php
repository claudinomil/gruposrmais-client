<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class FuncaoController extends Controller
{
    //Variaveis de Retorno da API
    public $message;
    public $code;
    public $validation;
    public $content;

    public function __construct()
    {
        $this->middleware('check-permissao:funcoes_list', ['only' => ['index', 'search']]);
        $this->middleware('check-permissao:funcoes_create', ['only' => ['create', 'store']]);
        $this->middleware('check-permissao:funcoes_show', ['only' => ['show']]);
        $this->middleware('check-permissao:funcoes_edit', ['only' => ['edit', 'update']]);
        $this->middleware('check-permissao:funcoes_destroy', ['only' => ['destroy']]);
    }

    public function index(Request $request)
    {
        //Requisição Ajax
        if ($request->ajax()) {
            //Buscando dados Api_Data() - Lista de Registros
            $this->responseApi(1, 1, 'funcoes', '', '', '', '');

            //Dados recebidos com sucesso
            if ($this->code == 2000) {
                $allData = DataTables::of($this->content)
                    ->addIndexColumn()
                    ->addColumn('action', function ($row, Request $request) {
                        //Se a Função for "BRIGADISTA" : Somente Visualização
                        if ($row['id'] == 1) {
                            return '';
                        } else {
                            return $this->columnAction($row['id'], $request['ajaxPrefixPermissaoSubmodulo'], $request['userLoggedPermissoes']);
                        }
                    })
                    ->rawColumns(['action'])
                    ->escapeColumns([])
                    ->make(true);

                return $allData;
            } else {
                abort(500, 'Erro Interno Função');
            }
        } else {
            return view('funcoes.index');
        }
    }

    public function create(Request $request)
    {
        //Requisição Ajax
        if ($request->ajax()) {
            return response()->json(['success' => true]);
        }
    }

    public function store(Request $request)
    {
        //Requisição Ajax
        if ($request->ajax()) {
            //Buscando dados Api_Data() - Incluir Registro
            $this->responseApi(1, 4, 'funcoes', '', '', '', $request->all());

            //Registro criado com sucesso
            if ($this->code == 2010) {
                return response()->json(['success' => $this->message]);
            } else if ($this->code == 2020) { //Falha na validação dos dados
                return response()->json(['error_validation' => $this->validation]);
            } else {
                abort(500, 'Erro Interno Função');
            }
        }
    }

    public function show(Request $request, $id)
    {
        //Requisição Ajax
        if ($request->ajax()) {
            //Buscando dados Api_Data() - Registro pelo id
            $this->responseApi(1, 2, 'funcoes', $id, '', '', '');

            //Registro recebido com sucesso
            if ($this->code == 2000) {
                return response()->json(['success' => $this->content]);
            } else if ($this->code == 4040) { //Registro não encontrado
                return response()->json(['error_not_found' => $this->message]);
            } else {
                abort(500, 'Erro Interno Função');
            }
        }
    }

    public function edit(Request $request, $id)
    {
        //Requisição Ajax
        if ($request->ajax()) {
            //Se a Função for "BRIGADISTA" : Somente Visualização
            if ($id == 1) {
                return response()->json(['error_not_found' => 'Registro bloqueado.']);
            }

            //Buscando dados Api_Data() - Registro pelo id
            $this->responseApi(1, 2, 'funcoes', $id, '', '', '');

            //Registro recebido com sucesso
            if ($this->code == 2000) {
                return response()->json(['success' => $this->content]);
            } else if ($this->code == 4040) { //Registro não encontrado
                return response()->json(['error_not_found' => $this->message]);
            } else {
                abort(500, 'Erro Interno Função');
            }
        }
    }

    public function update(Request $request, $id)
    {
        //Requisição Ajax
        if ($request->ajax()) {
            //Se a Função for "BRIGADISTA" : Somente Visualização
            if ($id == 1) {
                return response()->json(['error_not_found' => 'Registro bloqueado.']);
            }

            //Buscando dados Api_Data() - Alterar Registro
            $this->responseApi(1, 5, 'funcoes', $id, '', '', $request->all());

            //Registro alterado com sucesso
            if ($this->code == 2000) {
                return response()->json(['success' => $this->message]);
            } else if ($this->code == 2020) { //Falha na validação dos dados
                return response()->json(['error_validation' => $this->validation]);
            } else if ($this->code == 4040) { //Registro não encontrado
                return response()->json(['error_not_found' => $this->message]);
            } else {
                abort(500, 'Erro Interno Função');
            }
        }
    }

    public function destroy(Request $request, $id)
    {
        //Requisição Ajax
        if ($request->ajax()) {
            //Se a Função for "BRIGADISTA" : Somente Visualização
            if ($id == 1) {
                return response()->json(['error_not_found' => 'Registro bloqueado.']);
            }

            //Buscando dados Api_Data() - Deletar Registro
            $this->responseApi(1, 6, 'funcoes', $id, '', '', '');

            //Registro deletado com sucesso
            if ($this->code == 2000) {
                return response()->json(['success' => $this->message]);
            } else if ($this->code == 2040) { //Registro não excluído - pertence a relacionamento com outra(s) tabela(s)
                return response()->json(['error' => $this->message]);
            } else if ($this->code == 4040) { //Registro não encontrado
                return response()->json(['error' => $this->message]);
            } else {
                abort(500, 'Erro Interno Função');
            }
        }
    }

    public function search(Request $request, $field = '', $value = '')
    {
        //Requisição Ajax
        if ($request->ajax()) {
            //Buscando dados Api_Data() - Pesquisar Registros
            $this->responseApi(1, 3, 'funcoes', '', $field, $value, '');

            //Dados recebidos com sucesso
            if ($this->code == 2000) {
                $allData = DataTables::of($this->content)
                    ->addIndexColumn()
                    ->addColumn('action', function ($row, Request $request) {
                        //Se a Função for "BRIGADISTA" : Somente Visualização
                        if ($row['id'] == 1) {
                            return '';
                        } else {
                            return $this->columnAction($row['id'], $request['ajaxPrefixPermissaoSubmodulo'], $request['userLoggedPermissoes']);
                        }
                    })
                    ->rawColumns(['action'])
                    ->escapeColumns([])
                    ->make(true);

                return $allData;
            } else {
                abort(500, 'Erro Interno Função');
            }
        } else {
            return view('funcoes.index');
        }
    }
}
