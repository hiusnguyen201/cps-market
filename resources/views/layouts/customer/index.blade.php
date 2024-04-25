<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <!--[if IE]><meta http-equiv="X-UA-Compatible" content="IE=edge"><![endif]-->
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>{{ $title }} - {{ env('APP_NAME') }}</title>
    <link rel="icon" href="{{ asset('images/Logo Icon.png') }}">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('adminlte/plugins/fontawesome-free/css/all.min.css') }}">

    <!--====== Vendor Css ======-->
    <link rel="stylesheet" href="{{ asset('ludus/css/vendor.css') }}">

    <!--====== Utility-Spacing ======-->
    <link rel="stylesheet" href="{{ asset('ludus/css/utility.css') }}">

    <!--====== App ======-->
    <link rel="stylesheet" href="{{ asset('ludus/css/app.css') }}">

    {{-- swiper --}}
    <link rel="stylesheet" href="{{ asset('swiper/package/swiper-bundle.min.css') }}">

    <!-- Toast js -->
    <link rel="stylesheet" href="{{ asset('toastjs/toastify.css') }}">

    {{-- Custom --}}
    <link rel="stylesheet" href="{{ asset('custom/css/style.css') }}">

</head>

<body class="config">
    @php
        setlocale(LC_MONETARY, 'vi_VN');
    @endphp

    <!--====== Main Header ======-->
    @include('layouts.customer.parts.navbar')

    <!--====== App Content ======-->
    <div class="app-content">
        @yield('content')
    </div>
    <!--====== End - App Content ======-->

    <!--====== Main Footer ======-->
    @include('layouts.customer.parts.footer')

    <!--====== Vendor Js ======-->
    <script src="{{ asset('ludus/js/vendor.js') }}"></script>

    <!--====== jQuery Shopnav plugin ======-->
    <script src="{{ asset('ludus/js/jquery.shopnav.js') }}"></script>

    <!--====== App ======-->
    <script src="{{ asset('ludus/js/app.js') }}"></script>

    <!-- jQuery -->
    <script src="{{ asset('adminlte/plugins/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('custom/js/cart.js') }}"></script>

    {{-- Select viet nam location --}}
    <script src="{{ asset('vietnamlocalselector/vietnamlocalselector.js') }}"></script>
    <script src="{{ asset('custom/js/vietnamlocalselector.js') }}"></script>

    {{-- Swiper --}}
    <script src="{{ asset('swiper/package/swiper-bundle.min.js') }}"></script>
    <script src="{{ asset('custom/js/swiper.js') }}"></script>

    <!-- Toast js -->
    <script src="{{ asset('toastjs/toastify.js') }}"></script>
    <script src="{{ asset('custom/js/message.js') }}"></script>

    <script src="{{ asset('custom/js/search.js') }}"></script>

    <script src="{{ asset('custom/js/manage_order.js') }}"></script>

    {{-- UI --}}
    <script defer src="{{ asset('custom/js/ui.js') }}"></script>
</body>

</html>
