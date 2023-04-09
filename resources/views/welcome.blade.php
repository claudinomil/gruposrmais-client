<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8" />
    <title> Bem vindo | {{env('APP_NAME')}}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Styles -->
{{--    @vite(['resources/css/app.css', 'resources/js/app.js'])--}}

    @include('layouts.head-css')
</head>
<body style="background-color: #2a3042;">
<div class="my-5 pt-5">
    <div class="container pt-5">
        <div class="row justify-content-center">
            <div class="row col-10 pt-5">
                <div class="col-6 border-light border-end">
                    <div class="float-end">
                        <img src="{{ asset('build/assets/images/welcome_logo.png') }}" alt="" height="100">
                    </div>
                </div>
                <div class="col-6">
                    <div class="float-start">
                        <h1 class="text-light">Bem vindo</h1>
                        <br>
                        <span class="text-light">Administration and Control System</span>
                    </div>
                </div>

                <form id="frm_login" method="get" action="{{ route('login') }}">
                    @csrf

                    <div class="col-12 justify-content-center">
                        <h1 class="text-center">
                            <a class="text-light" href="javascript:frm_login.submit()">Login</a>
                        </h1>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
</body>
</html>
