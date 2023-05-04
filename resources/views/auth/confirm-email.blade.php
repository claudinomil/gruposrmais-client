@extends('layouts.app-without-nav')

@section('title') Recuperar Senha @endsection

@section('body')
    <body style="background-color: #2a3042;">
@endsection

@section('content')
    <div class="account-pages my-5 pt-sm-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8 col-lg-6 col-xl-5">
                    <div class="card">
                        <div class="card-body">
                            <div class="p-2">
                                <div class="text-center">
                                    <div class="avatar-md mx-auto">
                                        <div class="avatar-title rounded-circle bg-light">
                                            <i class="bx bxs-envelope h1 mb-0 text-primary"></i>
                                        </div>
                                    </div>
                                    <div class="p-2 mt-4">
                                        <h4>Usuário com e-mail não verificado</h4>
                                        <p>Enviaremos um e-mail com um código de verificação para:</p>
                                        <p><span class="fw-semibold">@if (session('email')){{ session('email') }}@endif</span></p>
                                        <div class="mt-4">
                                            @if (Session::has('message'))
                                                <div class="alert alert-success" role="alert">
                                                    {{ Session::get('message') }}
                                                </div>
                                            @endif

                                            @if (Session::has('error'))
                                                <div class="alert alert-danger" role="alert">
                                                    {{ Session::get('error') }}
                                                </div>
                                            @endif

                                            <form method="POST" action="{{ route('confirm.email.post') }}">
                                                @csrf

                                                <input type="hidden" id="email" name="email" value="@if (session('email')){{ session('email') }}@endif">

                                                <div class="mt-3 d-grid">

                                                    @if (session('email'))
                                                        <button class="btn btn-primary waves-effect waves-light" type="submit">Enviar</button>
                                                    @endif

                                                </div>
                                                <div class="mt-4 text-center">
                                                    <p>Retornar para Login <a href="{{ route('login') }}" class="fw-medium text-primary"> aqui</a> </p>
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
    </div>
@endsection
