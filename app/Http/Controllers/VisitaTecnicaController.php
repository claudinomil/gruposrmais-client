<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class VisitaTecnicaController extends Controller
{
    //Variaveis de Retorno da API
    public $message;
    public $code;
    public $validation;
    public $content;

    //Dados Auxiliares

    public function __construct()
    {
        $this->middleware('check-permissao:visitas_tecnicas_list', ['only' => ['index', 'filter']]);
        $this->middleware('check-permissao:visitas_tecnicas_show', ['only' => ['show']]);
        $this->middleware('check-permissao:visitas_tecnicas_edit', ['only' => ['edit', 'update']]);
    }

    public function index(Request $request)
    {
        //Requisição Ajax
        if ($request->ajax()) {
            //Buscando dados Api_Data() - Lista de Registros
            $this->responseApi(1, 1, 'visitas_tecnicas', '', '', '');

            //Dados recebidos com sucesso
            if ($this->code == 2000) {
                $allData = DataTables::of($this->content)
                    ->addIndexColumn()
                    ->addColumn('action', function ($row, Request $request) {
                        //Se servico_status_id for igual a 1(EXECUTADO) : Somente Visualização
                        if ($row['servico_status_id'] == 1) {
                            $botoes = 1;
                        } else {
                            //Se servico_status_id for diferente de 1(EXECUTADO) : Visualização e Alteração
                            $botoes = 4;
                        }

                        return $this->columnAction($row['id'], $request['ajaxPrefixPermissaoSubmodulo'], $request['userLoggedPermissoes'], $botoes);
                    })
                    ->rawColumns(['action'])
                    ->escapeColumns([])
                    ->make(true);

                return $allData;
            } else {
                abort(500, 'Erro Interno Visita Técnica');
            }
        } else {
            //pegando o empresa_id
            $empresa_id = session('userLogged_empresa_id');

            //Buscando dados Api_Data() - Auxiliary Tables (Combobox)
            $this->responseApi(2, 10, 'visitas_tecnicas/auxiliary/tables/'.$empresa_id, '', '', '');

            return view('visitas_tecnicas.index');
        }
    }

    public function show(Request $request, $id)
    {
        //Requisição Ajax
        if ($request->ajax()) {
            //Buscando dados Api_Data() - Registro pelo id
            $this->responseApi(1, 2, 'visitas_tecnicas', $id, '', '');

            //Registro recebido com sucesso
            if ($this->code == 2000) {
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
            $this->responseApi(1, 2, 'visitas_tecnicas', $id, '', '');

            //Registro recebido com sucesso
            if ($this->code == 2000) {
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
            $this->responseApi(1, 5, 'visitas_tecnicas', $id, '', $request->all());

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

    public function filter(Request $request, $array_dados)
    {
        //Requisição Ajax
        if ($request->ajax()) {
            //Buscando dados Api_Data() - Pesquisar Registros
            $this->responseApi(1, 3, 'visitas_tecnicas', '', $array_dados, '');

            //Dados recebidos com sucesso
            if ($this->code == 2000) {
                $allData = DataTables::of($this->content)
                    ->addIndexColumn()
                    ->addColumn('action', function ($row, Request $request) {
                        return $this->columnAction($row['id'], $request['ajaxPrefixPermissaoSubmodulo'], $request['userLoggedPermissoes'], 4);
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

    public function medidas_seguranca(Request $request, $np, $atc, $grupo, $divisao)
    {
        //Requisição Ajax
        if ($request->ajax()) {
            //Buscando dados Api_Data()
            $this->responseApi(1, 10, 'visitas_tecnicas/medidas_seguranca/'.$np.'/'.$atc.'/'.$grupo.'/'.$divisao, '', '', '');

            //Registro
            if ($this->code == 2000) {
                return response()->json(['success' => $this->content]);
            } else {
                abort(500, 'Erro Interno Visita Técnica');
            }
        }
    }

    public function documentos_upload(Request $request, $file)
    {
        //Requisição Ajax
        if ($request->ajax()) {
            //Variavel controle
            $error = true;
            $message = 'Erro: Upload não realizado, tente novamente.';

            //Verificando se foi selecionado um arquivo
            if ($request->hasFile($file)) {
                //pegando id do registro
                $id = $request['registro_id'];

                //buscar dados formulario
                $arquivo_tmp = $_FILES[$file]['tmp_name'];
                $arquivo_real = $_FILES[$file]['name'];
                $arquivo_real = utf8_decode($arquivo_real);
                $arquivo_type = $_FILES[$file]['type'];
                $arquivo_size = $_FILES[$file]['size'];

                //verificando se o arquivo selecionado é um pdf
                if ($arquivo_type == 'application/pdf') {
                    //copiando arquivo selecionado
                    if (copy($arquivo_tmp, "build/assets/pdfs/visitas_tecnicas/$arquivo_real")) {
                        //confirmar se realmente foi copiado para a pasto
                        if (file_exists("build/assets/pdfs/visitas_tecnicas/" . $arquivo_real)) {
                            //renomear para nome $file_$id
                            $pdf = "build/assets/pdfs/visitas_tecnicas/".$file.'_'.$id.'.'.pathinfo($arquivo_real, PATHINFO_EXTENSION);
                            $de = "build/assets/pdfs/visitas_tecnicas/$arquivo_real";
                            $pa = $pdf;

                            rename($de, $pa);

                            //confirmar se realmente foi renomeado
                            if (file_exists($pdf)) {
                                $error = false;
                                $message = 'Upload realizado com sucesso.';
                            }
                        }
                    }
                } else {
                    $message = 'Erro: Arquivo não é PDF';
                }
            } else {
                $message = 'Erro: Escolha um arquivo PDF';
            }

            //Retornar
            echo $message;
        }
    }
}
