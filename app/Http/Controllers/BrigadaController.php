<?php

namespace App\Http\Controllers;

use App\Facades\Permissoes;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class BrigadaController extends Controller
{
    //Variaveis de Retorno da API
    public $message;
    public $code;
    public $validation;
    public $content;

    public function __construct()
    {
        $this->middleware('check-permissao:brigadas_list', ['only' => ['index', 'search', 'escalas_index']]);
        $this->middleware('check-permissao:brigadas_show', ['only' => ['show']]);
        $this->middleware('check-permissao:brigadas_edit', ['only' => ['edit', 'update', 'escalas_update_frequencia']]);
    }

    public function index(Request $request)
    {
        //Requisição Ajax
        if ($request->ajax()) {
            //Buscando dados Api_Data() - Lista de Registros
            $this->responseApi(1, 1, 'brigadas', '', '', '', '');

            //Dados recebidos com sucesso
            if ($this->code == 2000) {
                $allData = DataTables::of($this->content)
                    ->addIndexColumn()
                    ->addColumn('action', function ($row, Request $request) {
                        return $this->columnAction($row['id'], $request['ajaxPrefixPermissaoSubmodulo'], $request['userLoggedPermissoes'], 8, 4);
                    })
                    ->rawColumns(['action'])
                    ->escapeColumns([])
                    ->make(true);

                return $allData;
            } else {
                abort(500, 'Erro Interno Brigada Incêndio');
            }
        } else {
            return view('brigadas.index');
        }
    }

    public function show(Request $request, $id)
    {
        //Requisição Ajax
        if ($request->ajax()) {
            //Buscando dados Api_Data() - Registro pelo id
            $this->responseApi(1, 2, 'brigadas', $id, '', '', '');

            //Registro recebido com sucesso
            if ($this->code == 2000) {
                return response()->json(['success' => $this->content]);
            } else if ($this->code == 4040) { //Registro não encontrado
                return response()->json(['error_not_found' => $this->message]);
            } else {
                abort(500, 'Erro Interno Brigada Incêndio');
            }
        }
    }

    public function edit(Request $request, $id)
    {
        //Requisição Ajax
        if ($request->ajax()) {
            //Buscando dados Api_Data() - Registro pelo id
            $this->responseApi(1, 2, 'brigadas', $id, '', '', '');

            //Registro recebido com sucesso
            if ($this->code == 2000) {
                return response()->json(['success' => $this->content]);
            } else if ($this->code == 4040) { //Registro não encontrado
                return response()->json(['error_not_found' => $this->message]);
            } else {
                abort(500, 'Erro Interno Brigada Incêndio');
            }
        }
    }

    public function update(Request $request, $id)
    {
        //Requisição Ajax
        if ($request->ajax()) {
            //Buscando dados Api_Data() - Alterar Registro
            $this->responseApi(1, 5, 'brigadas', $id, '', '', $request->all());

            //Registro alterado com sucesso
            if ($this->code == 2000) {
                return response()->json(['success' => $this->message]);
            } else if ($this->code == 2020) { //Falha na validação dos dados
                return response()->json(['error_validation' => $this->validation]);
            } else if ($this->code == 4040) { //Registro não encontrado
                return response()->json(['error_not_found' => $this->message]);
            } else {
                abort(500, 'Erro Interno Brigada Incêndio');
            }
        }
    }

    public function search(Request $request, $field = '', $value = '')
    {
        //Requisição Ajax
        if ($request->ajax()) {
            //Buscando dados Api_Data() - Pesquisar Registros
            $this->responseApi(1, 3, 'brigadas', '', $field, $value, '');

            //Dados recebidos com sucesso
            if ($this->code == 2000) {
                $allData = DataTables::of($this->content)
                    ->addIndexColumn()
                    ->addColumn('action', function ($row, Request $request) {
                        return $this->columnAction($row['id'], $request['ajaxPrefixPermissaoSubmodulo'], $request['userLoggedPermissoes'], 8, 4);
                    })
                    ->rawColumns(['action'])
                    ->escapeColumns([])
                    ->make(true);

                return $allData;
            } else {
                abort(500, 'Erro Interno Brigada Incêndio');
            }
        } else {
            return view('brigadas.index');
        }
    }


    //Escalas - Início''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
    //Escalas - Início''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
    public function escalas_index(Request $request, $brigada_id, $es_periodo_data_1, $es_periodo_data_2)
    {
        //Requisição Ajax
        if ($request->ajax()) {
            //Buscando dados Api_Data() - Lista de Registros
            $this->responseApi(1, 10, 'brigadas/escalas/'.$brigada_id.'/'.$es_periodo_data_1.'/'.$es_periodo_data_2, '', '', '', '');

            //Dados recebidos com sucesso
            if ($this->code == 2000) {
                $allData = DataTables::of($this->content['escalas'])
                    ->addIndexColumn()
                    ->editColumn('#', function ($row) {
                        //Cores Alas
                        if ($row['ala'] == 1) {$corAla = 'bg-success';  $ala = 'Ala 1';}
                        if ($row['ala'] == 2) {$corAla = 'bg-primary';  $ala = 'Ala 2';}
                        if ($row['ala'] == 3) {$corAla = 'bg-danger';   $ala = 'Ala 3';}
                        if ($row['ala'] == 4) {$corAla = 'bg-warning';  $ala = 'Ala 4';}
                        if ($row['ala'] == 5) {$corAla = 'bg-pink';     $ala = 'Ala 5';}

                        //Retorno
                        $retorno = "<div class='text-center'>";
                        $retorno .= "<img src='".asset($row['foto'])."' alt='' class='img-thumbnail rounded-circle avatar-sm'>";
                        $retorno .= "<br>";
                        $retorno .= "<span class='".$corAla." badge p-1'>".$ala."</span>";
                        $retorno .= "</div>";

                        return $retorno;
                    })
                    ->editColumn('funcionario_nome', function ($row) {
                        //Retorno
                        $retorno = "<h5 class='font-size-12'>".$row['funcionario_nome']."</h5>";

                        return $retorno;
                    })
                    ->editColumn('chegada', function ($row) {
                        $retorno = "<h5 class='text-truncate font-size-12'>".$row['data_chegada']."</h5>";
                        $retorno .= "<p class='text-muted mb-0'>".$row['hora_chegada']."</p>";

                        return $retorno;
                    })
                    ->editColumn('saida', function ($row) {
                        $retorno = "<h5 class='text-truncate font-size-12'>".$row['data_saida']."</h5>";
                        $retorno .= "<p class='text-muted mb-0'>".$row['hora_saida']."</p>";

                        return $retorno;
                    })
                    ->addColumn('action', function ($row, Request $request) {
                        //Buscar Frequência e colocar botão para editá-la'''''''''''''''''''''''''''''''''''''''''''''''

                        //Frequencia
                        $frequencia = '';
                        $frequenciaCor = '';

                        if ($row['escala_frequencia_id'] == 1) {$frequencia = 'PRESENÇA';   $frequenciaCor = 'text-success';}
                        if ($row['escala_frequencia_id'] == 2) {$frequencia = 'ATRASO';     $frequenciaCor = 'text-warning';}
                        if ($row['escala_frequencia_id'] == 3) {$frequencia = 'FALTA';      $frequenciaCor = 'text-danger';}

                        //Frequência + Botão
                        $btn = '<div class="row">';
                        $btn .= '    <div class="col-12 col-md-8">';
                        $btn .= '       <div class="col '.$frequenciaCor.'" id="escala_frequencia_'.$row['id'].'">'.$frequencia.'</div>';
                        $btn .= '    </div>';
                        $btn .= '    <div class="col-12 col-md-4">';

                        if (Permissoes::permissao(['brigadas_edit'], $request['userLoggedPermissoes'])) {
                            $btn .= '    <div class="col"><button type="button" class="btn btn-outline-success text-center btn-sm text-center float-end font-size-10 btnEditarEscala" data-bs-toggle="tooltip" data-bs-placement="top" title="Editar Frequência" data-id="'.$row['id'].'" data-funcionario_nome="'.$row['funcionario_nome'].'" data-data_chegada="'.$row['data_chegada'].'" data-hora_chegada="'.$row['hora_chegada'].'" data-data_saida="'.$row['data_saida'].'" data-hora_saida="'.$row['hora_saida'].'">EDITAR</button></div>';
                        }

                        $btn .= '    </div>';
                        $btn .= '</div>';
                        //''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''

                        //Colocar botões com as Rondas já executadas e Botão para executar um nova Ronda''''''''''''''''
                        $btn2 = '<hr>';

                        $btn2 .= '<div class="row">';
                        $btn2 .= '    <div class="col-12 col-md-8">';
                        $btn2 .= '        <div class="row">';

                        //Rondas já executadas''''''''''''''''''''''''''''''''''''''''''''''''''
                        $r = 0;
                        foreach ($this->content['rondas'] as $ronda) {
                            if ($row['id'] == $ronda['brigada_escala_id']) {
                                $r++;

                                if ($r == 1) {$r_extenso = 'Primeira Ronda';}
                                if ($r == 2) {$r_extenso = 'Segunda Ronda';}
                                if ($r == 3) {$r_extenso = 'Terceira Ronda';}
                                if ($r == 4) {$r_extenso = 'Quarta Ronda';}
                                if ($r == 5) {$r_extenso = 'Quinta Ronda';}
                                if ($r == 6) {$r_extenso = 'Sexta Ronda';}
                                if ($r == 7) {$r_extenso = 'Sétima Ronda';}
                                if ($r == 8) {$r_extenso = 'Oitava Ronda';}
                                if ($r == 9) {$r_extenso = 'Nona Ronda';}
                                if ($r == 10) {$r_extenso = 'Décima Ronda';}

                                $btn2 .= '<div class="col-4 text-center pb-1"><button type="button" class="btn btn-outline-primary btn-sm text-center font-size-10 btnViewRonda" data-bs-toggle="tooltip" data-bs-placement="top" title="'.$r_extenso.'" data-id="'.$ronda['id'].'" data-funcionario_nome="'.$row['funcionario_nome'].'" data-data_chegada="'.$row['data_chegada'].'" data-hora_chegada="'.$row['hora_chegada'].'" data-data_saida="'.$row['data_saida'].'" data-hora_saida="'.$row['hora_saida'].'">R'.$r.'</button></div>';
                            }
                        }
                        //''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''

                        $btn2 .= '        </div>';
                        $btn2 .= '    </div>';
                        $btn2 .= '    <div class="col-12 col-md-4">';

                        //Verificando Nova Ronda (Só Usuário logado que está na Escala dentro do Horário)'''
                        if ($row['funcionario_id'] == $request['userLoggedData']['funcionario_id']) {
                            $dt_hs_atual = date('Y-m-dH:i:s');
                            $dt_hs_chegada = \Carbon\Carbon::createFromFormat('d/m/Y', $row['data_chegada'])->format('Y-m-d').$row['hora_chegada'];
                            $dt_hs_saida = \Carbon\Carbon::createFromFormat('d/m/Y', $row['data_saida'])->format('Y-m-d').$row['hora_saida'];

                            if ($dt_hs_atual>=$dt_hs_chegada and $dt_hs_atual<=$dt_hs_saida) {
                                $btn2 .= '<div class="float-end"><button type="button" class="btn btn-outline-primary btn-sm text-center float-end font-size-10 btnExecutarRonda" data-bs-toggle="tooltip" data-bs-placement="top" title="Executar Ronda" data-id="'.$row['id'].'" data-funcionario_nome="'.$row['funcionario_nome'].'" data-data_chegada="'.$row['data_chegada'].'" data-hora_chegada="'.$row['hora_chegada'].'" data-data_saida="'.$row['data_saida'].'" data-hora_saida="'.$row['hora_saida'].'">RONDA</button></div>';
                            }
                        }

                        //RETIRAR ESSA LINHA ABAIXO (SOMENTE PARA APARECER O BOTÂO RONDA)
                        //$btn2 .= '<div class="float-end"><button type="button" class="btn btn-outline-primary btn-sm text-center float-end font-size-10 btnExecutarRonda" data-bs-toggle="tooltip" data-bs-placement="top" title="Executar Ronda" data-id="'.$row['id'].'" data-funcionario_nome="'.$row['funcionario_nome'].'" data-data_chegada="'.$row['data_chegada'].'" data-hora_chegada="'.$row['hora_chegada'].'" data-data_saida="'.$row['data_saida'].'" data-hora_saida="'.$row['hora_saida'].'">RONDA</button></div>';



                        //''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''

                        $btn2 .= '    </div>';
                        $btn2 .= '</div>';
                        //''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''

                        return $btn.$btn2;
                    })
                    ->rawColumns(['action'])
                    ->escapeColumns([])
                    ->make(true);

                return $allData;
            } else {
                abort(500, 'Erro Interno Client');
            }
        }
    }

    public function escalas_update_frequencia(Request $request, $id)
    {
        //Requisição Ajax
        if ($request->ajax()) {
            //pegando o empresa_id
            $empresa_id = session('userLogged_empresa_id');

            //Buscando dados Api_Data() - Alterar Registro
            $this->responseApi(1, 11, 'brigadas/escalas_update_frequencia/'.$id.'/'.$empresa_id, '', '', '', $request->all());

            //Registro alterado com sucesso
            if ($this->code == 2000) {
                return response()->json(['success' => $this->message]);
            } else if ($this->code == 2020) { //Falha na validação dos dados
                return response()->json(['error_validation' => $this->message]);
            } else if ($this->code == 4040) { //Registro não encontrado
                return response()->json(['error_not_found' => $this->message]);
            } else {
                abort(500, 'Erro Interno Brigada Incêndio');
            }
        }
    }

    public function ronda_cliente_seguranca_medidas(Request $request, $op, $brigada_escala_id, $brigada_ronda_id)
    {
        //Requisição Ajax
        if ($request->ajax()) {
            //Buscando dados Api_Data() - Lista de Registros
            $this->responseApi(1, 10, 'brigadas/ronda_cliente_seguranca_medidas/'.$op.'/'.$brigada_escala_id.'/'.$brigada_ronda_id, '', '', '', '');

            //dd($this->content);


            //Dados recebidos com sucesso
            if ($this->code == 2000) {
                return response()->json(['success' => $this->content]);
            } else {
                abort(500, 'Erro Interno Brigada Incêndio Rondas');
            }
        }
    }

    public function ronda_store(Request $request)
    {
        //Requisição Ajax
        if ($request->ajax()) {
            //pegando o empresa_id
            $empresa_id = session('userLogged_empresa_id');

            //Buscando dados Api_Data() - Alterar Registro
            $this->responseApi(1, 12, 'brigadas/ronda_store/'.$empresa_id, '', '', '', $request->all());

            //Registro alterado com sucesso
            if ($this->code == 2010) {
                return response()->json(['success' => $this->message]);
            } else {
                abort(500, 'Erro Interno Brigada Incêndio Ronda');
            }
        }
    }
    //Escalas - Fim'''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
    //Escalas - Fim'''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
}
