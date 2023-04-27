@extends('mobile.layouts.layout')

@section('content')
    <div class="col-12 py-2">
        <div class="text-light text-center pb-2">{{mb_strtoupper('Meus Clientes')}}</div>
        <div id="crudTable">
            <div class="bg-white rounded py-2 px-2">
                <!-- Botoes -->
                <div class="row">
                    <div class="row">
                        <div class="col-12 col-md-8 pb-2">
                            <!-- Botão Voltar Menu Principal -->
                            <button type="button" class="btn btn-secondary waves-effect btn-label waves-light font-size-10 mobileVoltarMenuPrincipal" onclick="window.location='{{route('mobile.index')}}'" data-bs-toggle="tooltip" data-bs-placement="top" title="Voltar ao Menu Principal"><i class="fa fa-arrow-left label-icon font-size-10"></i> Menu</button>
                        </div>
                    </div>
                </div>

                <!-- Tabela (Componente Blade) -->
                @php
                    $colsNames = ['Cliente', 'Data'];
                    $colsFields = ['clienteName', 'data_visita'];
                    $colActions = 'no';
                @endphp

                <x-table-mobile-ajax
                    :numCols="2"
                    :class="'table table-dark table-bordered mb-0 nowrap font-size-10'"
                    :colsNames=$colsNames
                    :colsFields=$colsFields
                    :colActions=$colActions />
            </div>
        </div>
    </div>
@endsection
