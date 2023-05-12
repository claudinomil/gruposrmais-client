@extends('Mobile.layouts.app')
{{--@section('title') <h4 class="mb-sm-0 font-size-18">{{ \App\Facades\Breadcrumb::getCurrentPageTitle() }}</h4> @endsection--}}
@section('content')
    <div id="crudTable">
        <div class="row">

            <!-- Clientes -->
            @if($dashboardsClientes == 1)
                <div class="col-12 col-md-6">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex">
                                <div class="flex-shrink-0 me-3">
                                    <img src="{{ asset('build/assets/images/cliente-img.png') }}" alt="" class="avatar-lg rounded-circle img-thumbnail">
                                </div>
                                <div class="flex-grow-1">
                                    <div class="d-flex">
                                        <div class="flex-grow-1">
                                            <div class="text-muted">
                                                <h5 class="mb-1">Clientes</h5>
                                                <p class="mb-0">{{$content['dashboardsClientesQtd']}} Registro(s)</p>
                                            </div>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="row">
                                        <div class="col-6 pb-2">
                                            <p class="text-muted text-truncate mb-2">Propostas</p>
                                            <h5 class="mb-0">{{$content['dashboardsClientesPropostas']}}</h5>
                                        </div>
                                        <div class="col-6 pb-2">
                                            <p class="text-muted text-truncate mb-2">Visitas Técnicas</p>
                                            <h5 class="mb-0">{{$content['dashboardsClientesVisitasTecnicas']}}</h5>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Propostas -->
            @if($dashboardsPropostas == 1)
                <div class="col-12 col-md-6">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex">
                                <div class="flex-shrink-0 me-3">
                                    <img src="{{ asset('build/assets/images/proposta-img.png') }}" alt="" class="avatar-lg rounded-circle img-thumbnail">
                                </div>
                                <div class="flex-grow-1">
                                    <div class="d-flex">
                                        <div class="flex-grow-1">
                                            <div class="text-muted">
                                                <h5 class="mb-1">Propostas</h5>
                                                <p class="mb-0">{{$content['dashboardsPropostasQtd']}} Registro(s)</p>
                                            </div>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="row">
                                        <div class="col-6 pb-2">
                                            <p class="text-muted text-truncate mb-2">&nbsp;</p>
                                            <h5 class="mb-0">&nbsp;</h5>
                                        </div>
                                        <div class="col-6 pb-2">
                                            <p class="text-muted text-truncate mb-2">&nbsp;</p>
                                            <h5 class="mb-0">&nbsp;</h5>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Visitas Tecnicas -->
            @if($dashboardsVisitasTecnicas == 1)
                <div class="col-12 col-md-6">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex">
                                <div class="flex-shrink-0 me-3">
                                    <img src="{{ asset('build/assets/images/visita_tecnica-img.png') }}" alt="" class="avatar-lg rounded-circle img-thumbnail">
                                </div>
                                <div class="flex-grow-1">
                                    <div class="d-flex">
                                        <div class="flex-grow-1">
                                            <div class="text-muted">
                                                <h5 class="mb-1">Visitas Técnicas</h5>
                                                <p class="mb-0">{{$content['dashboardsVisitasTecnicasQtd']}} Registro(s)</p>
                                            </div>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="row">
                                        <div class="col-6 pb-2">
                                            <p class="text-muted text-truncate mb-2">Aguardando</p>
                                            <h5 class="mb-0">{{$content['dashboardsVisitasTecnicasAguardando']}}</h5>
                                        </div>
                                        <div class="col-6 pb-2">
                                            <p class="text-muted text-truncate mb-2">Executadas</p>
                                            <h5 class="mb-0">{{$content['dashboardsVisitasTecnicasExecutadas']}}</h5>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

        </div>
    </div>
@endsection
