<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ $title }} - {{ env('APP_NAME') }}</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('adminlte/plugins/fontawesome-free/css/all.min.css') }}">
    <!-- select 2 -->
    <link rel="stylesheet" href="{{ asset('adminlte/plugins/select2/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('adminlte/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('adminlte/dist/css/adminlte.min.css') }}">
    <!-- Toast js -->
    <link rel="stylesheet" href="{{ asset('toastjs/toastify.css') }}">
    <!-- Custom -->
    <link rel="stylesheet" href="{{ asset('custom/css/style.css') }}">
</head>

<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">
        @include('layouts.admin.parts.navbar')
        @include('layouts.admin.parts.aside')

        <div class="content-wrapper">
            @include('layouts.admin.parts.breadcrumb')

            <section class="content">
                <div class="container-fluid">
                    @yield('content')
                </div>
            </section>
        </div>
    </div>

    <!-- jQuery -->
    <script src="{{ asset('adminlte/plugins/jquery/jquery.min.js') }}"></script>
    <!-- Bootstrap 4 -->
    <script src="{{ asset('adminlte/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <!-- Select 2 -->
    <script src="{{ asset('adminlte/plugins/select2/js/select2.full.min.js') }}"></script>
    <!-- Toast js -->
    <script src="{{ asset('toastjs/toastify.js') }}"></script>

    <!-- AdminLTE App -->
    <script src="{{ asset('adminlte/dist/js/adminlte.min.js') }}"></script>

    <script>
        $("#selectAll").on("click", function() {
            if ($(this).is(":checked")) {
                $(".form-check-input").prop("checked", true);
            } else {
                $(".form-check-input").prop("checked", false);
            }
        });

        $("form.form-delete-all").submit((event) => {
            const formCheckboxChecked = $("input.form-check-input:checked:not(#selectAll)");
            for (var i = 0; i < formCheckboxChecked.length; i++) {
                $("form.form-delete-all").append(
                    `<input type="hidden" name="id[${i}]" value="${formCheckboxChecked[i].value}">`)
            }
        });

        $("select#brand[name='category[]']").select2();

        $('.select2').select2()
    </script>

    <script src="{{ asset('custom/js/message.js') }}"></script>
    <script src="{{ asset('custom/js/specifications.js') }}"></script>
    <script src="{{ asset('custom/js/orders.js') }}"></script>
    <script src="{{ asset('custom/js/products.js') }}"></script>

    {{-- Select viet nam location --}}
    <script src="{{ asset('vietnamlocalselector/vietnamlocalselector.js') }}"></script>
    <script src="{{ asset('custom/js/vietnamlocalselector.js') }}"></script>

    <script src="{{ asset('custom/js/selectMultiFile.js') }}"></script>
    <!-- Custom UI -->
    <script defer src="{{ asset('custom/js/ui.js') }}"></script>
</body>

</html>
