<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8" />
        <title> {{env('APP_NAME')}} | @yield('page_title')</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta content="Premium Multipurpose Admin & Dashboard Template" name="description" />
        <meta content="Themesbrand" name="author" />

        <!-- CSRF-TOKEN -->
        <meta name="csrf-token" content="{{ csrf_token() }}" />

        <!-- App favicon -->
        <link rel="shortcut icon" href="{{ asset('build/assets/images/image_favicon.png') }}" id="appFavicon">

        <!-- Styles -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        @include('layouts.head-css')
    </head>

    @section('body')
        <body class="vertical-collpsed">

        @show

        <!-- Loader -->
        <div id="preloader">
            <div id="status">
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

        <!-- Begin page -->
        <div id="layout-wrapper">

            <!-- Topbar -->
            @include('layouts.topbar')

            <!-- Layout Vertical -->
            @include('layouts.sidebar')

            <!-- Layout Horizontal -->
            @include('layouts.horizontal')

            <!-- Settings User -->
            @include('layouts.settings-user')

            <!-- Start right Content here -->
            <div class="main-content">
                <div class="page-content">
                    <div class="container-fluid">
                        @yield('content')
                    </div>
                </div>

                @include('layouts.footer')
            </div>
        </div>

        @include('layouts.modals')

        <!-- Right Sidebar -->
        @include('layouts.right-sidebar')

        <!-- Verificar Mode e Style (Serve para customizar a tela do sistema) -->
        <script>
            //Mode
            sessionStorage.setItem("is_visited_mode", "{{$userLoggedData['layout_mode']}}");

            //Style
            sessionStorage.setItem("is_visited_style", "{{$userLoggedData['layout_style']}}");
        </script>

        <!-- javascript -->
        @include('layouts.scripts')

    </body>
</html>
