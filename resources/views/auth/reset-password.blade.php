@extends('layouts.app-without-nav')

@section('title') Redefinir senha @endsection

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
                                        <p>Redefina sua senha para entrar no sistema.</p>
                                    </div>
                                </div>
                                <div class="col-5 align-self-end">
                                    <img src="{{ asset('build/assets/images/profile-img.png') }}" alt="" class="img-fluid">
                                </div>
                            </div>
                        </div>
                        <div class="card-body pt-0">
                            <div>
                                <a href="index">
                                    <div class="avatar-md profile-user-wid mb-4">
                                        <span class="avatar-title rounded-circle bg-light">
                                            <img src="{{ asset('build/assets/images/image_logo_login.png') }}" alt="" class="rounded-circle" height="50">
                                        </span>
                                    </div>
                                </a>
                            </div>
                            <div class="p-2">
                                <form method="POST" action="{{ route('reset.password.post') }}">
                                    @csrf

                                    <input type="hidden" name="token" value="{{ $token }}">

                                    <div class="mb-3">
                                        <label for="email" class="form-label">E-mail</label>
                                        <input type="email" class="form-control" id="email" name="email" placeholder="Entre com o Usuário" required autofocus value="claudinomoraes@yahoo.com.br">
                                        @error('email') <div class="text-danger">{{ $message }}</div> @enderror
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Senha</label>
                                        <div class="input-group auth-pass-inputgroup">
                                            <input type="password" class="form-control" id="password" name="password" placeholder="Entre com a nova Senha" aria-label="Password" aria-describedby="password-addon" required>
                                            <button class="btn btn-light " type="button" id="password-addon"><i class="mdi mdi-eye-outline"></i></button>
                                        </div>
                                        @error('password') <div class="text-danger">{{ $message }}</div> @enderror
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Confirm Password</label>
                                        <div class="input-group auth-pass-inputgroup">
                                            <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" placeholder="Confirme a nova Senha" aria-label="Confirm Password" aria-describedby="confirm-password-addon" required>
                                            <button class="btn btn-light " type="button" id="confirm-password-addon"><i class="mdi mdi-eye-outline"></i></button>
                                        </div>
                                        @error('password_confirmation') <div class="text-danger">{{ $message }}</div> @enderror
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
