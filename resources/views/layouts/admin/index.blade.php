<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ $title }} - {{ env('APP_NAME') }}</title>
    <link rel="icon" href="{{ asset('images/Logo Icon.png') }}">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('adminlte/plugins/fontawesome-free/css/all.min.css') }}">
    <link href="https://cdn.datatables.net/2.0.5/css/dataTables.dataTables.min.css" rel="stylesheet">
    <!-- select 2 -->
    <link rel="stylesheet" href="{{ asset('adminlte/plugins/select2/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('adminlte/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">

    <!-- Adminlte -->
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
    <script src="{{ asset('adminlte/plugins/jquery-ui/jquery-ui.min.js') }}"></script>
    <script defer>
        $.widget.bridge('uibutton', $.ui.button)
    </script>
    <!-- Bootstrap 4 -->
    <script src="{{ asset('adminlte/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <!-- AdminLTE App -->
    <script src="{{ asset('adminlte/dist/js/adminlte.js') }}"></script>
    <!-- Select 2 -->
    <script src="{{ asset('adminlte/plugins/select2/js/select2.full.min.js') }}"></script>
    <!-- Toast js -->
    <script src="{{ asset('toastjs/toastify.js') }}"></script>
    <script src="https://cdn.datatables.net/2.0.5/js/dataTables.min.js"></script>

    <script>
        $("#selectAll").on("click", function() {
            if ($(this).is(":checked")) {
                $(".form-check-input").prop("checked", true);
            } else {
                $(".form-check-input").prop("checked", false);
            }
        });

        $("#selectAll-lg").on("click", function() {
            if ($(this).is(":checked")) {
                $(".form-check-input-lg").prop("checked", true);
            } else {
                $(".form-check-input-lg").prop("checked", false);
            }
        });

        $("form.form-delete-all").submit((event) => {
            var formCheckboxChecked = null;

            if ($(document).width() <= 1024) {
                formCheckboxChecked = $("input.form-check-input:checked:not(#selectAll)");
            } else {
                formCheckboxChecked = $("input.form-check-input-lg:checked:not(#selectAll-lg)");
            }

            for (var i = 0; i < formCheckboxChecked.length; i++) {
                $("form.form-delete-all").append(
                    `<input type="hidden" name="id[${i}]" value="${formCheckboxChecked[i].value}">`)
            }
        });

        $("select#brand[name='category[]']").select2();

        $('.select2').select2();

        var table = $('#dataTable').DataTable({
            info: false,
            ordering: false,
            paging: false,
            searching: false,
            responsive: true,
            columns: [{
                    className: 'dt-control',
                    orderable: false,
                    data: null,
                    defaultContent: ''
                },
                {
                    data: ''
                },
                {
                    data: 'name'
                },
            ],
        });

        if ($('#dataTable')) {
            function isJsonString(str) {
                try {
                    JSON.parse(str);
                } catch (e) {
                    return false;
                }
                return true;
            }

            function format(rowId, name, value) {
                var names = name.split("|");
                var values = value.split("|");
                var html = "";
                names.forEach((name, index) => {
                    html += `<div class='mb-3'><label>${name}:</label> ` +
                        `<br /> ${values[index]}` +
                        '</div>'
                });

                html += `
                <div class='mb-3'>
                    <label>Action:</label><br/>
                    <a class="btn btn-warning mr-1" href="/admin/${$('#dataTable').attr("name")}/edit/${rowId}">
                        <i class="fas fa-pen"></i>
                    </a>
                    <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#modal-delete-${rowId}">
                        <i class="fas fa-trash-alt"></i>
                    </button>
                </div>
            `;

                return html;
            }

            $('#dataTable tbody').on('click', 'td.dt-control', function() {
                var tr = $(this).closest('tr');
                var row = table.row(tr);

                if (row.child.isShown()) {
                    // This row is already open - close it
                    row.child.hide();
                } else {
                    // Open this row
                    row.child(format(tr.attr('data-row'), tr.attr('data-child-name'), tr.attr(
                            'data-child-value')))
                        .show();
                }
            });
        }

        if ($(document).width() <= 1024) {
            $("#normalTable").hide();
            $("#dataTable").show();
        } else {
            $("#dataTable").hide();
            $("#normalTable").show();
        }

        $(window).resize(function() {
            if ($(document).width() <= 1024) {
                $("#normalTable").hide();
                $("#dataTable").show();
            } else {
                $("#dataTable").hide();
                $("#normalTable").show();
            }
        });

        $('form').submit(function(e) {
            $('input:disabled').each(function(e) {
                $(this).removeAttr('disabled');
            })
        });
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
