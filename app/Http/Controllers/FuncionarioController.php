<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class FuncionarioController extends Controller
{
    //Variaveis de Retorno da API
    public $message;
    public $code;
    public $validation;
    public $content;

    //Dados Auxiliares
    public $contratacao_tipos;
    public $generos;
    public $estados_civis;
    public $escolaridades;
    public $nacionalidades;
    public $naturalidades;
    public $identidade_orgaos;
    public $identidade_estados;
    public $departamentos;
    public $funcoes;
    public $bancos;

    public function __construct()
    {
        $this->middleware('check-permissao:funcionarios_list', ['only' => ['index', 'search', 'extradata']]);
        $this->middleware('check-permissao:funcionarios_create', ['only' => ['create', 'store']]);
        $this->middleware('check-permissao:funcionarios_show', ['only' => ['show']]);
        $this->middleware('check-permissao:funcionarios_edit', ['only' => ['edit', 'update', 'uploadfoto']]);
        $this->middleware('check-permissao:funcionarios_destroy', ['only' => ['destroy']]);
    }

    public function index(Request $request)
    {
        //Requisição Ajax
        if ($request->ajax()) {
            //Buscando dados Api_Data() - Lista de Registros
            $this->responseApi(1, 1, 'funcionarios', '', '', '', '');

            //Dados recebidos com sucesso
            if ($this->code == 2000) {
                $allData = DataTables::of($this->content)
                    ->addIndexColumn()
                    ->editColumn('foto', function ($row) {
                        $retorno = "<div class='text-center'>";
                        $retorno .= "<img src='".asset($row['foto'])."' alt='' class='img-thumbnail rounded-circle avatar-sm'>";
                        $retorno .= "<br>";
                        $retorno .= "<a href='#' data-bs-toggle='modal' data-bs-target='.modal-funcionario' onclick='funcionarioExtraData(".$row['id'].");'><span class='bg-success badge'><i class='bx bx-user font-size-16 align-middle me-1'></i>Perfil</span></a>";
                        $retorno .= "</div>";

                        return $retorno;
                    })
                    ->editColumn('data_nascimento', function ($row) {
                        if ($row['data_nascimento'] !== null) {
                            $retorno = date('d/m/Y', strtotime($row['data_nascimento']));
                        } else {
                            $retorno = '';
                        }

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
                abort(500, 'Erro Interno Funcionário');
            }
        } else {
            //Buscando dados Api_Data() - Auxiliary Tables (Combobox)
            $this->responseApi(2, 10, 'funcionarios/auxiliary/tables', '', '', '', '');

            return view('funcionarios.index', [
                'contratacao_tipos' => $this->contratacao_tipos,
                'generos' => $this->generos,
                'estados_civis' => $this->estados_civis,
                'escolaridades' => $this->escolaridades,
                'nacionalidades' => $this->nacionalidades,
                'naturalidades' => $this->naturalidades,
                'identidade_orgaos' => $this->identidade_orgaos,
                'identidade_estados' => $this->identidade_estados,
                'departamentos' => $this->departamentos,
                'funcoes' => $this->funcoes,
                'bancos' => $this->bancos,
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
            $this->responseApi(1, 4, 'funcionarios', '', '', '', $request->all());

            //Registro criado com sucesso
            if ($this->code == 2010) {
                return response()->json(['success' => $this->message]);
            } else if ($this->code == 2020) { //Falha na validação dos dados
                return response()->json(['error_validation' => $this->validation]);
            } else {
                abort(500, 'Erro Interno Funcionário');
            }
        }
    }

    public function show(Request $request, $id)
    {
        //Requisição Ajax
        if ($request->ajax()) {
            //Buscando dados Api_Data() - Registro pelo id
            $this->responseApi(1, 2, 'funcionarios', $id, '', '', '');

            //Registro recebido com sucesso
            if ($this->code == 2000) {
                //Preparando Dados para a View
                if ($this->content['data_nascimento'] != '') {
                    $this->content['data_nascimento'] = Carbon::createFromFormat('Y-m-d', substr($this->content['data_nascimento'], 0, 10))->format('d/m/Y');
                }
                if ($this->content['data_admissao'] != '') {
                    $this->content['data_admissao'] = Carbon::createFromFormat('Y-m-d', substr($this->content['data_admissao'], 0, 10))->format('d/m/Y');
                }
                if ($this->content['data_demissao'] != '') {
                    $this->content['data_demissao'] = Carbon::createFromFormat('Y-m-d', substr($this->content['data_demissao'], 0, 10))->format('d/m/Y');
                }
                if ($this->content['data_cadastro'] != '') {
                    $this->content['data_cadastro'] = Carbon::createFromFormat('Y-m-d', substr($this->content['data_cadastro'], 0, 10))->format('d/m/Y');
                }
                if ($this->content['data_afastamento'] != '') {
                    $this->content['data_afastamento'] = Carbon::createFromFormat('Y-m-d', substr($this->content['data_afastamento'], 0, 10))->format('d/m/Y');
                }
                if ($this->content['personal_identidade_data_emissao'] != '') {
                    $this->content['personal_identidade_data_emissao'] = Carbon::createFromFormat('Y-m-d', substr($this->content['personal_identidade_data_emissao'], 0, 10))->format('d/m/Y');
                }
                if ($this->content['professional_identidade_data_emissao'] != '') {
                    $this->content['professional_identidade_data_emissao'] = Carbon::createFromFormat('Y-m-d', substr($this->content['professional_identidade_data_emissao'], 0, 10))->format('d/m/Y');
                }

                return response()->json(['success' => $this->content]);
            } else if ($this->code == 4040) { //Registro não encontrado
                return response()->json(['error_not_found' => $this->message]);
            } else {
                abort(500, 'Erro Interno Funcionário');
            }
        }
    }

    public function edit(Request $request, $id)
    {
        //Requisição Ajax
        if ($request->ajax()) {
            //Buscando dados Api_Data() - Registro pelo id
            $this->responseApi(1, 2, 'funcionarios', $id, '', '', '');

            //Registro recebido com sucesso
            if ($this->code == 2000) {
                //Preparando Dados para a View
                if ($this->content['data_nascimento'] != '') {
                    $this->content['data_nascimento'] = Carbon::createFromFormat('Y-m-d', substr($this->content['data_nascimento'], 0, 10))->format('d/m/Y');
                }
                if ($this->content['data_admissao'] != '') {
                    $this->content['data_admissao'] = Carbon::createFromFormat('Y-m-d', substr($this->content['data_admissao'], 0, 10))->format('d/m/Y');
                }
                if ($this->content['data_demissao'] != '') {
                    $this->content['data_demissao'] = Carbon::createFromFormat('Y-m-d', substr($this->content['data_demissao'], 0, 10))->format('d/m/Y');
                }
                if ($this->content['data_cadastro'] != '') {
                    $this->content['data_cadastro'] = Carbon::createFromFormat('Y-m-d', substr($this->content['data_cadastro'], 0, 10))->format('d/m/Y');
                }
                if ($this->content['data_afastamento'] != '') {
                    $this->content['data_afastamento'] = Carbon::createFromFormat('Y-m-d', substr($this->content['data_afastamento'], 0, 10))->format('d/m/Y');
                }
                if ($this->content['personal_identidade_data_emissao'] != '') {
                    $this->content['personal_identidade_data_emissao'] = Carbon::createFromFormat('Y-m-d', substr($this->content['personal_identidade_data_emissao'], 0, 10))->format('d/m/Y');
                }
                if ($this->content['professional_identidade_data_emissao'] != '') {
                    $this->content['professional_identidade_data_emissao'] = Carbon::createFromFormat('Y-m-d', substr($this->content['professional_identidade_data_emissao'], 0, 10))->format('d/m/Y');
                }

                return response()->json(['success' => $this->content]);
            } else if ($this->code == 4040) { //Registro não encontrado
                return response()->json(['error_not_found' => $this->message]);
            } else {
                abort(500, 'Erro Interno Funcionário');
            }
        }
    }

    public function update(Request $request, $id)
    {
        //Requisição Ajax
        if ($request->ajax()) {
            //Buscando dados Api_Data() - Alterar Registro
            $this->responseApi(1, 5, 'funcionarios', $id, '', '', $request->all());

            //Registro alterado com sucesso
            if ($this->code == 2000) {
                return response()->json(['success' => $this->message]);
            } else if ($this->code == 2020) { //Falha na validação dos dados
                return response()->json(['error_validation' => $this->validation]);
            } else if ($this->code == 4040) { //Registro não encontrado
                return response()->json(['error_not_found' => $this->message]);
            } else {
                abort(500, 'Erro Interno Funcionário');
            }
        }
    }

    public function destroy(Request $request, $id)
    {
        //Requisição Ajax
        if ($request->ajax()) {
            //Buscando dados Api_Data() - Deletar Registro
            $this->responseApi(1, 6, 'funcionarios', $id, '', '', '');

            //Registro deletado com sucesso
            if ($this->code == 2000) {
                return response()->json(['success' => $this->message]);
            } else if ($this->code == 2040) { //Registro não excluído - pertence a relacionamento com outra(s) tabela(s)
                return response()->json(['error' => $this->message]);
            } else if ($this->code == 4040) { //Registro não encontrado
                return response()->json(['error' => $this->message]);
            } else {
                abort(500, 'Erro Interno Funcionário');
            }
        }
    }

    public function search(Request $request, $field = '', $value = '')
    {
        //Requisição Ajax
        if ($request->ajax()) {
            //Buscando dados Api_Data() - Pesquisar Registros
            $this->responseApi(1, 3, 'funcionarios', '', $field, $value, '');

            //Dados recebidos com sucesso
            if ($this->code == 2000) {
                $allData = DataTables::of($this->content)
                    ->addIndexColumn()
                    ->editColumn('foto', function ($row) {
                        $retorno = "<div class='text-center'>";
                        $retorno .= "<img src='".asset($row['foto'])."' alt='' class='img-thumbnail rounded-circle avatar-sm'>";
                        $retorno .= "<br>";
                        $retorno .= "<a href='#' data-bs-toggle='modal' data-bs-target='.modal-funcionario' onclick='funcionarioExtraData(".$row['id'].");'><span class='bg-success badge'><i class='bx bx-user font-size-16 align-middle me-1'></i>Perfil</span></a>";
                        $retorno .= "</div>";

                        return $retorno;
                    })
                    ->editColumn('data_nascimento', function ($row) {
                        if ($row['data_nascimento'] !== null) {
                            $retorno = date('d/m/Y', strtotime($row['data_nascimento']));
                        } else {
                            $retorno = '';
                        }

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
                abort(500, 'Erro Interno Funcionário');
            }
        } else {
            return view('funcionarios.index');
        }
    }

    public function uploadfoto(Request $request)
    {
        //Requisição Ajax
        if ($request->ajax()) {
            //Variavel controle
            $error = false;

            //Foto padrão do Sistema
            $foto = "build/assets/images/funcionarios/funcionario-0.png";

            //Verificando e fazendo Upload da Foto novo
            if ($request->hasFile('funcionario_extra_foto_file')) {
                //funcionario_id
                $id = $request['upload_funcionario_extra_foto_funcionario_id'];

                //buscar dados formulario
                $arquivo_tmp = $_FILES["funcionario_extra_foto_file"]["tmp_name"];
                $arquivo_real = $_FILES["funcionario_extra_foto_file"]["name"];
                $arquivo_real = utf8_decode($arquivo_real);
                $arquivo_type = $_FILES["funcionario_extra_foto_file"]["type"];
                $arquivo_size = $_FILES['funcionario_extra_foto_file']['size'];

                if ($arquivo_type == 'image/jpg' or $arquivo_type == 'image/jpeg' or $arquivo_type == 'image/png') {
                    if (copy($arquivo_tmp, "build/assets/images/funcionarios/$arquivo_real")) {
                        if (file_exists("build/assets/images/funcionarios/" . $arquivo_real)) {
                            //apagar foto no diretorio
                            if (file_exists('build/assets/images/funcionarios/funcionario-' . $id . '.png')) {
                                unlink('build/assets/images/funcionarios/funcionario-' . $id . '.png');
                            }
                            if (file_exists('build/assets/images/funcionarios/funcionario-' . $id . '.jpg')) {
                                unlink('build/assets/images/funcionarios/funcionario-' . $id . '.jpg');
                            }
                            if (file_exists('build/assets/images/funcionarios/funcionario-' . $id . '.jpeg')) {
                                unlink('build/assets/images/funcionarios/funcionario-' . $id . '.jpeg');
                            }

                            //Gravar novo
                            $foto = "build/assets/images/funcionarios/funcionario-" . $id . '.' . pathinfo($arquivo_real, PATHINFO_EXTENSION);
                            $de = "build/assets/images/funcionarios/$arquivo_real";
                            $pa = $foto;

                            try {
                                rename($de, $pa);
                            } catch (\Exception $e) {
                                $error = true;
                            }
                        }
                    }
                }
            }

            if (!$error) {
                //Buscando dados Api_Data() - Alterar Registro
                $data = array();
                $data['foto'] = $foto;
                $this->responseApi(1, 11, 'funcionarios/updatefoto/' . $id, '', '', '', $data);

                echo $this->message;
            } else {
                echo 'Imagem (Nome, Tamanho ou Tipo) inválida.';
            }
        }
    }

    public function extradata(Request $request, $id)
    {
        //Requisição Ajax
        if ($request->ajax()) {
            //Buscando dados Api_Data() - Registro pelo id
            $this->responseApi(1, 10, 'funcionarios/extradata/' . $id, '', '', '', '');

            //Registro recebido com sucesso
            if ($this->code == 2000) {
                return json_encode($this->content);
            } else if ($this->code == 4040) { //Registro não encontrado
                echo 'Registro não encontrado.';
            } else {
                echo 'Erro Interno Funcionários.';
            }
        }
    }
}
