<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8" />
        <title> {{env('APP_NAME')}} | @yield('page_title')</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="shortcut icon" href="{{ asset('build/assets/images/image_favicon.png') }}" id="appFavicon">

        <!-- App favicon -->
        <link rel="shortcut icon" href="{{ asset('build/assets/images/image_favicon.png') }}" id="appFavicon">

        <!-- Styles -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        @include('layouts.head-css')
    </head>
    <body style="background-color: #2a3042;">
        <div class="container">
            <div class="row">
                <div class="navbar-header bg-dark bg-gradient">
                    <div class="d-flex px-4">
                        <span class="logo-lg">
                            <img src="{{ asset('build/assets/images/image_logo_layout_light_menu.png') }}" alt="" width="150">
                        </span>
                    </div>
                    <div class="d-flex">
                        <div class="dropdown d-inline-block">
                            <button type="button" class="btn header-item waves-effect" id="page-header-user-dropdown" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <img class="rounded-circle header-profile-user" src="{{ isset($userLoggedData['avatar']) ? asset($userLoggedData['avatar']) : asset('build/assets/images/users/avatar-0.png') }}" alt="Header Avatar">
                                <span class="d-none d-xl-inline-block ms-1" key="t-henry">{{ucfirst($userLoggedData['name'])}}</span>
                                <i class="mdi mdi-chevron-down d-none d-xl-inline-block"></i>
                            </button>
                            <div class="dropdown-menu dropdown-menu-end">
                                <a class="dropdown-item text-danger" href="javascript:void();" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><i class="bx bx-power-off font-size-16 align-middle me-1 text-danger"></i> <span key="t-logout">Logout</span></a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">@csrf</form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row py-2">
                <div class="col-3 text-center"><img src="{{ asset('build/assets/images/pictograma_1.png') }}" width="50"></div>
                <div class="col-3 text-center"><img src="{{ asset('build/assets/images/pictograma_2.png') }}" width="50"></div>
                <div class="col-3 text-center"><img src="{{ asset('build/assets/images/pictograma_5.png') }}" width="50"></div>
                <div class="col-3 text-center"><img src="{{ asset('build/assets/images/pictograma_7.png') }}" width="50"></div>
            </div>
            <div class="row">
                <div class="text-center col-12 py-2">
{{--                    <div class="card bg-light mb-4" style="min-height: 500px;">--}}
                        <div class="card-header bg-transparent border-bottom">Escolha uma opção</div>
{{--                        <div class="card-body">--}}
{{--                            <blockquote class="card-blockquote mb-0">--}}
                                <div class="row">
                                    <div class="col-6 px-3 py-2">
                                        <button type="button" class="btn btn-dark waves-effect btn-label waves-light font-size-10 col-12 py-3" style="height: 65px;"><i class="bx bx-loader label-icon "></i> {{mb_strtoupper('Meus Clientes')}}</button>
                                    </div>
                                    <div class="col-6 px-3 py-2">
                                        <button type="button" class="btn btn-dark waves-effect btn-label waves-light font-size-10 col-12 py-3" style="height: 65px;"><i class="bx bx-loader label-icon "></i> {{mb_strtoupper('Minhas Visitas Técnicas')}}</button>
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
{{--                            </blockquote>--}}
{{--                        </div>--}}
{{--                    </div>--}}
                </div>
            </div>
            <div class="footer">
                <div class="col-12 text-center"><script>document.write(new Date().getFullYear())</script> © {{env('APP_NAME')}}.</div>
                <div class="col-12 text-center">Design & Develop by Claudino Mil</div>
            </div>
        </div>

        <script type="text/javascript" src="{{ Vite::asset('resources/assets_template/libs/jquery/jquery.min.js') }}"></script>
        <script type="text/javascript" src="{{ Vite::asset('resources/assets_template/libs/bootstrap/bootstrap.min.js') }}"></script>
    </body>
</html>
