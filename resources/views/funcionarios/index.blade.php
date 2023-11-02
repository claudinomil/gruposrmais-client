@extends('layouts.app')

@section('title') Funcionários @endsection

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
                                    <input type="hidden" id="filter-crud-filter_crud_campo_pesquisar" value="funcionarios.name">
                                    <input type="hidden" id="filter-crud-filter_crud_operacao_realizar" value="1">

                                    @php
                                        $selectCampoPesquisar = [
                                        ['value' => 'funcionarios.name', 'descricao' => 'Nome'],
                                        ['value' => 'funcionarios.identidade', 'descricao' => 'Identidade'],
                                        ['value' => 'identidade_orgaos.name', 'descricao' => 'Órgão Identidade'],
                                        ['value' => 'funcionarios.cpf', 'descricao' => 'CPF'],
                                        ['value' => 'generos.name', 'descricao' => 'Gênero'],
                                        ['value' => 'estados_civis.name', 'descricao' => 'Estado Civil'],
                                        ['value' => 'funcionarios.mae', 'descricao' => 'Mãe'],
                                        ['value' => 'funcionarios.pai', 'descricao' => 'Pai'],
                                        ['value' => 'funcionarios.email', 'descricao' => 'E-mail']
                                        ];
                                    @endphp

                                    <x-filter-crud :selectCampoPesquisar=$selectCampoPesquisar />
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Tabela (Componente Blade) -->
                    @php
                        $colsNames = ['#', 'Nome', 'Nascimento', 'Departamento', 'Função'];
                        $colsFields = ['foto', 'name', 'data_nascimento', 'departamentoName', 'funcaoName'];
                        $colActions = 'yes';
                    @endphp

                    <x-table-crud-ajax
                        :numCols="5"
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
@include('funcionarios.form')
@endsection

@section('script')
    <!-- scripts_funcionarios.js -->
    <script src="{{ Vite::asset('resources/assets_template/js/scripts_funcionarios.js')}}"></script>
@endsection

@section('script-bottom')
@endsection
