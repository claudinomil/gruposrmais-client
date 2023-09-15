<?php

namespace App\Http\Controllers;

use App\Facades\Permissoes;
use App\Facades\SuporteFacade;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class ClienteServicoController extends Controller
{
    //Variaveis de Retorno da API
    public $message;
    public $code;
    public $validation;
    public $content;

    //Dados Auxiliares
    public $clientes;
    public $servicos;
    public $servico_status;
    public $funcionarios;
    public $escala_tipos;

    public function __construct()
    {
        $this->middleware('check-permissao:clientes_servicos_list', ['only' => ['index', 'search', 'extradata', 'cliente_servicos_index']]);
        $this->middleware('check-permissao:clientes_servicos_create', ['only' => ['create', 'store', 'cliente_servicos_store']]);
        $this->middleware('check-permissao:clientes_servicos_show', ['only' => ['show', 'cliente_servicos_show']]);
        $this->middleware('check-permissao:clientes_servicos_edit', ['only' => ['edit', 'update']]);
        $this->middleware('check-permissao:clientes_servicos_destroy', ['only' => ['destroy', 'cliente_servicos_destroy']]);
    }

    public function index(Request $request)
    {
        //Requisição Ajax
        if ($request->ajax()) {
            //Buscando dados Api_Data() - Lista de Registros
            $this->responseApi(1, 1, 'clientes_servicos', '', '', '', '');

            //Dados recebidos com sucesso
            if ($this->code == 2000) {
                $allData = DataTables::of($this->content)
                    ->addIndexColumn()
                    ->editColumn('status', function ($row) {
                        $retorno = "<p class='text-dark mb-0'><b>::</b> ".$row['servicoStatusName']."</p>";

                        return $retorno;
                    })
                    ->editColumn('cliente_funcionario', function ($row) {
                        $retorno = "<p class='text-dark mb-0'><b>::</b> ".$row['clienteName']."</p>";
                        $retorno .= "<p class='text-dark mb-0'><b>::</b> ".$row['funcionarioName']."</p>";

                        return $retorno;
                    })
                    ->editColumn('datas', function ($row) {
                        $retorno = "<p class='text-muted mb-0'>".$row['data_inicio']." Início</p>";
                        $retorno .= "<p class='text-muted mb-0'>".$row['data_inicio']." Fim</p>";

                        return $retorno;
                    })
                    ->addColumn('action', function ($row, Request $request) {
                        //Se servico_status_id for igual a 1(EXECUTADO) : Somente Visualização
                        if ($row['servico_status_id'] == 1) {
                            $botoes = 1;
                        } else {
                            //Se servico_status_id for diferente de 1(EXECUTADO) : Visualização, Alteração, Exclusão e QrCodes
                            $botoes = 7;
                        }

                        $btns_padroes = $this->columnAction($row['id'], $request['ajaxPrefixPermissaoSubmodulo'], $request['userLoggedPermissoes'], $botoes);

                        //QRCodes - Criando e colocando para Visualizar no Modal''''''''''''''''''''''''''''''''''''''''
                        $btn_qrcode = '';

                        if ($row['servico_tipo_id'] == 1) {
                            //Gravar QRCode Informações
                            if (!file_exists('build/assets/qrcodes/clientes_servicos/qrcode_brigada_informacoes_' . $row['id'] . '.png')) {
                                SuporteFacade::getClienteServicoQRCodeBrigadaInformacoes($row['id']);
                            }

                            //Gravar QRCode Brigada Serviço
                            if (!file_exists('build/assets/qrcodes/clientes_servicos/qrcode_brigada_escalas_' . $row['id'] . '.png')) {
                                SuporteFacade::getClienteServicoQRCodeBrigadaEscalas($row['id']);
                            }

                            //Botão Visualizar QRCodes
                            if (Permissoes::permissao(['clientes_servicos_show'], $request['userLoggedPermissoes'])) {
                                $btn_qrcode = '<div class="col-12 text-center pt-2"><button type="button" class="btn btn-dark waves-effect btn-label waves-light btn-sm" data-bs-toggle="modal" data-bs-target=".modal-qrcode" data-bs-placement="top" title="QRCodes" onclick="$(\'#imgQRCode1\').prop(\'src\', \''.asset('build/assets/qrcodes/clientes_servicos/qrcode_brigada_informacoes_' . $row['id'] . '.png').'\'); $(\'#imgQRCode2\').prop(\'src\', \''.asset('build/assets/qrcodes/clientes_servicos/qrcode_brigada_escalas_' . $row['id'] . '.png').'\');"><i class="mdi mdi-qrcode label-icon font-size-18"></i> QRCodes</button></div>';
                            }
                        }
                        //''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''

                        return $btns_padroes.$btn_qrcode;
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
            $this->responseApi(2, 10, 'clientes_servicos/auxiliary/tables/'.$empresa_id, '', '', '', '');

            //chamar view
            return view('clientes_servicos.index', [
                'evento' => 'index',
                'clientes' => $this->clientes,
                'servicos' => $this->servicos,
                'servico_status' => $this->servico_status,
                'funcionarios' => $this->funcionarios,
                'escala_tipos' => $this->escala_tipos
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
            $this->responseApi(1, 4, 'clientes_servicos', '', '', '', $request->all());

            //Registro criado com sucesso
            if ($this->code == 2010) {
                //Gravar QRCode
                SuporteFacade::getClienteServicoQRCodeBrigadaInformacoes($this->content['id']);

                //Retorno
                return response()->json(['success' => $this->message]);
            } else if ($this->code == 2020) { //Falha na validação dos dados
                return response()->json(['error_validation' => $this->validation]);
            } else if ($this->code == 4060) { //Error
                return response()->json(['error' => $this->message]);
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
            $this->responseApi(1, 2, 'clientes_servicos', $id, '', '', '');

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

    public function edit(Request $request, $id)
    {
        //Requisição Ajax
        if ($request->ajax()) {
            //Buscando dados Api_Data() - Registro pelo id
            $this->responseApi(1, 2, 'clientes_servicos', $id, '', '', '');

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

    public function update(Request $request, $id)
    {
        //Requisição Ajax
        if ($request->ajax()) {
            //Buscando dados Api_Data() - Alterar Registro
            $this->responseApi(1, 5, 'clientes_servicos', $id, '', '', $request->all());

            //Registro alterado com sucesso
            if ($this->code == 2000) {
                return response()->json(['success' => $this->message]);
            } else if ($this->code == 2020) { //Falha na validação dos dados
                return response()->json(['error_validation' => $this->validation]);
            } else if ($this->code == 4040) { //Registro não encontrado
                return response()->json(['error_not_found' => $this->message]);
            } else if ($this->code == 4060) { //Error
                return response()->json(['error' => $this->message]);
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
            $this->responseApi(1, 6, 'clientes_servicos', $id, '', '', '');

            //Registro deletado com sucesso
            if ($this->code == 2000) {
                //Excluir QRCode Informações
                if (file_exists('build/assets/qrcodes/clientes_servicos/qrcode_brigada_informacoes_'.$id.'.png')) {
                    unlink('build/assets/qrcodes/clientes_servicos/qrcode_brigada_informacoes_'.$id.'.png');
                }

                //Excluir QRCode Brigada Serviço
                if (file_exists('build/assets/qrcodes/clientes_servicos/qrcode_brigada_escalas_'.$id.'.png')) {
                    unlink('build/assets/qrcodes/clientes_servicos/qrcode_brigada_escalas_'.$id.'.png');
                }

                //Return
                return response()->json(['success' => $this->message]);
            } else if ($this->code == 2040) { //Registro não excluído - pertence a relacionamento com outra(s) tabela(s)
                return response()->json(['error' => $this->message]);
            } else if ($this->code == 4040) { //Registro não encontrado
                return response()->json(['error' => $this->message]);
            } else if ($this->code == 4060) { //Error
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
            $this->responseApi(1, 3, 'clientes_servicos', '', $field, $value, '');

            //Dados recebidos com sucesso
            if ($this->code == 2000) {
                $allData = DataTables::of($this->content)
                    ->addIndexColumn()
                    ->editColumn('status', function ($row) {
                        $retorno = "<p class='text-dark mb-0'><b>::</b> ".$row['servicoStatusName']."</p>";

                        return $retorno;
                    })
                    ->editColumn('cliente_funcionario', function ($row) {
                        $retorno = "<p class='text-dark mb-0'><b>::</b> ".$row['clienteName']."</p>";
                        $retorno .= "<p class='text-dark mb-0'><b>::</b> ".$row['funcionarioName']."</p>";

                        return $retorno;
                    })
                    ->editColumn('datas', function ($row) {
                        $retorno = "<p class='text-muted mb-0'>".$row['data_inicio']." Início</p>";
                        $retorno .= "<p class='text-muted mb-0'>".$row['data_inicio']." Fim</p>";

                        return $retorno;
                    })
                    ->addColumn('action', function ($row, Request $request) {
                        //Se servico_status_id for igual a 1(EXECUTADO) : Somente Visualização
                        if ($row['servico_status_id'] == 1) {
                            $botoes = 1;
                        } else {
                            //Se servico_status_id for diferente de 1(EXECUTADO) : Visualização, Alteração, Exclusão e QrCodes
                            $botoes = 7;
                        }

                        $btns_padroes = $this->columnAction($row['id'], $request['ajaxPrefixPermissaoSubmodulo'], $request['userLoggedPermissoes'], $botoes);

                        //QRCodes - Criando e colocando para Visualizar no Modal''''''''''''''''''''''''''''''''''''''''
                        $btn_qrcode = '';

                        if ($row['servico_tipo_id'] == 1) {
                            //Gravar QRCode Informações
                            if (!file_exists('build/assets/qrcodes/clientes_servicos/qrcode_brigada_informacoes_' . $row['id'] . '.png')) {
                                SuporteFacade::getClienteServicoQRCodeBrigadaInformacoes($row['id']);
                            }

                            //Gravar QRCode Brigada Serviço
                            if (!file_exists('build/assets/qrcodes/clientes_servicos/qrcode_brigada_escalas_' . $row['id'] . '.png')) {
                                SuporteFacade::getClienteServicoQRCodeBrigadaEscalas($row['id']);
                            }

                            //Botão Visualizar QRCodes
                            if (Permissoes::permissao(['clientes_servicos_show'], $request['userLoggedPermissoes'])) {
                                $btn_qrcode = '<div class="col-12 text-center pt-2"><button type="button" class="btn btn-dark waves-effect btn-label waves-light btn-sm" data-bs-toggle="modal" data-bs-target=".modal-qrcode" data-bs-placement="top" title="QRCodes" onclick="$(\'#imgQRCode1\').prop(\'src\', \''.asset('build/assets/qrcodes/clientes_servicos/qrcode_brigada_informacoes_' . $row['id'] . '.png').'\'); $(\'#imgQRCode2\').prop(\'src\', \''.asset('build/assets/qrcodes/clientes_servicos/qrcode_brigada_escalas_' . $row['id'] . '.png').'\');"><i class="mdi mdi-qrcode label-icon font-size-18"></i> QRCodes</button></div>';
                            }
                        }
                        //''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''

                        return $btns_padroes.$btn_qrcode;
                    })
                    ->rawColumns(['action'])
                    ->escapeColumns([])
                    ->make(true);

                return $allData;
            } else {
                abort(500, 'Erro Interno Client');
            }
        } else {
            return view('clientes_servicos.index');
        }
    }

    //Eventos para QRCode - Início''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
    //Eventos para QRCode - Início''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
    public function qrcode_brigada_informacoes($id)
    {
        if (SuporteFacade::getDevice() == 'desktopxxxxx') {
            abort(500, 'Não é permitido acesso via Desktop.');
        } else {
            //Buscando dados Api_Data() - Registro pelo id
            $this->responseApi(1, 2, 'qrcodes/clientes_servicos/qrcode_brigada_informacoes', $id, '', '', '');

            //Variáveis de controle
            $error = true;
            $message = '';

            //Variáveis de dados
            $cliente_servico = [];
            $brigadistas = [];
            $escalas = [];
            $rondas = [];

            //Registro recebido com sucesso
            if ($this->code == 2000) {
                $error = false;

                $cliente_servico = $this->content['cliente_servico'][0];
                $brigadistas = $this->content['brigadistas'];
                $escalas = $this->content['escalas'];
                $rondas = $this->content['rondas'];
            } else {
                $message = $this->message;
            }

            //chamar view
            return view('clientes_servicos.qrcode_brigada_informacoes', [
                'error' => $error,
                'message' => $message,
                'cliente_servico' => $cliente_servico,
                'brigadistas' => $brigadistas,
                'escalas' => $escalas,
                'rondas' => $rondas
            ]);
        }
    }

    public function qrcode_brigada_escalas($id)
    {
        if (SuporteFacade::getDevice() == 'desktopxxxxx') {
            abort(500, 'Não é permitido acesso via Desktop.');
        } else {
            //Buscando dados Api_Data() - Registro pelo id
            $this->responseApi(1, 2, 'qrcodes/clientes_servicos/qrcode_brigada_escalas', $id, '', '', '');

            //Variáveis de controle
            $error = true;
            $message = '';

            //Variáveis de dados
            $cliente_servico = [];
            $escalas = [];
            $rondas = [];

            //Registro recebido com sucesso
            if ($this->code == 2000) {
                $error = false;

                $cliente_servico = $this->content['cliente_servico'][0];
                $escalas = $this->content['escalas'];
                $rondas = $this->content['rondas'];
            } else {
                $message = $this->message;
            }

            //chamar view
            return view('clientes_servicos.qrcode_brigada_escalas', [
                'error' => $error,
                'message' => $message,
                'cliente_servico' => $cliente_servico,
                'escalas' => $escalas,
                'rondas' => $rondas
            ]);
        }
    }

    public function qrcode_brigada_escala_operacao_salvar(Request $request, $brigada_escala_id)
    {
        //Requisição Ajax
        if ($request->ajax()) {
            //Buscando dados Api_Data() - Alterar Registro
            $this->responseApi(1, 11, 'qrcodes/clientes_servicos/qrcode_brigada_escala_operacao_salvar/'.$brigada_escala_id, '', '', '', $request->all());

            //Registro alterado com sucesso
            if ($this->code == 2000) {
                return response()->json(['success' => $this->message]);
            } else if ($this->code == 4060) { //Error
                return response()->json(['error' => $this->message]);
            } else {
                abort(500, 'Erro Interno Client');
            }
        }
    }
    //Eventos para QRCode - Fim'''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
    //Eventos para QRCode - Fim'''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
}
