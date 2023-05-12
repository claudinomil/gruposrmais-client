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

    @include('Mobile.layouts.head-css')
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
    @include('Mobile.layouts.topbar')

    <!-- Layout Vertical -->
    @include('Mobile.layouts.sidebar')

    <!-- Layout Horizontal -->
{{--    @include('Mobile.layouts.horizontal')--}}

    <!-- Start right Content here -->
        <div class="main-content">
            <div class="page-content">
{{--                <div class="container-fluid">--}}
                    <h5 class="">{{ \App\Facades\Breadcrumb::getCurrentPageTitle() }}</h5>
                    @yield('content')
{{--                </div>--}}
            </div>

            @include('Mobile.layouts.footer')
        </div>
    </div>

    @include('Mobile.layouts.modals')

    <!-- Right Sidebar -->
    @include('Mobile.layouts.right-sidebar')

    <!-- Verificar Mode e Style (Serve para customizar a tela do sistema) -->
    <script>
        //Mode
        sessionStorage.setItem("is_visited_mode", "layout_mode_light");

        //Style
        sessionStorage.setItem("is_visited_style", "layout_style_horizontal_boxed_width");
    </script>

    <!-- javascript -->
    @include('Mobile.layouts.scripts')
    @include('Mobile.layouts.scripts-ajax')
    @include('Mobile.layouts.scripts-profile')
    </body>
</html>
