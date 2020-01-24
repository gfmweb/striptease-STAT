<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
{{--
    Использован этот шаблон админки https://bootstraptema.ru/_sf/36/3636.html
--}}
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Stat BVCRM</title>
    <!-- Favicon icon -->
    <link rel="apple-touch-icon" sizes="180x180" href="/img/icons/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/img/icons/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/img/icons/favicon-16x16.png">
    <link rel="manifest" href="/img/icons/site.webmanifest">
    <link rel="mask-icon" href="/img/icons/safari-pinned-tab.svg" color="#44c407">
    <link rel="shortcut icon" href="/img/icons/favicon.ico">
    <meta name="msapplication-TileColor" content="#00a300">
    <meta name="msapplication-config" content="/img/icons/browserconfig.xml">
    <meta name="theme-color" content="#ffffff">

    <link href="{{ asset('/vendor/ule/css/style.css') }}" rel="stylesheet">
    <link href="/css/style.css?<?=time()?>" rel="stylesheet">
    <script src="{{ asset('/vendor/ule/js/modernizr-3.6.0.min.js') }}"></script>
    <script type="text/javascript"> const _token = '{{ csrf_token() }}';</script>
    @stack('css')
    @yield('css')
</head>

<body class="v-light vertical-nav fix-header fix-sidebar">
@yield('body')
<!-- Common JS -->
<script src="{{ asset('/vendor/common/common.min.js') }}"></script>
<!-- Custom script -->
<script src="{{ asset('/vendor/ule/js/custom.min.js') }}"></script>
@stack('js')
@yield('js')
</body>

</html>
