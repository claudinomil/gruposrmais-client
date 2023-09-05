<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8" />
        <title> {{env('APP_NAME')}} | @yield('page_title')</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <!-- CSRF-TOKEN -->
        <meta name="csrf-token" content="{{ csrf_token() }}" />

        <!-- App favicon -->
        <link rel="shortcut icon" href="{{ asset('build/assets/images/image_favicon.png') }}" id="appFavicon">

        <!-- Styles -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        @include('layouts.head-css')
    </head>
    <body style="background-color: #2a3042;">
        <!-- Loader -->
        <div id="preloader">
            <div id="statusPreloader">
                <div class="spinner-chase">
                    <div class="chase-dot"></div>
                    <div class="chase-dot"></div>
                    <div class="chase-dot"></div>
                    <div class="chase-dot"></div>
                    <div class="chase-dot"></div>
                    <div class="chase-dot"></div>
                </div>
            </div>
        </div>

        <!-- Tela de Entrada -->
        <div class="col-12" id="splash-screen">
            <div class="col-12 mt-5 pt-5">
                <div class="col-12 text-center">
                    <img src="{{ asset('build/assets/images/welcome_logo.png') }}" class="col-6">
                </div>
                <div class="col-12 text-center pt-3">
                    <h1 class="text-light">Bem vindo</h1>
                    <span class="text-light">Sistema de Administração e Controle</span>
                </div>
            </div>
        </div>

        <!-- Conteúdo -->
        <div class="col-12" style="display: none;" id="content-screen">
            <!-- Topbar -->
            <header id="page-topbar">
                <div class="navbar-header" style="background: #2a3042;">
                    <div class="d-flex">
                        <div style="width: auto; padding: 0 1.5rem; text-align: center; width: 250px;">
                            <span class="logo-sm">
                                <img src="{{ asset('build/assets/images/image_logo_layout_light_menu.png') }}" height="35">
                            </span>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Content -->
            <div style="padding: 5rem 0rem 3rem 0rem;">
                <div class="container-fluid">
                    @yield('content')
                </div>
            </div>

            <!-- Footer -->
            <footer class="footer" style="left: 0px !important;">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-sm-6">
                            <script>document.write(new Date().getFullYear())</script> © {{env('APP_NAME')}}.
                        </div>
                        <div class="col-sm-6">
                            <div class="text-sm-end d-none d-sm-block">
                                Design & Develop by Claudino Mil
                            </div>
                        </div>
                    </div>
                </div>
            </footer>
        </div>

        <!-- javascript -->
        @include('layouts.scripts')
    </body>
</html>
