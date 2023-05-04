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
                                        <h4>Check your Email</h4>
                                        <p class="mb-5">Digite o código de 16 dígitos enviado para o seu e-mail</p>

                                        @if (Session::has('error'))
                                            <div class="alert alert-danger" role="alert">
                                                {{ Session::get('error') }}
                                            </div>
                                        @endif

                                        <form method="POST" action="{{ route('code.confirm.email.post') }}">
                                            @csrf

                                            <input type="hidden" id="email" name="email" value="{{$email}}">

                                            <div class="row">
                                                <div class="col-3">
                                                    <div class="mb-3">
                                                        <label for="token1" class="visually-hidden">Grupo 1</label>
                                                        <input type="text" class="form-control form-control-lg text-center two-step px-1" id="token1" name="token1" maxLength="4">
                                                        @error('token1') <div class="text-danger">{{ $message }}</div> @enderror
                                                    </div>
                                                </div>
                                                <div class="col-3">
                                                    <div class="mb-3">
                                                        <label for="token2" class="visually-hidden">Grupo 2</label>
                                                        <input type="text" class="form-control form-control-lg text-center two-step px-1" id="token2" name="token2" maxLength="4">
                                                        @error('token2') <div class="text-danger">{{ $message }}</div> @enderror
                                                    </div>
                                                </div>
                                                <div class="col-3">
                                                    <div class="mb-3">
                                                        <label for="token3" class="visually-hidden">Grupo 3</label>
                                                        <input type="text" class="form-control form-control-lg text-center two-step px-1" id="token3" name="token3" maxLength="4">
                                                        @error('token3') <div class="text-danger">{{ $message }}</div> @enderror
                                                    </div>
                                                </div>
                                                <div class="col-3">
                                                    <div class="mb-3">
                                                        <label for="token4" class="visually-hidden">Grupo 4</label>
                                                        <input type="text" class="form-control form-control-lg text-center two-step px-1" id="token4" name="token4" maxLength="4">
                                                        @error('token4') <div class="text-danger">{{ $message }}</div> @enderror
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="mt-3 d-grid">
                                                <button class="btn btn-primary waves-effect waves-light" type="submit">Confirme</button>
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
@endsection
