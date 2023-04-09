<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8" />
        <title> @yield('title') | {{env('APP_NAME')}}</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta content="Premium Multipurpose Admin & Dashboard Template" name="description" />
        <meta content="Themesbrand" name="author" />
        <!-- App favicon -->
        <link rel="shortcut icon" href="{{ asset('build/assets/images/image_favicon') }}" id="appFavicon">

        <!-- Styles -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        @include('layouts.head-css')
    </head>

    @yield('body')

        @yield('content')

{{--        @include('layouts.modals')--}}

        @include('layouts.scripts')

    </body>
</html>
