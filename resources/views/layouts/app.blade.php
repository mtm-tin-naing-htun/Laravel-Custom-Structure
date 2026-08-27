<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title>{{ config('app.name') }}</title>
    <meta name="viewport" content="width=device-width,initial-scale=1.0" />
    <link rel="favicon" href="/favicon.ico" />
    <meta name="format-detection" content="telephone=no" />
    <meta name="googlebot" content="noindex">
    <meta name="robots" content="noindex">

    <!-- Styles & Scripts (Vite) -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body>
    <!-- headerー-->
    @include('includes.common.header')
    <!-- content -->
    <main id="main">
        @yield('content')
    </main>
    <!-- footer -->
    @include('includes.common.footer')
    <!-- modal -->
    @yield('page_modal')
    <!-- scripts-->
    @section('script')

    @show
</body>

</html>
