@extends('layouts.app-qrcodes')

@section('page_title') Clientes Serviços @endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body" style="min-height: 100vh; padding: 0.6rem 0.6rem !important;">
                    <div class="text-center mb-2">
                        <h4 class="text-primary mb-1">Cliente Serviço</h4>
                        <p class="text-muted font-size-11 mb-1">{{$cliente_servico['clienteName']}}</p>
                        <p class="text-muted font-size-11 mb-1">{{$cliente_servico['servicoName']}}</p>
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

                            //Operação (Iniciar Serviço ou Encerrar Serviço)
                            $botao_iniciar_servico = false;
                            $botao_encerrar_servico = false;

                            if ($escala['escala_frequencia_id'] === null) {
                                $botao_iniciar_servico = true;
                            } else {
                                if ($data_saida_real === null) {$botao_encerrar_servico = true;}

                            }
                            @endphp

                            <div class="col-12 divsBrigadistas">
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
                                        <div class="px-2 py-2 border-top">
                                            <div class="row">
                                                <div class="col-3 text-center">
                                                    <h5 class="text-truncate font-size-12 py-2">{!! $frequencia !!}</h5>
                                                </div>
                                                <div class="col-9 text-muted font-size-11">
                                                    @if($data_chegada_real != '')
                                                        Chegada: {{$data_chegada_real.' às '.$hora_chegada_real.'hs'}}
                                                    @endif

                                                    @if($data_saida_real != '')
                                                        <br>
                                                        Saída: {{$data_saida_real.' às '.$hora_saida_real.'hs'}}
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        @endforeach

                        <div class="col-12 d-none divConfirmarPresenca">
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
                                            <h6 class="text-truncate formFuncionarioNome"></h6>
                                            <p class="text-muted font-size-11 formDadosEscala"></p>
                                        </div>
                                    </div>
                                </div>

                                <div class="px-2 py-2 border-top" id="divPresencaConfirmada">
                                    <div class="col-12">
                                        <form id="frm_gravar_presenca" name="frm_gravar_presenca">
                                            <input type="hidden" id="iniciar_encerrar" name="iniciar_encerrar">
                                            <input type="hidden" id="brigada_escala_id" name="brigada_escala_id">
                                            <input type="hidden" id="email" name="email">
                                            <input type="hidden" id="foto_real" name="foto_real">

                                            <div class="form-group col-12 pb-3">
                                                <div class="text-center">
                                                    <video class="col-12 form-control" id="video" autoplay></video>
                                                    <canvas class="col-12 form-control d-none" id="canvas"></canvas>
                                                    <img class="col-12 form-control" id="photo" src="" style="display: none;">
                                                </div>
                                                <div class="text-center py-2">
                                                    <button type="button" class="btn btn-primary waves-effect btn-label waves-light" id="btnTirarFoto"><i class="bx bx-photo-album label-icon"></i> Tirar Foto</button>
                                                    <button type="button" class="btn btn-warning waves-effect btn-label waves-light" style="display:none;" id="btnExcluirFoto"><i class="bx bx-trash label-icon"></i> Excluir Foto</button>
                                                </div>
                                            </div>
                                            <div class="form-group col-12 pb-3">
                                                <input type="password" class="form-control" id="password" name="password" placeholder="Digite sua Senha aqui...">
                                            </div>
                                            <div class="form-group col-12 pb-3">
                                                <div class="row">
                                                    <div class="col-6 text-start">
                                                        <button type="button" class="btn btn-success waves-effect btn-label waves-light" id="btnConfirmarPresenca"><i class="bx bx-check-double label-icon"></i> Confirmar</button>
                                                    </div>
                                                    <div class="col-6 text-end">
                                                        <button type="button" class="btn btn-danger waves-effect btn-label waves-light" id="btnCancelarConfirmarPresenca"><i class="bx bx-exit label-icon"></i> Cancelar</button>
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
@endsection

@section('script')
    <!-- scripts_clientes_servicos_qrcode_brigada_presenca.js -->
    <script src="{{ Vite::asset('resources/assets_template/js/scripts_clientes_servicos_qrcode_brigada_presenca.js')}}"></script>
@endsection
