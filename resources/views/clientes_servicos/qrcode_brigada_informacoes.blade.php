@extends('layouts.app-qrcodes')

@section('page_title') Clientes Serviços @endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body" style="min-height: 100vh">
                    <div class="text-center mb-2">
                        <h4 class="text-primary mb-1">Cliente Serviço</h4>
                        <p class="text-muted font-size-11 mb-1">{{$cliente_servico['clienteName']}}</p>
                        <p class="text-muted font-size-11 mb-1">{{$cliente_servico['servicoName']}}</p>
                    </div>

                    <!-- Nav tabs -->
                    <ul class="nav nav-tabs nav-tabs-custom nav-justified" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" data-bs-toggle="tab" href="#servico" role="tab" id="tab_servico">
                                <span class="d-block d-sm-none"><i class="mdi mdi-calendar-multiple-check font-size-18"></i></span>
                                <span class="d-sm-block font-size-11">Serviço</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-bs-toggle="tab" href="#brigadistas" role="tab" id="tab_brigadistas">
                                <span class="d-block d-sm-none"><i class="mdi mdi-calendar-account font-size-18"></i></span>
                                <span class="d-sm-block font-size-11">Brigadistas</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-bs-toggle="tab" href="#escalas" role="tab" id="tab_escalas">
                                <span class="d-block d-sm-none"><i class="mdi mdi-calendar-month font-size-18"></i></span>
                                <span class="d-sm-block font-size-11">Escalas</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-bs-toggle="tab" href="#rondas" role="tab" id="tab_rondas">
                                <span class="d-block d-sm-none"><i class="mdi mdi-calendar-range font-size-18"></i></span>
                                <span class="d-sm-block font-size-11">Ronda</span>
                            </a>
                        </li>
                    </ul>

                    <!-- Tab panes -->
                    <div class="tab-content text-muted">
                        <div class="tab-pane active" id="servico" role="tabpanel">
                            <div class="mt-2">
                                <div class="row">
                                    <div class="col-12 col-md-4 pb-2">
                                        <label class="form-label mb-0 small">Status</label>
                                        <input class="form-control form-control-sm" type="text" value="{{$cliente_servico['servicoStatusName']}}" readonly>
                                    </div>
                                    <div class="col-12 col-md-4 pb-2">
                                        <label class="form-label mb-0 small">Funcionário Responsável</label>
                                        <input class="form-control form-control-sm" type="text" value="{{$cliente_servico['funcionarioName']}}" readonly>
                                    </div>
                                    <div class="col-6 col-md-2 pb-2">
                                        <label class="form-label mb-0 small">Data Início</label>
                                        <input class="form-control form-control-sm" type="text" value="{{$cliente_servico['data_inicio']}}" readonly>
                                    </div>
                                    <div class="col-6 col-md-2 pb-2">
                                        <label class="form-label mb-0 small">Data Fim</label>
                                        <input class="form-control form-control-sm" type="text" value="{{$cliente_servico['data_fim']}}" readonly>
                                    </div>
                                    <div class="col-6 col-md-2 pb-2">
                                        <label class="form-label mb-0 small">Escala</label>
                                        <input class="form-control form-control-sm" type="text" value="{{$cliente_servico['escalaTipoName']}}" readonly>
                                    </div>
                                    <div class="col-6 col-md-2 pb-2">
                                        <label class="form-label mb-0 small">Brigadistas Ala</label>
                                        <input class="form-control form-control-sm" type="text" value="{{$cliente_servico['bi_quantidade_brigadistas_por_ala']}}" readonly>
                                    </div>
                                    <div class="col-6 col-md-2 pb-2">
                                        <label class="form-label mb-0 small">Brigadistas Total</label>
                                        <input class="form-control form-control-sm" type="text" value="{{$cliente_servico['bi_quantidade_brigadistas_total']}}" readonly>
                                    </div>
                                    <div class="col-6 col-md-2 pb-2">
                                        <label class="form-label mb-0 small">Hora início ala</label>
                                        <input class="form-control form-control-sm" type="text" value="{{$cliente_servico['bi_hora_inicio_ala']}}" readonly>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="tab-pane" id="brigadistas" role="tabpanel">
                            <div class="mt-2">
                                <div class="table-responsive">
                                    <table class="table mb-0 table-bordered table-striped">
                                        <thead class="table-light font-size-12">
                                            <tr>
                                                <th>Ala</th>
                                                <th>Brigadista</th>
                                            </tr>
                                        </thead>
                                        <tbody class="font-size-11">
                                            @foreach ($brigadistas as $key => $brigadista)
                                                <tr>
                                                    <td style="padding: 0.5rem 0.5rem !important;">{{$brigadista['ala']}}</td>
                                                    <td style="padding: 0.5rem 0.5rem !important;">{{$brigadista['funcionario_nome']}}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <div class="tab-pane" id="escalas" role="tabpanel">
                            <div class="mt-2">
                                <div class="table-responsive">
                                    <table class="table mb-0 table-bordered table-striped">
                                        <thead class="table-light font-size-12">
                                        <tr>
                                            <th>#</th>
                                            <th>Brigadista(s) / Informações</th>
                                        </tr>
                                        </thead>
                                        <tbody class="font-size-11">
                                        @foreach ($escalas as $key => $escala)
                                            @php
                                            //Coluna foto'''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''

                                            //Cores Alas
                                            if ($escala['ala'] == 1) {$corAla = 'bg-success';  $ala = 'Ala 1';}
                                            if ($escala['ala'] == 2) {$corAla = 'bg-primary';  $ala = 'Ala 2';}
                                            if ($escala['ala'] == 3) {$corAla = 'bg-danger';   $ala = 'Ala 3';}
                                            if ($escala['ala'] == 4) {$corAla = 'bg-warning';  $ala = 'Ala 4';}
                                            if ($escala['ala'] == 5) {$corAla = 'bg-pink';     $ala = 'Ala 5';}

                                            //Retorno
                                            $col_foto = "<div class='text-center'>";
                                            $col_foto .= "<img src='".asset($escala['foto'])."' alt='' class='img-thumbnail rounded-circle avatar-sm'>";
                                            $col_foto .= "<br>";
                                            $col_foto .= "<span class='".$corAla." badge p-1'>".$ala."</span>";
                                            $col_foto .= "</div>";

                                            //Coluna Brigadistas / Informações''''''''''''''''''''''''''''''''''''''''''
                                            //Frequência
                                            $frequencia = '';

                                            if ($escala['escala_frequencia_id'] !== null) {
                                                if ($escala['escala_frequencia_id'] == 1) {$frequenciaCor = 'text-success';}
                                                if ($escala['escala_frequencia_id'] == 2) {$frequenciaCor = 'text-warning';}
                                                if ($escala['escala_frequencia_id'] == 3) {$frequenciaCor = 'text-danger';}

                                                $frequencia = ' ('.'<span class="'.$frequenciaCor.'"><b>'.$escala['escalaFrequenciaName'].'</b></span>'.')';
                                            }

                                            //Brigadista
                                            $brigadista_informacoes = '<p>'.$escala['funcionario_nome'].$frequencia.'</p>';

                                            //Data/Hora Previstas
                                            $brigadista_informacoes .= '<p>';
                                            $brigadista_informacoes .= '<b>Chegada Prevista:</b> '.$escala['data_chegada'].' às '.$escala['hora_chegada'].'hs';
                                            $brigadista_informacoes .= '<br>';
                                            $brigadista_informacoes .= '<b>Saída Prevista:</b> '.$escala['data_saida'].' às '.$escala['hora_saida'].'hs';
                                            $brigadista_informacoes .= '</p>';

                                            //Data/Hora Realizadas
                                            if ($escala['data_chegada_real'] !== null) {
                                                $brigadista_informacoes .= '<p>';
                                                $brigadista_informacoes .= '<b>Chegada Realizada:</b> '.$escala['data_chegada_real'].' às '.$escala['hora_chegada_real'].'hs';

                                                if ($escala['data_saida_real'] !== null) {
                                                    $brigadista_informacoes .= '<br>';
                                                    $brigadista_informacoes .= '<b>Saída Realizada:</b> '.$escala['data_saida_real'].' às '.$escala['hora_saida_real'].'hs';
                                                }
                                            }

                                            //Colocar botões com as Rondas já executadas
                                            $btnsRondas = '<p><b>Rondas:</b></p>';
                                            $btnsRondas .= '<div class="row">';

                                            $r = 0;
                                            foreach ($rondas as $ronda) {
                                                if ($escala['id'] == $ronda['brigada_escala_id']) {
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

                                                    $btnsRondas .= '<div class="col-3 text-center pb-1"><button type="button" class="btn btn-outline-primary btn-sm text-center font-size-10 btnViewRonda" data-bs-toggle="tooltip" data-bs-placement="top" title="'.$r_extenso.'" data-id="'.$ronda['id'].'" data-funcionario_nome="'.$escala['funcionario_nome'].'" data-data_chegada="'.$escala['data_chegada'].'" data-hora_chegada="'.$escala['hora_chegada'].'" data-data_saida="'.$escala['data_saida'].'" data-hora_saida="'.$escala['hora_saida'].'" data-data="'.$ronda['data_inicio_ronda'].'" data-hora="'.$ronda['hora_inicio_ronda'].'">R'.$r.'</button></div>';
                                                }
                                            }

                                            $btnsRondas .= '</div>';

                                            $brigadista_informacoes .= $btnsRondas;
                                            @endphp

                                            <tr>
                                                <td>{!! $col_foto !!}</td>
                                                <td>{!! $brigadista_informacoes !!}</td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <div class="tab-pane" id="rondas" role="tabpanel">
                            <p class="pt-2" id="titulo"></p>
                            <div class="font-size-10 pt-2" id="divMedidasSegurancaRondaItens"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <!-- scripts_clientes_servicos_qrcode_brigada_informacoes.js -->
    <script src="{{ Vite::asset('resources/assets_template/js/scripts_clientes_servicos_qrcode_brigada_informacoes.js')}}"></script>
@endsection
