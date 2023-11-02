@extends('layouts.app')

@section('title') Clientes Serviços @endsection

@section('css')
@endsection

@section('content')

    @component('components.breadcrumb')
        @section('page_title') {{ \App\Facades\Breadcrumb::getCurrentPageTitle() }} @endsection
    @endcomponent

<div id="crudTable">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <!-- Botoes -->
                    <div class="row">
                        <div class="col-12">
                            <div class="row">

                                <!-- Botões -->
                                <div class="col-12 col-md-6 pb-2">
                                    @if (\App\Facades\Permissoes::permissao([$ajaxPrefixPermissaoSubmodulo.'_create'], $userLoggedPermissoes))
                                        <x-button-crud op="1" class="crudIncluirRegistro" />
                                    @endif
                                </div>

                                <!-- Filtro no Banco -->
                                <div class="col-12 col-md-6 float-end">
                                    <input type="hidden" id="filter-crud-filter_crud_tipo_condicao" value="1">
                                    <input type="hidden" id="filter-crud-filter_crud_campo_pesquisar" value="clientes.name">
                                    <input type="hidden" id="filter-crud-filter_crud_operacao_realizar" value="1">

                                    @php
                                        $selectCampoPesquisar = [
                                        ['value' => 'clientes.name', 'descricao' => 'Nome']
                                        ];
                                    @endphp

                                    <x-filter-crud :selectCampoPesquisar=$selectCampoPesquisar />
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Tabela (Componente Blade) -->
                    @php
                        $colsNames = ['Status', 'Cliente/Funcionário', 'Serviço', 'Datas'];
                        $colsFields = ['status', 'cliente_funcionario', 'servicoName', 'datas'];
                        $colActions = 'yes';
                    @endphp

                    <x-table-crud-ajax
                        :numCols="3"
                        :class="'table table-bordered dt-responsive table-striped nowrap w-100 class-datatable-1'"
                        :colsNames=$colsNames
                        :colsFields=$colsFields
                        :colActions=$colActions />
                </div>
            </div>
        </div>
    </div>

    <!-- Visualizar QRCode -->
    <div class="modal fade modal-qrcode" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">QRCodes</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-center">
                    <div class="row">
                        <div class="col-12 col-md-6 text-center">
                            <img src="" width="200" id="imgQRCode1">
                        </div>
                        <div class="col-12 col-md-6 text-center">
                            <img src="" width="200" id="imgQRCode2">
                        </div>
                        <div class="col-12 col-md-6 text-center">
                            <img src="" width="200" id="imgQRCode3">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

<!-- Modal -->
@include('clientes_servicos.form')
@endsection

@section('script')
    <!-- scripts_clientes_servicos.js -->
    <script src="{{ Vite::asset('resources/assets_template/js/scripts_clientes_servicos.js')}}"></script>
@endsection

@section('script-bottom')
@endsection
