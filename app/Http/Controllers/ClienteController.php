<?php

namespace App\Http\Controllers;

use App\Services\ConsultarSpeedioApi;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Yajra\DataTables\Facades\DataTables;

class ClienteController extends Controller
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
        $this->middleware('check-permissao:clientes_list', ['only' => ['index', 'search', 'extradata']]);
        $this->middleware('check-permissao:clientes_create', ['only' => ['create', 'store']]);
        $this->middleware('check-permissao:clientes_show', ['only' => ['show']]);
        $this->middleware('check-permissao:clientes_edit', ['only' => ['edit', 'update', 'uploadfoto']]);
        $this->middleware('check-permissao:clientes_destroy', ['only' => ['destroy']]);
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
                    ->editColumn('data_nascimento', function ($row) {
                        if ($row['data_nascimento'] !== null) {
                            $retorno = date('d/m/Y', strtotime($row['data_nascimento']));
                        } else {
                            $retorno = '';
                        }

                        return $retorno;
                    })
                    ->addColumn('action', function ($row, Request $request) {
                        return $this->columnAction($row['id'], $request['ajaxPrefixPermissaoSubmodulo'], $request['userLoggedPermissoes']);
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

            //Verificar qual view vai chamar Mobile/Desktop
            if (session('access_device') == 'mobile' or session('access_device') == 'tablet') {
                $view = 'Mobile.Mobile-clientes';
            } else {
                $view = 'clientes.index';
            }

            //chamar view
            return view($view, [
                'evento' => 'index',
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
            //Acerto Request
            if (isset($request['projeto_scip'])) {$request['projeto_scip'] = 1;} else {$request['projeto_scip'] = 0;}
            if (isset($request['laudo_exigencias'])) {$request['laudo_exigencias'] = 1;} else {$request['laudo_exigencias'] = 0;}
            if (isset($request['certificado_aprovacao'])) {$request['certificado_aprovacao'] = 1;} else {$request['certificado_aprovacao'] = 0;}
            if (isset($request['certificado_aprovacao_simplificado'])) {$request['certificado_aprovacao_simplificado'] = 1;} else {$request['certificado_aprovacao_simplificado'] = 0;}
            if (isset($request['certificado_aprovacao_assistido'])) {$request['certificado_aprovacao_assistido'] = 1;} else {$request['certificado_aprovacao_assistido'] = 0;}

            //Buscando dados Api_Data() - Incluir Registro
            $this->responseApi(1, 4, 'clientes', '', '', '', $request->all());

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
            $this->responseApi(1, 2, 'clientes', $id, '', '', '');

            //Registro recebido com sucesso
            if ($this->code == 2000) {
                //Preparando Dados para a View
                if ($this->content['data_nascimento'] != '') {
                    $this->content['data_nascimento'] = Carbon::createFromFormat('Y-m-d', substr($this->content['data_nascimento'], 0, 10))->format('d/m/Y');
                }
                if ($this->content['identidade_data_emissao'] != '') {
                    $this->content['identidade_data_emissao'] = Carbon::createFromFormat('Y-m-d', substr($this->content['identidade_data_emissao'], 0, 10))->format('d/m/Y');
                }

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
            $this->responseApi(1, 2, 'clientes', $id, '', '', '');

            //Registro recebido com sucesso
            if ($this->code == 2000) {
                //Preparando Dados para a View
                if ($this->content['data_nascimento'] != '') {
                    $this->content['data_nascimento'] = Carbon::createFromFormat('Y-m-d', substr($this->content['data_nascimento'], 0, 10))->format('d/m/Y');
                }
                if ($this->content['identidade_data_emissao'] != '') {
                    $this->content['identidade_data_emissao'] = Carbon::createFromFormat('Y-m-d', substr($this->content['identidade_data_emissao'], 0, 10))->format('d/m/Y');
                }

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
            //Acerto Request
            if (isset($request['projeto_scip'])) {$request['projeto_scip'] = 1;} else {$request['projeto_scip'] = 0;}
            if (isset($request['laudo_exigencias'])) {$request['laudo_exigencias'] = 1;} else {$request['laudo_exigencias'] = 0;}
            if (isset($request['certificado_aprovacao'])) {$request['certificado_aprovacao'] = 1;} else {$request['certificado_aprovacao'] = 0;}
            if (isset($request['certificado_aprovacao_simplificado'])) {$request['certificado_aprovacao_simplificado'] = 1;} else {$request['certificado_aprovacao_simplificado'] = 0;}
            if (isset($request['certificado_aprovacao_assistido'])) {$request['certificado_aprovacao_assistido'] = 1;} else {$request['certificado_aprovacao_assistido'] = 0;}

            //Buscando dados Api_Data() - Alterar Registro
            $this->responseApi(1, 5, 'clientes', $id, '', '', $request->all());

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
            $this->responseApi(1, 6, 'clientes', $id, '', '', '');

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

    public function search(Request $request, $field = '', $value = '')
    {
        //Requisição Ajax
        if ($request->ajax()) {
            //Buscando dados Api_Data() - Pesquisar Registros
            $this->responseApi(1, 3, 'clientes', '', $field, $value, '');

            //Dados recebidos com sucesso
            if ($this->code == 2000) {
                $allData = DataTables::of($this->content)
                    ->addIndexColumn()
                    ->addColumn('action', function ($row, Request $request) {
                        return $this->columnAction($row['id'], $request['ajaxPrefixPermissaoSubmodulo'], $request['userLoggedPermissoes']);
                    })
                    ->editColumn('foto', function ($row) {
                        $retorno = "<div class='text-center'>";
                        $retorno .= "<img src='".asset($row['foto'])."' alt='' class='img-thumbnail rounded-circle avatar-sm'>";
                        $retorno .= "<br>";
                        $retorno .= "<a href='#' data-bs-toggle='modal' data-bs-target='.modal-cliente' onclick='clienteExtraData(".$row['id'].");'><span class='bg-success badge'><i class='bx bx-user font-size-16 align-middle me-1'></i>Perfil</span></a>";
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
                    ->rawColumns(['action'])
                    ->escapeColumns([])
                    ->make(true);

                return $allData;
            } else {
                abort(500, 'Erro Interno Client');
            }
        } else {
            return view('clientes.index');
        }
    }

    public function visita_tecnica(Request $request, $id)
    {
        //Requisição Ajax
        if ($request->ajax()) {
            //Buscando dados Api_Data() - Registro pelo id
            $this->responseApi(1, 10, 'clientes/visita_tecnica/'.$id, '', '', '', '');

            //Registro recebido com sucesso
            if ($this->code == 2000) {
                return response()->json(['success' => $this->content]);
            } else if ($this->code == 4040) { //Registro não encontrado
                return response()->json(['error_not_found' => $this->message]);
            } else {
                abort(500, 'Erro Interno Client');
            }
        }
    }

    public function uploadfoto(Request $request)
    {
        //Requisição Ajax
        if ($request->ajax()) {
            //Variavel controle
            $error = false;

            //Foto padrão do Sistema
            $foto = "build/assets/images/clientes/cliente-0.png";

            //Verificando e fazendo Upload da Foto novo
            if ($request->hasFile('cliente_extra_foto_file')) {
                //cliente_id
                $id = $request['upload_cliente_extra_foto_cliente_id'];

                //buscar dados formulario
                $arquivo_tmp = $_FILES["cliente_extra_foto_file"]["tmp_name"];
                $arquivo_real = $_FILES["cliente_extra_foto_file"]["name"];
                $arquivo_real = utf8_decode($arquivo_real);
                $arquivo_type = $_FILES["cliente_extra_foto_file"]["type"];
                $arquivo_size = $_FILES['cliente_extra_foto_file']['size'];

                if ($arquivo_type == 'image/jpg' or $arquivo_type == 'image/jpeg' or $arquivo_type == 'image/png') {
                    if (copy($arquivo_tmp, "build/assets/images/clientes/$arquivo_real")) {
                        if (file_exists("build/assets/images/clientes/" . $arquivo_real)) {
                            //apagar foto no diretorio
                            if (file_exists('build/assets/images/clientes/cliente-' . $id . '.png')) {
                                unlink('build/assets/images/clientes/cliente-' . $id . '.png');
                            }
                            if (file_exists('build/assets/images/clientes/cliente-' . $id . '.jpg')) {
                                unlink('build/assets/images/clientes/cliente-' . $id . '.jpg');
                            }
                            if (file_exists('build/assets/images/clientes/cliente-' . $id . '.jpeg')) {
                                unlink('build/assets/images/clientes/cliente-' . $id . '.jpeg');
                            }

                            //Gravar novo
                            $foto = "build/assets/images/clientes/cliente-" . $id . '.' . pathinfo($arquivo_real, PATHINFO_EXTENSION);
                            $de = "build/assets/images/clientes/$arquivo_real";
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
                $this->responseApi(1, 11, 'clientes/updatefoto/' . $id, '', '', '', $data);

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
            $this->responseApi(1, 10, 'clientes/extradata/' . $id, '', '', '', '');

            //Registro recebido com sucesso
            if ($this->code == 2000) {
                return json_encode($this->content);
            } else if ($this->code == 4040) { //Registro não encontrado
                echo 'Registro não encontrado.';
            } else {
                echo 'Erro Interno User.';
            }
        }
    }
}
