@extends('layouts.app-without-nav')

@section('title') Login @endsection

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
                                        <h5 class="text-primary">Bem vindo de volta !</h5>
                                    </div>
                                </div>
                                <div class="col-5 align-self-end">
                                    <img src="{{ asset('build/assets/images/profile-img.png') }}" alt="" class="img-fluid">
                                </div>
                            </div>
                        </div>
                        <div class="card-body pt-0">
                            <div class="auth-logo">
                                <img src="{{ asset('build/assets/images/image_logo_login') }}" style="margin-top: -35px;">
                            </div>
                            <div class="p-2 pt-3">

                                <!-- Erros -->
                                @if (isset($error) and $error != '')
                                    <div class="alert alert-danger mt-1">{{ $error }}</div>
                                @endif

                                @if (Session::has('message'))
                                    <div class="alert alert-success" role="alert">
                                        {{ Session::get('message') }}
                                    </div>
                                @endif

                                <form method="POST" class="form-horizontal" action="{{ route('login') }}">
                                    @csrf

                                    <div class="mb-3">
                                        <label for="email" class="form-label">E-mail</label>
                                        <input type="email" class="form-control" id="email" name="email" placeholder="Entre com o Usuário" required autofocus value="claudinomoraes@yahoo.com.br">
                                        @error('email') <div class="text-danger">{{ $message }}</div> @enderror
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Senha</label>
                                        <div class="input-group auth-pass-inputgroup">
                                            <input type="password" class="form-control" id="password" name="password" placeholder="Entre com a Senha" aria-label="Password" aria-describedby="password-addon" required value="claudino1971">
                                            <button class="btn btn-light " type="button" id="password-addon"><i class="mdi mdi-eye-outline"></i></button>
                                        </div>
                                        @error('password') <div class="text-danger">{{ $message }}</div> @enderror
                                    </div>
                                    <div class="mt-5 d-grid">
                                        <button class="btn btn-primary waves-effect waves-light" type="submit">Login</button>
                                    </div>

                                    @if (Route::has('forget.password.get'))
                                        <div class="mt-4 text-center">
                                            <a href="{{ route('forget.password.get') }}" class="text-muted"><i class="mdi mdi-lock me-1"></i> Esqueceu sua senha?</a>
                                        </div>
                                    @endif

                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
