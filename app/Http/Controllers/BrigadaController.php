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
        $this->middleware('check-permissao:brigadas_edit', ['only' => ['edit', 'update']]);
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
                        return $this->columnAction($row['id'], $request['ajaxPrefixPermissaoSubmodulo'], $request['userLoggedPermissoes'], 8);
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
                        return $this->columnAction($row['id'], $request['ajaxPrefixPermissaoSubmodulo'], $request['userLoggedPermissoes'], 8);
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
                    ->editColumn('chegada_saida', function ($row) {
                        $retorno = "<div class='col-12 font-size-12'>".$row['data_chegada']." às ".substr($row['hora_chegada'], 0, 5)."</div>";
                        $retorno .= "<div class='col-12 font-size-12'>".$row['data_saida']." às ".substr($row['hora_saida'], 0, 5)."</div>";

                        return $retorno;
                    })
                    ->addColumn('action', function ($row, Request $request) {
                        //Frequência e Frequência Cor
                        $frequencia = '';

                        if ($row['escala_frequencia_id'] !== null) {
                            if ($row['escala_frequencia_id'] == 1) {$frequenciaCor = 'text-success'; $frequenciaNome = 'PRESENÇA';}
                            if ($row['escala_frequencia_id'] == 2) {$frequenciaCor = 'text-warning'; $frequenciaNome = 'ATRASO';}
                            if ($row['escala_frequencia_id'] == 3) {$frequenciaCor = 'text-danger'; $frequenciaNome = 'FALTA';}

                            $frequencia = '<span class="'.$frequenciaCor.'"><b>'.$frequenciaNome.'</b></span>';
                        }

                        //Data/Hora Realizadas
                        $data_chegada_real = $row['data_chegada_real'];
                        $hora_chegada_real = substr($row['hora_chegada_real'], 0, 5);
                        $data_saida_real = $row['data_saida_real'];
                        $hora_saida_real = substr($row['hora_saida_real'], 0, 5);

                        $dadosFrequenciaRonda = '';

                        if ($frequencia != '') {
                            $dadosFrequenciaRonda = '<div class="col-12 pb-2">'.$frequencia.'</div>';

                            if ($data_chegada_real != '') {
                                $btnFotoChegada = '<button type="button" class="btn btn-outline-success btn-sm text-center font-size-10" data-bs-toggle="modal" data-bs-target=".modal-foto" data-bs-placement="top" title="Foto Chegada" onclick="$(\'#imgFoto\').prop(\'src\', \''.$row['foto_chegada_real'].'\');">F1</button>';

                                $dadosFrequenciaRonda .= '<div class="row pb-2">';
                                $dadosFrequenciaRonda .= '<div class="col">';
                                $dadosFrequenciaRonda .= '<span class="text-success">Chegada</span>: '.$data_chegada_real.' às '.$hora_chegada_real.'hs';
                                $dadosFrequenciaRonda .= '</div>';
                                $dadosFrequenciaRonda .= '<div class="col-2">';
                                $dadosFrequenciaRonda .= $btnFotoChegada;
                                $dadosFrequenciaRonda .= '</div>';
                                $dadosFrequenciaRonda .= '<div class="col-2">';
                                $dadosFrequenciaRonda .= '&nbsp;';
                                $dadosFrequenciaRonda .= '</div>';
                                $dadosFrequenciaRonda .= '</div>';

                                //Rondas
                                $r = 0;
                                foreach ($this->content['rondas'] as $key => $ronda) {
                                    if ($ronda['brigada_escala_id'] == $row['id']) {
                                        //Botão visualizar Ronda''''''''''''''''''''''''''''''''''''''''''''''''''''''''
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

                                        $btnVerRonda = '<button type="button" class="btn btn-outline-secondary btn-sm text-center font-size-10 btnViewRonda" data-bs-toggle="tooltip" data-bs-placement="top" title="'.$r_extenso.'" data-id="'.$ronda['id'].'" data-funcionario_nome="'.$row['funcionario_nome'].'" data-data_chegada="'.$row['data_chegada'].'" data-hora_chegada="'.$row['hora_chegada'].'" data-data_saida="'.$row['data_saida'].'" data-hora_saida="'.$row['hora_saida'].'">R'.$r.'</button>';
                                        //''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''

                                        $btnFotoRonda = '<button type="button" class="btn btn-outline-warning btn-sm text-center font-size-10" data-bs-toggle="modal" data-bs-target=".modal-foto" data-bs-placement="top" title="Foto Ronda" onclick="$(\'#imgFoto\').prop(\'src\', \''.$ronda['foto'].'\');">F1</button>';

                                        $dadosFrequenciaRonda .= '<div class="row pb-2">';
                                        $dadosFrequenciaRonda .= '<div class="col">';
                                        $dadosFrequenciaRonda .= '<span class="text-warning">Ronda</span>: '.$ronda['data_inicio_ronda'].' às '.substr($ronda['hora_inicio_ronda'], 0, 5).'hs';
                                        $dadosFrequenciaRonda .= '</div>';
                                        $dadosFrequenciaRonda .= '<div class="col-2">';
                                        $dadosFrequenciaRonda .= $btnFotoRonda;
                                        $dadosFrequenciaRonda .= '</div>';
                                        $dadosFrequenciaRonda .= '<div class="col-2">';
                                        $dadosFrequenciaRonda .= $btnVerRonda;
                                        $dadosFrequenciaRonda .= '</div>';
                                        $dadosFrequenciaRonda .= '</div>';
                                    }
                                }
                            }

                            if ($data_saida_real != '') {
                                $btnFotoSaida = '<button type="button" class="btn btn-outline-primary btn-sm text-center font-size-10" data-bs-toggle="modal" data-bs-target=".modal-foto" data-bs-placement="top" title="Foto Saída" onclick="$(\'#imgFoto\').prop(\'src\', \''.$row['foto_saida_real'].'\');">F1</button>';

                                $dadosFrequenciaRonda .= '<div class="row pb-2">';
                                $dadosFrequenciaRonda .= '<div class="col">';
                                $dadosFrequenciaRonda .= '<span class="text-primary">Saída</span>: '.$data_saida_real.' às '.$hora_saida_real.'hs';
                                $dadosFrequenciaRonda .= '</div>';
                                $dadosFrequenciaRonda .= '<div class="col-2">';
                                $dadosFrequenciaRonda .= $btnFotoSaida;
                                $dadosFrequenciaRonda .= '</div>';
                                $dadosFrequenciaRonda .= '<div class="col-2">';
                                $dadosFrequenciaRonda .= '&nbsp;';
                                $dadosFrequenciaRonda .= '</div>';
                                $dadosFrequenciaRonda .= '</div>';
                            }
                        }

                        return $dadosFrequenciaRonda;
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
    //Escalas - Fim'''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
    //Escalas - Fim'''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
}
