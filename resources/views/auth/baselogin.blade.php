<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <title>{{ config('app.name'), 'Laravel' }}</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!--===============================================================================================-->
        <link rel="icon" type="image/png" href="{{ asset('img/logoAR.png')}}"/>
        <!--===============================================================================================-->
        <link rel="stylesheet" type="text/css" href="{{ asset('templatelogin/vendor/bootstrap/css/bootstrap.min.css')}}">
        <!--===============================================================================================-->
        <link rel="stylesheet" type="text/css" href="{{ asset('templatelogin/fonts/font-awesome-4.7.0/css/font-awesome.min.css')}}">
        <!--===============================================================================================-->
        <link rel="stylesheet" type="text/css" href="{{ asset('templatelogin/fonts/iconic/css/material-design-iconic-font.min.css')}}">
        <!--===============================================================================================-->
        <link rel="stylesheet" type="text/css" href="{{ asset('templatelogin/vendor/animate/animate.css')}}">
        <!--===============================================================================================-->
        <link rel="stylesheet" type="text/css" href="{{ asset('templatelogin/vendor/css-hamburgers/hamburgers.min.css')}}">
        <!--===============================================================================================-->
        <link rel="stylesheet" type="text/css" href="{{ asset('templatelogin/vendor/animsition/css/animsition.min.css')}}">
        <!--===============================================================================================-->
        <link rel="stylesheet" type="text/css" href="{{ asset('templatelogin/vendor/select2/select2.min.css')}}">
        <!--===============================================================================================-->
        <link rel="stylesheet" type="text/css" href="{{ asset('templatelogin/vendor/daterangepicker/daterangepicker.css')}}">
        <!--===============================================================================================-->
        <link rel="stylesheet" type="text/css" href="{{ asset('templatelogin/css/util.css')}}">
        <link rel="stylesheet" type="text/css" href="{{ asset('templatelogin/css/main.css')}}">
        <link rel="stylesheet" type="text/css" href="{{ asset('templatelogin/css/meu.css')}}">
        <!--===============================================================================================-->
        @livewireStyles
    </head>
    <body>
        <div id="app">
            @livewire('login')
        </div>
        @livewireScripts
        <!--===============================================================================================-->
        <script src="{{ asset('templatelogin/vendor/jquery/jquery-3.2.1.min.js') }}"></script>
        <!--===============================================================================================-->
        <script src="{{ asset('templatelogin/vendor/animsition/js/animsition.min.js') }}"></script>
        <!--===============================================================================================-->
        <script src="{{ asset('templatelogin/vendor/bootstrap/js/popper.js') }}"></script>
        <script src="{{ asset('templatelogin/vendor/bootstrap/js/bootstrap.min.js') }}"></script>
        <!--===============================================================================================-->
        <script src="{{ asset('templatelogin/vendor/select2/select2.min.js') }}"></script>
        <!--===============================================================================================-->
        <script src="{{ asset('templatelogin/vendor/daterangepicker/moment.min.js') }}"></script>
        <script src="{{ asset('templatelogin/vendor/daterangepicker/daterangepicker.js') }}"></script>
        <!--===============================================================================================-->
        <script src="{{ asset('templatelogin/vendor/countdowntime/countdowntime.js') }}"></script>
        <!--===============================================================================================-->
        <script src="{{ asset('templatelogin/js/main.js') }}"></script>
    </body>
</html>
