@extends('Mobile.layouts.app')

@section('content')
    <div class="row">
        @foreach ($userLoggedMenuSubmodulos as $key => $submodulo)
            @if($submodulo['Mobile'] == 1)
                <div class="col-6 col-sm-4 col-md-3 px-3 py-2">
                    <button type="button" class="btn btn-dark waves-effect btn-label waves-light font-size-10 col-12 py-3" onclick="window.location='{{route($submodulo['menu_route'].'.index')}}'" style="height: 65px;"><i class="bx bx-loader label-icon "></i> {{mb_strtoupper($submodulo['menu_text_mobile'])}}</button>
                </div>
            @endif
        @endforeach




{{--        <div class="col-6 px-3 py-2">--}}
{{--            <button type="button" class="btn btn-dark waves-effect btn-label waves-light font-size-10 col-12 py-3" onclick="window.location='clientes'" style="height: 65px;"><i class="bx bx-loader label-icon "></i> {{mb_strtoupper('Meus Clientes')}}</button>--}}
{{--        </div>--}}
{{--        <div class="col-6 px-3 py-2">--}}
{{--            <button type="button" class="btn btn-dark waves-effect btn-label waves-light font-size-10 col-12 py-3" onclick="window.location='visitas_tecnicas'" style="height: 65px;"><i class="bx bx-loader label-icon "></i> {{mb_strtoupper('Minhas Visitas Técnicas')}}</button>--}}
{{--        </div>--}}
{{--        <div class="col-6 px-3 py-2">--}}
{{--            <button type="button" class="btn btn-dark waves-effect btn-label waves-light font-size-10 col-12 py-3" onclick="window.location='propostas'" style="height: 65px;"><i class="bx bx-loader label-icon "></i> {{mb_strtoupper('Minhas Propostas')}}</button>--}}
{{--        </div>--}}




        <!-- MODELOS -->
{{--            <div class="col-6 px-3 py-2">--}}
{{--                <button type="button" class="btn btn-dark waves-effect btn-label waves-light font-size-10 col-12 py-3" onclick="alert('Em desenvolvimento.')" style="height: 65px;"><i class="bx bx-loader label-icon "></i> {{mb_strtoupper('Minhas Propostas')}}</button>--}}
{{--            </div>--}}
{{--            <div class="col-6 px-3 py-2">--}}
{{--                <button type="button" class="btn btn-dark waves-effect btn-label waves-light font-size-10 col-12 py-3" onclick="alert('Em desenvolvimento.')" style="height: 65px;"><i class="bx bx-loader label-icon "></i> {{mb_strtoupper('Minhas Recargas')}}</button>--}}
{{--            </div>--}}
{{--            <div class="col-6 px-3 py-2">--}}
{{--                <button type="button" class="btn btn-dark waves-effect btn-label waves-light font-size-10 col-12 py-3" onclick="alert('Em desenvolvimento.')" style="height: 65px;"><i class="bx bx-loader label-icon "></i> {{mb_strtoupper('Notificações')}}</button>--}}
{{--            </div>--}}
{{--            <div class="col-6 px-3 py-2">--}}
{{--                <button type="button" class="btn btn-dark waves-effect btn-label waves-light font-size-10 col-12 py-3" onclick="alert('Em desenvolvimento.')" style="height: 65px;"><i class="bx bx-loader label-icon "></i> {{mb_strtoupper('Dashboard')}}</button>--}}
{{--            </div>--}}
{{--            <div class="col-6 px-3 py-2">--}}
{{--                <button type="button" class="btn btn-dark waves-effect btn-label waves-light font-size-10 col-12 py-3" onclick="alert('Em desenvolvimento.')" style="height: 65px;"><i class="bx bx-loader label-icon "></i> {{mb_strtoupper('Minhas Propostas')}}</button>--}}
{{--            </div>--}}
{{--            <div class="col-6 px-3 py-2">--}}
{{--                <button type="button" class="btn btn-dark waves-effect btn-label waves-light font-size-10 col-12 py-3" onclick="alert('Em desenvolvimento.')" style="height: 65px;"><i class="bx bx-loader label-icon "></i> {{mb_strtoupper('Minhas Recargas')}}</button>--}}
{{--            </div>--}}
{{--            <div class="col-6 px-3 py-2">--}}
{{--                <button type="button" class="btn btn-dark waves-effect btn-label waves-light font-size-10 col-12 py-3" onclick="alert('Em desenvolvimento.')" style="height: 65px;"><i class="bx bx-loader label-icon "></i> {{mb_strtoupper('Notificações')}}</button>--}}
{{--            </div>--}}
{{--            <div class="col-6 px-3 py-2">--}}
{{--                <button type="button" class="btn btn-dark waves-effect btn-label waves-light font-size-10 col-12 py-3" onclick="alert('Em desenvolvimento.')" style="height: 65px;"><i class="bx bx-loader label-icon "></i> {{mb_strtoupper('Dashboard')}}</button>--}}
{{--            </div>--}}
{{--            <div class="col-6 px-3 py-2">--}}
{{--                <button type="button" class="btn btn-dark waves-effect btn-label waves-light font-size-10 col-12 py-3" onclick="alert('Em desenvolvimento.')" style="height: 65px;"><i class="bx bx-loader label-icon "></i> {{mb_strtoupper('Minhas Propostas')}}</button>--}}
{{--            </div>--}}
{{--            <div class="col-6 px-3 py-2">--}}
{{--                <button type="button" class="btn btn-dark waves-effect btn-label waves-light font-size-10 col-12 py-3" onclick="alert('Em desenvolvimento.')" style="height: 65px;"><i class="bx bx-loader label-icon "></i> {{mb_strtoupper('Minhas Recargas')}}</button>--}}
{{--            </div>--}}
{{--            <div class="col-6 px-3 py-2">--}}
{{--                <button type="button" class="btn btn-dark waves-effect btn-label waves-light font-size-10 col-12 py-3" onclick="alert('Em desenvolvimento.')" style="height: 65px;"><i class="bx bx-loader label-icon "></i> {{mb_strtoupper('Notificações')}}</button>--}}
{{--            </div>--}}
{{--            <div class="col-6 px-3 py-2">--}}
{{--                <button type="button" class="btn btn-dark waves-effect btn-label waves-light font-size-10 col-12 py-3" onclick="alert('Em desenvolvimento.')" style="height: 65px;"><i class="bx bx-loader label-icon "></i> {{mb_strtoupper('Dashboard')}}</button>--}}
{{--            </div>--}}
{{--            <div class="col-6 px-3 py-2">--}}
{{--                <button type="button" class="btn btn-dark waves-effect btn-label waves-light font-size-10 col-12 py-3" onclick="alert('Em desenvolvimento.')" style="height: 65px;"><i class="bx bx-loader label-icon "></i> {{mb_strtoupper('Notificações')}}</button>--}}
{{--            </div>--}}
{{--            <div class="col-6 px-3 py-2">--}}
{{--                <button type="button" class="btn btn-dark waves-effect btn-label waves-light font-size-10 col-12 py-3" onclick="alert('Em desenvolvimento.')" style="height: 65px;"><i class="bx bx-loader label-icon "></i> {{mb_strtoupper('Dashboard')}}</button>--}}
{{--            </div>--}}
{{--            <div class="col-6 px-3 py-2">--}}
{{--                <button type="button" class="btn btn-dark waves-effect btn-label waves-light font-size-10 col-12 py-3" onclick="alert('Em desenvolvimento.')" style="height: 65px;"><i class="bx bx-loader label-icon "></i> {{mb_strtoupper('Notificações')}}</button>--}}
{{--            </div>--}}
{{--            <div class="col-6 px-3 py-2">--}}
{{--                <button type="button" class="btn btn-dark waves-effect btn-label waves-light font-size-10 col-12 py-3" onclick="alert('Em desenvolvimento.')" style="height: 65px;"><i class="bx bx-loader label-icon "></i> {{mb_strtoupper('Dashboard')}}</button>--}}
{{--            </div>--}}
{{--            <div class="col-6 px-3 py-2">--}}
{{--                <button type="button" class="btn btn-dark waves-effect btn-label waves-light font-size-10 col-12 py-3" onclick="alert('Em desenvolvimento.')" style="height: 65px;"><i class="bx bx-loader label-icon "></i> {{mb_strtoupper('Notificações')}}</button>--}}
{{--            </div>--}}
{{--            <div class="col-6 px-3 py-2">--}}
{{--                <button type="button" class="btn btn-dark waves-effect btn-label waves-light font-size-10 col-12 py-3" onclick="alert('Em desenvolvimento.')" style="height: 65px;"><i class="bx bx-loader label-icon "></i> {{mb_strtoupper('Dashboard')}}</button>--}}
{{--            </div>--}}
{{--            <div class="col-6 px-3 py-2">--}}
{{--                <button type="button" class="btn btn-dark waves-effect btn-label waves-light font-size-10 col-12 py-3" onclick="alert('Em desenvolvimento.')" style="height: 65px;"><i class="bx bx-loader label-icon "></i> {{mb_strtoupper('Notificações')}}</button>--}}
{{--            </div>--}}
{{--            <div class="col-6 px-3 py-2">--}}
{{--                <button type="button" class="btn btn-dark waves-effect btn-label waves-light font-size-10 col-12 py-3" onclick="alert('Em desenvolvimento.')" style="height: 65px;"><i class="bx bx-loader label-icon "></i> {{mb_strtoupper('Dashboard')}}</button>--}}
{{--            </div>--}}
{{--            <div class="col-6 px-3 py-2">--}}
{{--                <button type="button" class="btn btn-dark waves-effect btn-label waves-light font-size-10 col-12 py-3" onclick="alert('Em desenvolvimento.')" style="height: 65px;"><i class="bx bx-loader label-icon "></i> {{mb_strtoupper('Notificações')}}</button>--}}
{{--            </div>--}}
{{--            <div class="col-6 px-3 py-2">--}}
{{--                <button type="button" class="btn btn-dark waves-effect btn-label waves-light font-size-10 col-12 py-3" onclick="alert('Em desenvolvimento.')" style="height: 65px;"><i class="bx bx-loader label-icon "></i> {{mb_strtoupper('Dashboard')}}</button>--}}
{{--            </div>--}}
{{--            <div class="col-6 px-3 py-2">--}}
{{--                <button type="button" class="btn btn-dark waves-effect btn-label waves-light font-size-10 col-12 py-3" onclick="alert('Em desenvolvimento.')" style="height: 65px;"><i class="bx bx-loader label-icon "></i> {{mb_strtoupper('Notificações')}}</button>--}}
{{--            </div>--}}
{{--            <div class="col-6 px-3 py-2">--}}
{{--                <button type="button" class="btn btn-dark waves-effect btn-label waves-light font-size-10 col-12 py-3" onclick="alert('Em desenvolvimento.')" style="height: 65px;"><i class="bx bx-loader label-icon "></i> {{mb_strtoupper('Dashboard')}}</button>--}}
{{--            </div>--}}





    </div>
@endsection
