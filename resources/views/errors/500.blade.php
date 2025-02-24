<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <!--[if IE]><meta http-equiv="X-UA-Compatible" content="IE=edge"><![endif]-->
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Server error</title>

    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('adminlte/plugins/fontawesome-free/css/all.min.css') }}">

    <!--====== Vendor Css ======-->
    <link rel="stylesheet" href="{{ asset('ludus/css/vendor.css') }}">

    <!--====== Utility-Spacing ======-->
    <link rel="stylesheet" href="{{ asset('ludus/css/utility.css') }}">

    <!--====== App ======-->
    <link rel="stylesheet" href="{{ asset('ludus/css/app.css') }}">
</head>

<body>
    <div class="u-s-p-y-120 u-s-m-t-60">
        <div class="section__content">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12 col-md-12 u-s-m-b-30">
                        <div class="empty">
                            <div class="empty__wrap">

                                <span class="empty__big-text">500</span>

                                <span class="empty__text-1" style="font-size: 22px">Internal server error</span>

                                <p class="empty__text-2"
                                    style="font-size: 16px; font-weight: 400;max-width: 460px; margin: 0 auto 24px">We
                                    apologize for the
                                    inconvenience.
                                    Please try again later.</p>

                                @if (Auth::user() && Auth::user()->role->name == 'admin')
                                    <a class="empty__redirect-link btn--e-brand" href="/admin">GO TO HOME</a>
                                @else
                                    <a class="empty__redirect-link btn--e-brand" href="/">GO TO HOME</a>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
