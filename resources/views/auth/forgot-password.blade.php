@extends('layouts.app-without-nav')

@section('title') Recuperar Senha @endsection

@section('body')
    <body>
@endsection

@section('content')
    <div class="account-pages my-5 pt-sm-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8 col-lg-6 col-xl-5">
                    <div class="card overflow-hidden">
                        <div class="bg-primary bg-soft">
                            <div class="row">
                                <div class="col-7">
                                    <div class="text-primary p-4">
                                        <h5 class="text-primary"> Redefinir senha</h5>
                                    </div>
                                </div>
                                <div class="col-5 align-self-end">
                                    <img src="{{ asset('build/assets/images/profile-img.png') }}" alt="" class="img-fluid">
                                </div>
                            </div>
                        </div>
                        <div class="card-body pt-0">
                            <div>
                                <div class="auth-logo">
                                    <img src="{{ asset('build/assets/images/image_logo_login') }}" style="margin-top: -35px;">
                                </div>
                            </div>
                            <div class="p-2">
                                <div class="alert alert-success text-center mb-4" role="alert">Digite seu e-mail e as instruções serão enviadas para você!</div>

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

                                <form method="POST" action="{{ route('forget.password.post') }}">
                                    @csrf

                                    <div class="mb-3">
                                        <label for="useremail" class="form-label">E-mail</label>
                                        <input type="email" class="form-control" id="email" name="email" placeholder="Entre com o E-mail" required autofocus>
                                    </div>
                                    <div class="mt-5 d-grid">
                                        <button class="btn btn-primary waves-effect waves-light" type="submit">Redefinir</button>
                                    </div>
                                    <div class="mt-4 text-center">
                                        <p>Lembrei ? <a href="{{ route('login') }}" class="fw-medium text-primary"> Login aqui</a> </p>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
