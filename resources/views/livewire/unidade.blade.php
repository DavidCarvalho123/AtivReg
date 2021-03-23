<div>

<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <title>{{ config('app.name'), 'Laravel' }}</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!--===============================================================================================-->
        <link rel="icon" type="image/png" href="{{ asset('templatelogin/images/icons/favicon.ico')}}"/>
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
            <div class="limiter">
                <div class="container-login100">
                    <div class="wrap-login100">
                        <form class="login100-form validate-form" wire:submit.prevent="entrar">
                            <span class="login100-form-title p-b-26" style="font-size: 28px;">
                                Escolha a unidade para entrar
                            </span>
                            <span class="login100-form-title p-b-48" style="padding-bottom: 20px;">
                                <i class="zmdi zmdi-font"></i>
                            </span>

                            @if ($errors->any() == true)
                            <div class="alert alert-danger" role="alert">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li style="font-size: 1rem; font-family:Poppins-Regular, sans-serif;">{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                            @endif

                            <div class="wrap-input100">
                                <select class="input100 form-select" wire:model="selected" aria-label="Default select example">
                                    <option value="" selected>Carregue para abrir</option>
                                    @foreach ($unidades as $unidade)
                                        <option value="{{ $unidade->id }}">{{ $unidade->unidade }}</option>
                                    @endforeach
                                </select>
                                <span class="focus-input100" data-placeholder=""></span>
                            </div>

                            <div class="container-login100-form-btn">
                                <div class="wrap-login100-form-btn">
                                    <div class="login100-form-bgbtn"></div>
                                    <button class="login100-form-btn" type="submit">
                                        Entrar
                                    </button>
                                </div>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
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
</div>
