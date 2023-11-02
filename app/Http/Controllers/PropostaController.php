<?php

namespace App\Http\Controllers;

use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class PropostaController extends Controller
{
    //Variaveis de Retorno da API
    public $message;
    public $code;
    public $validation;
    public $content;

    //Dados Auxiliares
    public $clientes;
    public $servicos;

    public function __construct()
    {
        $this->middleware('check-permissao:propostas_list', ['only' => ['index', 'filter']]);
        $this->middleware('check-permissao:propostas_create', ['only' => ['create', 'store']]);
        $this->middleware('check-permissao:propostas_show', ['only' => ['show']]);
        $this->middleware('check-permissao:propostas_edit', ['only' => ['edit', 'update']]);
        $this->middleware('check-permissao:propostas_destroy', ['only' => ['destroy']]);
    }

    public function index(Request $request)
    {
        //Requisição Ajax
        if ($request->ajax()) {
            //Buscando dados Api_Data() - Lista de Registros
            $this->responseApi(1, 1, 'propostas', '', '', '');

            //Dados recebidos com sucesso
            if ($this->code == 2000) {
                $allData = DataTables::of($this->content)
                    ->addIndexColumn()
                    ->addColumn('action', function ($row, Request $request) {
                        return $this->columnAction($row['id'], $request['ajaxPrefixPermissaoSubmodulo'], $request['userLoggedPermissoes']);
                    })
                    ->editColumn('numero_proposta', function ($row) {
                        $retorno = "<div>";
                        $retorno .= "<a href='propostas/gerar_pdf/proposta/".$row['id']."' target='_blank' title='Visualizar Proposta nº. ".$row['numero_proposta']."\\".$row['ano_proposta']."'><i class='fa fa-file-pdf fa-2x'></i></a>";
                        $retorno .= "&nbsp;&nbsp;Proposta nº.&nbsp;".$row['numero_proposta']."/".$row['ano_proposta'];
                        $retorno .= "</div>";

                        return $retorno;
                    })
                    ->rawColumns(['action'])
                    ->escapeColumns([])
                    ->make(true);

                return $allData;
            } else {
                abort(500, 'Erro Interno Client');
            }
        } else {
            //pegando o empresa_id
            $empresa_id = session('userLogged_empresa_id');

            //Buscando dados Api_Data() - Auxiliary Tables (Combobox)
            $this->responseApi(2, 10, 'propostas/auxiliary/tables/'.$empresa_id, '', '', '');

            return view('propostas.index', [
                'clientes' => $this->clientes,
                'servicos' => $this->servicos,
            ]);
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
            $this->responseApi(1, 4, 'propostas', '', '', $request->all());

            //Registro criado com sucesso
            if ($this->code == 2010) {
                return response()->json(['success' => $this->message]);
            } else if ($this->code == 2020) { //Falha na validação dos dados
                return response()->json(['error_validation' => $this->validation]);
            } else {
                abort(500, 'Erro Interno Client');
            }
        }
    }

    public function show(Request $request, $id)
    {
        //Requisição Ajax
        if ($request->ajax()) {
            //Buscando dados Api_Data() - Registro pelo id
            $this->responseApi(1, 2, 'propostas', $id, '', '');

            //Registro recebido com sucesso
            if ($this->code == 2000) {
                //Preparando Dados para a View''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
                //data_proposta
                if ($this->content['data_proposta'] != '') {
                    $this->content['data_proposta'] = Carbon::createFromFormat('Y-m-d', substr($this->content['data_proposta'], 0, 10))->format('d/m/Y');
                }

                //porcentagem_desconto
                if ($this->content['porcentagem_desconto'] != '') {
                    $this->content['porcentagem_desconto'] = number_format($this->content['porcentagem_desconto'], 2, ",", ".");
                } else {
                    $this->content['porcentagem_desconto'] = 0;
                }

                //valor_desconto
                if ($this->content['valor_desconto'] != '') {
                    $this->content['valor_desconto'] = number_format($this->content['valor_desconto'], 2, ",", ".");
                } else {
                    $this->content['valor_desconto'] = 0;
                }

                //valor_total
                if ($this->content['valor_total'] != '') {
                    $this->content['valor_total'] = number_format($this->content['valor_total'], 2, ",", ".");
                } else {
                    $this->content['valor_total'] = 0;
                }
                //''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''

                return response()->json(['success' => $this->content]);
            } else if ($this->code == 4040) { //Registro não encontrado
                return response()->json(['error_not_found' => $this->message]);
            } else {
                abort(500, 'Erro Interno Client');
            }
        }
    }

    public function edit(Request $request, $id)
    {
        //Requisição Ajax
        if ($request->ajax()) {
            //Buscando dados Api_Data() - Registro pelo id
            $this->responseApi(1, 2, 'propostas', $id, '', '');

            //Registro recebido com sucesso
            if ($this->code == 2000) {
                //Preparando Dados para a View''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
                //data_proposta
                if ($this->content['data_proposta'] != '') {
                    $this->content['data_proposta'] = Carbon::createFromFormat('Y-m-d', substr($this->content['data_proposta'], 0, 10))->format('d/m/Y');
                }

                //porcentagem_desconto
                if ($this->content['porcentagem_desconto'] != '') {
                    $this->content['porcentagem_desconto'] = number_format($this->content['porcentagem_desconto'], 2, ",", ".");
                } else {
                    $this->content['porcentagem_desconto'] = 0;
                }

                //valor_desconto
                if ($this->content['valor_desconto'] != '') {
                    $this->content['valor_desconto'] = number_format($this->content['valor_desconto'], 2, ",", ".");
                } else {
                    $this->content['valor_desconto'] = 0;
                }

                //valor_total
                if ($this->content['valor_total'] != '') {
                    $this->content['valor_total'] = number_format($this->content['valor_total'], 2, ",", ".");
                } else {
                    $this->content['valor_total'] = 0;
                }
                //''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''

                return response()->json(['success' => $this->content]);
            } else if ($this->code == 4040) { //Registro não encontrado
                return response()->json(['error_not_found' => $this->message]);
            } else {
                abort(500, 'Erro Interno Client');
            }
        }
    }

    public function update(Request $request, $id)
    {
        //Requisição Ajax
        if ($request->ajax()) {
            //Buscando dados Api_Data() - Alterar Registro
            $this->responseApi(1, 5, 'propostas', $id, '', $request->all());

            //Registro alterado com sucesso
            if ($this->code == 2000) {
                return response()->json(['success' => $this->message]);
            } else if ($this->code == 2020) { //Falha na validação dos dados
                return response()->json(['error_validation' => $this->validation]);
            } else if ($this->code == 4040) { //Registro não encontrado
                return response()->json(['error_not_found' => $this->message]);
            } else {
                abort(500, 'Erro Interno Client');
            }
        }
    }

    public function destroy(Request $request, $id)
    {
        //Requisição Ajax
        if ($request->ajax()) {
            //Buscando dados Api_Data() - Deletar Registro
            $this->responseApi(1, 6, 'propostas', $id, '', '');

            //Registro deletado com sucesso
            if ($this->code == 2000) {
                return response()->json(['success' => $this->message]);
            } else if ($this->code == 2040) { //Registro não excluído - pertence a relacionamento com outra(s) tabela(s)
                return response()->json(['error' => $this->message]);
            } else if ($this->code == 4040) { //Registro não encontrado
                return response()->json(['error' => $this->message]);
            } else {
                abort(500, 'Erro Interno Client');
            }
        }
    }

    public function filter(Request $request, $array_dados)
    {
        //Requisição Ajax
        if ($request->ajax()) {
            //Buscando dados Api_Data() - Pesquisar Registros
            $this->responseApi(1, 3, 'propostas', '', $array_dados, '');

            //Dados recebidos com sucesso
            if ($this->code == 2000) {
                $allData = DataTables::of($this->content)
                    ->addIndexColumn()
                    ->addColumn('action', function ($row, Request $request) {
                        return $this->columnAction($row['id'], $request['ajaxPrefixPermissaoSubmodulo'], $request['userLoggedPermissoes']);
                    })
                    ->editColumn('numero_proposta', function ($row) {
                        $retorno = "<div>";
                        $retorno .= "<a href='propostas/gerar_pdf/proposta/".$row['id']."' target='_blank' title='Visualizar Proposta nº. ".$row['numero_proposta']."\\".$row['ano_proposta']."'><i class='fa fa-file-pdf fa-2x'></i></a>";
                        $retorno .= "&nbsp;&nbsp;Proposta nº.&nbsp;".$row['numero_proposta']."/".$row['ano_proposta'];
                        $retorno .= "</div>";

                        return $retorno;
                    })
                    ->rawColumns(['action'])
                    ->escapeColumns([])
                    ->make(true);

                return $allData;
            } else {
                abort(500, 'Erro Interno Client');
            }
        } else {
            return view('propostas.index');
        }
    }

    public function gerar_pdf_proposta($id)
    {
        //Buscando dados Api_Data() - Registro pelo id
        $this->responseApi(1, 2, 'propostas', $id, '', '');

        //Registro recebido com sucesso
        if ($this->code == 2000) {
            //Preparando Dados para a View''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
            //data_proposta
            if ($this->content['data_proposta'] != '') {$this->content['data_proposta'] = Carbon::createFromFormat('Y-m-d', substr($this->content['data_proposta'], 0, 10))->format('d/m/Y');}

            //porcentagem_desconto
            if ($this->content['porcentagem_desconto'] != '') {
                $this->content['porcentagem_desconto'] = number_format($this->content['porcentagem_desconto'], 2, ",", ".");
            } else {
                $this->content['porcentagem_desconto'] = 0;
            }

            //valor_desconto
            if ($this->content['valor_desconto'] != '') {
                $this->content['valor_desconto'] = number_format($this->content['valor_desconto'], 2, ",", ".");
            } else {
                $this->content['valor_desconto'] = 0;
            }

            //valor_total
            if ($this->content['valor_total'] != '') {
                $this->content['valor_total'] = number_format($this->content['valor_total'], 2, ",", ".");
            } else {
                $this->content['valor_total'] = 0;
            }
            //''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''

            $registro = $this->content;

            $pdf = Pdf::loadView('propostas.proposta', compact('registro'));

            return $pdf->stream('proposta_'.$id);
        } else if ($this->code == 4040) { //Registro não encontrado
            $error = $this->message;

            $pdf = Pdf::loadView('propostas.proposta', compact('error'));

            return $pdf->stream('proposta_'.$id);
        } else {
            abort(500, 'Erro Interno Client');
        }
    }
}
