<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <title>{{ config('app.name'), 'Laravel' }}</title>
        <meta content="" name="description">
        <meta content="" name="keywords">

        <!-- Favicons -->
        <link rel="icon" type="image/png" href="{{ asset('img/logoAR.png')}}"/>


        <!-- Google Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Roboto:300,300i,400,400i,500,500i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

        <!-- Vendor CSS Files -->
        <link href="{{ asset('softland/assets/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
        <link href="{{ asset('softland/assets/vendor/icofont/icofont.min.css') }}" rel="stylesheet">
        <link href="{{ asset('softland/assets/vendor/aos/aos.css') }}" rel="stylesheet">
        <link href="{{ asset('softland/assets/vendor/line-awesome/css/line-awesome.min.css') }}" rel="stylesheet">
        <link href="{{ asset('softland/assets/vendor/owl.carousel/assets/owl.carousel.min.css') }}" rel="stylesheet">

        <!-- Template Main CSS File -->
        <link href="{{ asset('softland/assets/css/style.css') }}" rel="stylesheet">
        @livewireStyles
        <!-- =======================================================
        * Template Name: SoftLand - v2.2.1
        * Template URL: https://bootstrapmade.com/softland-bootstrap-app-landing-page-template/
        * Author: BootstrapMade.com
        * License: https://bootstrapmade.com/license/
        ======================================================== -->
    </head>

    <body>
        @include('softlandparts.navs')

        @yield('content')


        <main id="main">
            @yield('inicial')
        </main><!-- End #main -->


        @include('softlandparts.footer')

        <a href="#" class="back-to-top"><i class="icofont-simple-up"></i></a>

        <!-- Vendor JS Files -->
        @livewireScripts
        <script src="{{ asset('softland/assets/vendor/jquery/jquery.min.js') }}"></script>
        <script src="{{ asset('softland/assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
        <script src="{{ asset('softland/assets/vendor/jquery.easing/jquery.easing.min.js') }}"></script>
        <script src="{{ asset('softland/assets/vendor/php-email-form/validate.js') }}"></script>
        <script src="{{ asset('softland/assets/vendor/aos/aos.js') }}"></script>
        <script src="{{ asset('softland/assets/vendor/owl.carousel/owl.carousel.min.js') }}"></script>
        <script src="{{ asset('softland/assets/vendor/jquery-sticky/jquery.sticky.js') }}"></script>

        <!-- Template Main JS File -->
        <script src="{{ asset('softland/assets/js/main.js') }}"></script>

    </body>

</html>
