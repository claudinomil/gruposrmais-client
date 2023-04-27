@extends('mobile.layouts.layout')

@section('content')
    <div class="text-center col-12 py-2">
        <div class="text-light pb-2">{{mb_strtoupper('Escolha uma opção')}}</div>
        <div class="row">
            <div class="col-6 px-3 py-2">
                <button type="button" class="btn btn-dark waves-effect btn-label waves-light font-size-10 col-12 py-3" onclick="window.location='{{route('mobile_clientes.index')}}'" style="height: 65px;"><i class="bx bx-loader label-icon "></i> {{mb_strtoupper('Meus Clientes')}}</button>
            </div>
            <div class="col-6 px-3 py-2">
                <button type="button" class="btn btn-dark waves-effect btn-label waves-light font-size-10 col-12 py-3" onclick="window.location='{{route('mobile_visitas_tecnicas.index')}}'" style="height: 65px;"><i class="bx bx-loader label-icon "></i> {{mb_strtoupper('Minhas Visitas Técnicas')}}</button>
            </div>
            <div class="col-6 px-3 py-2">
                <button type="button" class="btn btn-dark waves-effect btn-label waves-light font-size-10 col-12 py-3" style="height: 65px;"><i class="bx bx-loader label-icon "></i> {{mb_strtoupper('Minhas Propostas')}}</button>
            </div>
            <div class="col-6 px-3 py-2">
                <button type="button" class="btn btn-dark waves-effect btn-label waves-light font-size-10 col-12 py-3" style="height: 65px;"><i class="bx bx-loader label-icon "></i> {{mb_strtoupper('Minhas Recargas')}}</button>
            </div>
            <div class="col-6 px-3 py-2">
                <button type="button" class="btn btn-dark waves-effect btn-label waves-light font-size-10 col-12 py-3" style="height: 65px;"><i class="bx bx-loader label-icon "></i> {{mb_strtoupper('Notificações')}}</button>
            </div>
            <div class="col-6 px-3 py-2">
                <button type="button" class="btn btn-dark waves-effect btn-label waves-light font-size-10 col-12 py-3" style="height: 65px;"><i class="bx bx-loader label-icon "></i> {{mb_strtoupper('Dashboard')}}</button>
            </div>
        </div>
    </div>
@endsection
