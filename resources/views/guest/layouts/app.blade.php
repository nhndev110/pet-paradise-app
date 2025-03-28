<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
        <meta name="msapplication-config" content="{{ asset('guest/plugins/images/icons/browserconfig.xml') }}">
        <link rel="stylesheet" href="{{ asset('guest/plugins/css/line-awesome/css/line-awesome.min.css') }}">
        <!-- Plugins CSS File -->
        <link rel="stylesheet" href="{{ asset('guest/plugins/css/bootstrap.min.css') }}">
        <link rel="stylesheet" href="{{ asset('guest/plugins/css/plugins/owl-carousel/owl.carousel.css') }}">
        <link rel="stylesheet" href="{{ asset('guest/plugins/css/plugins/magnific-popup/magnific-popup.css') }}">
        <link rel="stylesheet" href="{{ asset('guest/plugins/css/plugins/jquery.countdown.css') }}">
        <!-- Main CSS File -->
        <link rel="stylesheet" href="{{ asset('guest/plugins/css/style.css') }}">
        <link rel="stylesheet" href="{{ asset('guest/plugins/css/skins/skin-demo-4.css') }}">
        <link rel="stylesheet" href="{{ asset('guest/plugins/css/demos/demo-4.css') }}">
        @stack('styles')
    </head>

    <body>
        <div class="page-wrapper">
            @include('guest.layouts.partials.header')

            <main class="main">
                @yield('content')
            </main>

            @include('guest.layouts.partials.footer')
        </div>

        <button id="scroll-top" title="Back to Top"><i class="icon-arrow-up"></i></button>

        <!-- Plugins JS File -->
        <script src="{{ asset('guest/plugins/js/jquery.min.js') }}"></script>
        <script src="{{ asset('guest/plugins/js/bootstrap.bundle.min.js') }}"></script>
        <script src="{{ asset('guest/plugins/js/jquery.hoverIntent.min.js') }}"></script>
        <script src="{{ asset('guest/plugins/js/jquery.waypoints.min.js') }}"></script>
        <script src="{{ asset('guest/plugins/js/superfish.min.js') }}"></script>
        <script src="{{ asset('guest/plugins/js/owl.carousel.min.js') }}"></script>
        <script src="{{ asset('guest/plugins/js/bootstrap-input-spinner.js') }}"></script>
        <script src="{{ asset('guest/plugins/js/jquery.plugin.min.js') }}"></script>
        <script src="{{ asset('guest/plugins/js/jquery.magnific-popup.min.js') }}"></script>
        <script src="{{ asset('guest/plugins/js/jquery.countdown.min.js') }}"></script>
        <!-- Main JS File -->
        <script src="{{ asset('guest/plugins/js/main.js') }}"></script>
        <script src="{{ asset('guest/plugins/js/demos/demo-4.js') }}"></script>
        @stack('scripts')
    </body>

</html>
