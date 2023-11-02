@extends('layouts.app')

@section('title') Transações @endsection

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
                                <div class="col-12 col-md-6 pb-2">&nbsp;</div>

                                <!-- Filtro no Banco -->
                                <div class="col-12 col-md-6 float-end">
                                    <input type="hidden" id="filter-crud-filter_crud_tipo_condicao" value="1">
                                    <input type="hidden" id="filter-crud-filter_crud_campo_pesquisar" value="users.name">
                                    <input type="hidden" id="filter-crud-filter_crud_operacao_realizar" value="1">

                                    @php
                                        $selectCampoPesquisar = [
                                        ['value' => 'transacoes.date', 'descricao' => 'Data'],
                                        ['value' => 'transacoes.time', 'descricao' => 'Hora'],
                                        ['value' => 'users.name', 'descricao' => 'Usuário'],
                                        ['value' => 'operacoes.name', 'descricao' => 'Operação'],
                                        ['value' => 'submodulos.name', 'descricao' => 'Submódulo'],
                                        ['value' => 'transacoes.dados', 'descricao' => 'Dados']
                                        ];
                                    @endphp

                                    <x-filter-crud :selectCampoPesquisar=$selectCampoPesquisar />
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Tabela (Componente Blade) -->
                    @php
                        $colsNames = ['Data/Hora', 'Usuário', 'Submódulo/Operação', 'Dados'];
                        $colsFields = ['date', 'userName', 'submoduloName', 'dados'];
                        $colActions = 'not';
                    @endphp

                    <x-table-crud-ajax
                        :numCols="4"
                        :class="'table table-bordered dt-responsive table-striped w-100 class-datatable-1'"
                        :colsNames=$colsNames
                        :colsFields=$colsFields
                        :colActions=$colActions />
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
