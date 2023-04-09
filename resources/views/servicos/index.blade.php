@extends('layouts.app')

@section('title') Servicos @endsection

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
                                <div class="col-12 col-md-8 pb-2">
                                    @if (\App\Facades\Permissoes::permissao([$ajaxPrefixPermissaoSubmodulo.'_create'], $userLoggedPermissoes))
                                        <x-button op="1" id="createNewRecord" />
                                    @endif
                                </div>

                                <!-- Pesquisar no Banco -->
                                <div class="col-12 col-md-4 float-end">
                                    <div class="row">
                                        <div class="col-5 float-end px-1">
                                            <select class="form-control" id="pesquisar_field" name="pesquisar_field" placeholder="Campo Pesquisar">
                                                <option value="servicos.name">Nome</option>
                                                <option value="servico_tipos.name">Serviço Tipo</option>
                                            </select>
                                        </div>
                                        <div class="col-5 float-end px-1">
                                            <input type="text" class="form-control" id="pesquisar_value" name="pesquisar_value" placeholder="Valor Pesquisar" required>
                                        </div>
                                        <div class="col-2 float-start ps-1">
                                            <x-button op="17" id="searchRecords" />
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Tabela (Componente Blade) -->
                    @php
                        $colsNames = ['Nome', 'Serviço Tipo'];
                        $colsFields = ['name', 'servicoTipoName'];
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
</div>

<!-- Modal -->
@include('servicos.form')
@endsection

@section('script')
    <!-- scripts_servicos.js -->
    <script src="{{ Vite::asset('resources/assets_template/js/scripts_servicos.js')}}"></script>
@endsection

@section('script-bottom')
@endsection
