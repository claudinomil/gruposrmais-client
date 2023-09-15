@extends('layouts.app-qrcodes')

@section('page_title') Clientes Serviços @endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body" style="min-height: 100vh; padding: 0.6rem 0.6rem !important;">
                    <div class="text-center mb-2">
                        <h5 class="text-primary mb-1">{{$cliente_servico['servicoName']}}</h5>
                        <p class="text-muted font-size-11 mb-1">{{$cliente_servico['clienteName']}}</p>
                    </div>
                    <div class="mt-3">
                        @foreach ($escalas as $key => $escala)
                            @php
                            //Dados Gerais
                            $brigada_escala_id = $escala['id'];
                            $escala_tipo_nome = $escala['escala_tipo_nome'];
                            $funcionario_nome = $escala['funcionario_nome'];
                            $funcionario_foto = $escala['funcionarioFoto'];
                            $usuario_email = $escala['usuarioEmail'];

                            //Ala
                            if ($escala['ala'] == 1) {$corAla = 'bg-success';  $ala = 'Ala 1';}
                            if ($escala['ala'] == 2) {$corAla = 'bg-primary';  $ala = 'Ala 2';}
                            if ($escala['ala'] == 3) {$corAla = 'bg-danger';   $ala = 'Ala 3';}
                            if ($escala['ala'] == 4) {$corAla = 'bg-warning';  $ala = 'Ala 4';}
                            if ($escala['ala'] == 5) {$corAla = 'bg-pink';     $ala = 'Ala 5';}

                            //Frequência e Frequência Cor
                            $frequencia = '';

                            if ($escala['escala_frequencia_id'] !== null) {
                                if ($escala['escala_frequencia_id'] == 1) {$frequenciaCor = 'text-success'; $frequenciaNome = 'PRESENÇA';}
                                if ($escala['escala_frequencia_id'] == 2) {$frequenciaCor = 'text-warning'; $frequenciaNome = 'ATRASO';}
                                if ($escala['escala_frequencia_id'] == 3) {$frequenciaCor = 'text-danger'; $frequenciaNome = 'FALTA';}

                                $frequencia = '<span class="'.$frequenciaCor.'"><b>'.$frequenciaNome.'</b></span>';
                            }

                            //Data/Hora Previstas
                            $data_chegada = $escala['data_chegada'];
                            $hora_chegada = $escala['hora_chegada'];
                            $data_saida = $escala['data_saida'];
                            $hora_saida = $escala['hora_saida'];

                            //Data/Hora Realizadas
                            $data_chegada_real = $escala['data_chegada_real'];
                            $hora_chegada_real = $escala['hora_chegada_real'];
                            $data_saida_real = $escala['data_saida_real'];
                            $hora_saida_real = $escala['hora_saida_real'];

                            //Operação (Iniciar Serviço, Iniciar Ronda ou Encerrar Serviço)'''''''''''''''''''''''''''''
                            $botao_iniciar_servico = false;
                            $botao_iniciar_ronda = false;
                            $botao_encerrar_servico = false;

                            //Se Frequência for diferente de FALTOU
                            if ($escala['escala_frequencia_id'] != 3) {
                                //Se Data Chegada Real for NULL (O Brigadista pode Iniciar o Serviço)
                                if ($escala['data_chegada_real'] === null) {
                                    $botao_iniciar_servico = true;
                                } else {
                                    if ($escala['data_saida_real'] === null) {
                                        $botao_iniciar_ronda = true;
                                        $botao_encerrar_servico = true;
                                    }
                                }
                            }
                            //''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
                            @endphp

                            <div class="col-12 divsEscalaBrigadistasOperacoes">
                                <div class="card" style="box-shadow: 0.1rem 0.5rem 0.5rem 0.07rem #2a3042;">
                                    <div class="card-body" style="padding: 0.2rem 0.6rem 0.6rem 0.6rem !important;">
                                        <div class="d-flex">
                                            <div class="flex-shrink-0 me-4">
                                                <div class="text-center">
                                                    <div class="text-primary font-size-12">Brigadista</div>
                                                    <img src="{{asset($funcionario_foto)}}" alt="" class="img-thumbnail rounded-circle avatar-md">
                                                    <br>
                                                    <span class="{{$corAla}} badge p-1">{{$ala}}</span>
                                                </div>
                                            </div>
                                            <div class="flex-grow-1 overflow-hidden pt-4">
                                                <h6 class="text-truncate"><b>{{$funcionario_nome}}</b></h6>
                                                <p class="text-muted font-size-11">
                                                    Escala: {{$escala_tipo_nome}}
                                                    <br>
                                                    Início: {{$data_chegada.' às '.$hora_chegada.'hs'}}
                                                    <br>
                                                    Fim: {{$data_saida.' às '.$hora_saida.'hs'}}
                                                </p>

                                                @if($botao_iniciar_servico)
                                                    <button type="button"
                                                            class="btn btn-success waves-effect btn-label waves-light"
                                                            data-brigada_escala_id="{{$brigada_escala_id}}"
                                                            data-funcionario_foto="{{$funcionario_foto}}"
                                                            data-cor_ala="{{$corAla}}"
                                                            data-ala="{{$ala}}"
                                                            data-funcionario_nome="{{$funcionario_nome}}"
                                                            data-usuario_email="{{$usuario_email}}"
                                                            data-escala_tipo_nome="{{$escala_tipo_nome}}"
                                                            data-data_chegada="{{$data_chegada}}"
                                                            data-hora_chegada="{{$hora_chegada}}"
                                                            data-data_saida="{{$data_saida}}"
                                                            data-hora_saida="{{$hora_saida}}"
                                                            id="btnIniciarServico">
                                                        <i class="bx bx-check label-icon"></i> Iniciar Serviço
                                                    </button>
                                                @endif

                                                @if($botao_iniciar_ronda)
                                                    <button type="button"
                                                            class="btn btn-warning waves-effect btn-label waves-light"
                                                            data-brigada_escala_id="{{$brigada_escala_id}}"
                                                            data-funcionario_foto="{{$funcionario_foto}}"
                                                            data-cor_ala="{{$corAla}}"
                                                            data-ala="{{$ala}}"
                                                            data-funcionario_nome="{{$funcionario_nome}}"
                                                            data-usuario_email="{{$usuario_email}}"
                                                            data-escala_tipo_nome="{{$escala_tipo_nome}}"
                                                            data-data_chegada="{{$data_chegada}}"
                                                            data-hora_chegada="{{$hora_chegada}}"
                                                            data-data_saida="{{$data_saida}}"
                                                            data-hora_saida="{{$hora_saida}}"
                                                            id="btnIniciarRonda">
                                                        <i class="bx bx-calendar-check label-icon"></i> Iniciar Ronda
                                                    </button>
                                                    <br><br>
                                                @endif

                                                @if($botao_encerrar_servico)
                                                    <button type="button"
                                                            class="btn btn-primary waves-effect btn-label waves-light"
                                                            data-brigada_escala_id="{{$brigada_escala_id}}"
                                                            data-funcionario_foto="{{$funcionario_foto}}"
                                                            data-cor_ala="{{$corAla}}"
                                                            data-ala="{{$ala}}"
                                                            data-funcionario_nome="{{$funcionario_nome}}"
                                                            data-usuario_email="{{$usuario_email}}"
                                                            data-escala_tipo_nome="{{$escala_tipo_nome}}"
                                                            data-data_chegada="{{$data_chegada}}"
                                                            data-hora_chegada="{{$hora_chegada}}"
                                                            data-data_saida="{{$data_saida}}"
                                                            data-hora_saida="{{$hora_saida}}"
                                                            id="btnEncerrarServico">
                                                        <i class="bx bx-check label-icon"></i> Encerrar Serviço
                                                    </button>
                                                @endif
                                            </div>
                                        </div>
                                    </div>

                                    @if($frequencia != '')
                                        <div class="px-2 py-2 border-top bg-light">
                                            <div class="row">
                                                <div class="col-3 text-center">
                                                    <h5 class="text-truncate font-size-12 py-2">{!! $frequencia !!}</h5>
                                                </div>
                                                <div class="col-9 text-muted font-size-11">
                                                    @if($data_chegada_real != '')
                                                        <span class="text-success">Chegada</span>: {{$data_chegada_real.' às '.$hora_chegada_real.'hs'}}

                                                        @foreach ($rondas as $key => $ronda)
                                                            @if($ronda['brigada_escala_id'] == $escala['id'])
                                                                <br>
                                                                <span class="text-warning">Ronda</span>: {{$ronda['data_inicio_ronda'].' às '.$ronda['hora_inicio_ronda'].'hs'}}
                                                            @endif
                                                        @endforeach
                                                    @endif

                                                    @if($data_saida_real != '')
                                                        <br>
                                                        <span class="text-primary">Saída</span>: {{$data_saida_real.' às '.$hora_saida_real.'hs'}}
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        @endforeach

                        <div class="col-12 d-none" id="divEscalaBrigadistaOperacao">
                            <div class="card" style="box-shadow: 0.1rem 0.5rem 0.5rem 0.07rem #2a3042;">
                                <div class="card-body" style="padding: 0.2rem 0.6rem 0.6rem 0.6rem !important;">
                                    <div class="d-flex">
                                        <div class="flex-shrink-0 me-4">
                                            <div class="text-center">
                                                <div class="text-primary font-size-12">Brigadista</div>
                                                <img src="" alt="" class="img-thumbnail rounded-circle avatar-md formFoto">
                                                <br>
                                                <span class="badge p-1 formAla"></span>
                                            </div>
                                        </div>
                                        <div class="flex-grow-1 overflow-hidden pt-4">
                                            <h6 class="text-truncate"><b class="formFuncionarioNome"></b></h6>
                                            <p class="text-muted font-size-11 formDadosEscala"></p>
                                        </div>
                                    </div>
                                </div>

                                <div class="px-2 py-2 border-top" id="divOperacaoFormularioResultado">
                                    <div class="col-12">
                                        <form id="frm_qrcode_brigada_escalas" name="frm_qrcode_brigada_escalas">
                                            <input type="hidden" id="brigada_escala_operacao" name="brigada_escala_operacao">
                                            <input type="hidden" id="brigada_escala_id" name="brigada_escala_id">
                                            <input type="hidden" id="email" name="email">
                                            <input type="hidden" id="foto_real" name="foto_real">
                                            <input type="hidden" id="data_inicio_ronda" name="data_inicio_ronda">
                                            <input type="hidden" id="hora_inicio_ronda" name="hora_inicio_ronda">

                                            <div class="form-group col-12 pb-3">
                                                <div class="text-center">
                                                    <video class="col-12 form-control" id="videoFrontal" autoplay></video>
                                                    <canvas class="col-12 form-control d-none" id="canvasFrontal"></canvas>
                                                    <img class="col-12 form-control" id="photoFrontal" src="" style="display: none;">
                                                </div>
                                                <div class="text-center py-2">
                                                    <button type="button" class="btn btn-primary waves-effect btn-label waves-light" id="btnTirarFotoFrontal"><i class="bx bx-photo-album label-icon"></i> Tirar Foto</button>
                                                    <button type="button" class="btn btn-warning waves-effect btn-label waves-light" style="display:none;" id="btnExcluirFotoFrontal"><i class="bx bx-trash label-icon"></i> Excluir Foto</button>
                                                </div>
                                            </div>
                                            <div class="form-group col-12 pb-3">
                                                <input type="password" class="form-control" id="password" name="password" placeholder="Digite sua Senha aqui...">
                                            </div>

                                            <div class="row" id="divMedidasSegurancaRondaItens"></div>

                                            <div class="form-group col-12 pb-3">
                                                <div class="row">
                                                    <div class="col-6 text-start">
                                                        <button type="button" class="btn btn-success waves-effect btn-label waves-light" id="btnConfirmarOperacao"><i class="bx bx-check-double label-icon"></i> Confirmar</button>
                                                    </div>
                                                    <div class="col-6 text-end">
                                                        <button type="button" class="btn btn-danger waves-effect btn-label waves-light" id="btnCancelarOperacao"><i class="bx bx-exit label-icon"></i> Cancelar</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Acessar Câmera Traseira -->
    <div class="modal fade modal-camera-traseira" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Câmera</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-center">
                    <div class="row">
                        <div class="col-12">
                            <div class="text-center">
                                <video class="col-12 form-control" id="videoTraseira" autoplay></video>
                                <canvas class="col-12 form-control d-none" id="canvasTraseira"></canvas>
                                <img class="col-12 form-control" id="photoTraseira" src="" style="display: none;">
                            </div>
                            <div class="text-center py-2">
                                <button type="button" class="btn btn-primary waves-effect btn-label waves-light" id="btnTirarFotoTraseira"><i class="bx bx-photo-album label-icon"></i> Tirar Foto</button>
                                <button type="button" class="btn btn-warning waves-effect btn-label waves-light" style="display:none;" id="btnExcluirFotoTraseira"><i class="bx bx-trash label-icon"></i> Excluir Foto</button>
                            </div>

                            <input type="hidden" id="fotoTraseiraPavimento" name="fotoTraseiraPavimento" value="">
                            <input type="hidden" id="fotoTraseiraSegurancaMedidaId" name="fotoTraseiraSegurancaMedidaId" value="">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('script')
    <!-- scripts_clientes_servicos_qrcode_brigada_escalas.js -->
    <script src="{{ Vite::asset('resources/assets_template/js/scripts_clientes_servicos_qrcode_brigada_escalas.js')}}"></script>
@endsection
