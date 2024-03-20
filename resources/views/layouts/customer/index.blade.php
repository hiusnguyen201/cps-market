<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <!--[if IE]><meta http-equiv="X-UA-Compatible" content="IE=edge"><![endif]-->
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>{{ $title }}</title>

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
    <link rel="stylesheet" href="{{ asset('custom/css/swiper.css') }}">

</head>

<body class="config">
    <div id="app">
        <!--====== Main Header ======-->
        @include('layouts.customer.parts.navbar')

        <!--====== App Content ======-->
        <div class="app-content">
            @yield('content')
        </div>
        <!--====== End - App Content ======-->

        <!--====== Main Footer ======-->
        @include('layouts.customer.parts.footer')
    </div>

    <!--====== Vendor Js ======-->
    <script src="{{ asset('ludus/js/vendor.js') }}"></script>

    <!--====== jQuery Shopnav plugin ======-->
    <script src="{{ asset('ludus/js/jquery.shopnav.js') }}"></script>

    <!--====== App ======-->
    <script src="{{ asset('ludus/js/app.js') }}"></script>

    {{-- Swiper --}}

    <script src="{{ asset('swiper/package/swiper-bundle.min.js') }}"></script>

    <script defer>
        const swiper = new Swiper(".swiper", {
            nextButton: '.swiper-button-next',
            prevButton: '.swiper-button-prev',
            slidesPerView: 4,
            loop: false,
            spaceBetween: 20,
            grid: {
                rows: 2
            }
        })
    </script>

</body>

</html>
