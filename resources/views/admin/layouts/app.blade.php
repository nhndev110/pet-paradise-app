<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>@yield('title')</title>

        <!-- Google Font: Source Sans Pro -->
        <link rel="stylesheet"
            href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
        <!-- Font Awesome -->
        <link rel="stylesheet" href="{{ asset('admin/plugins/fontawesome-free/css/all.min.css') }}">
        <!-- overlayScrollbars -->
        <link rel="stylesheet" href="{{ asset('admin/plugins/overlayScrollbars/css/OverlayScrollbars.min.css') }}">
        <!-- select2 -->
        <link rel="stylesheet" href="{{ asset('admin/plugins/select2/css/select2.min.css') }}">
        <link rel="stylesheet" href="{{ asset('admin/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
        <!-- Theme style -->
        <link rel="stylesheet" href="{{ asset('admin/css/adminlte.min.css') }}">
        <style>
            label.required::after {
                content: " *";
                color: red;
            }
        </style>
        @stack('styles')
    </head>

    <body class="hold-transition sidebar-mini layout-fixed">

        <div class="wrapper">
            @include('admin.layouts.partials.navbar')

            @include('admin.layouts.partials.sidebar')

            <div class="content-wrapper">
                <section class="content-header">
                    <div class="container-fluid">
                        <div class="row mb-2">
                            <div class="col-sm-6">
                                <h1>@yield('title')</h1>
                            </div>
                        </div>
                    </div>
                </section>

                <section class="content">
                    <div class="container-fluid">
                        @yield('content')
                    </div>
                </section>
            </div>

            @include('admin.layouts.partials.footer')
        </div>

        <!-- jQuery -->
        <script src="{{ asset('admin/plugins/jquery/jquery.min.js') }}"></script>
        <!-- Bootstrap 4 -->
        <script src="{{ asset('admin/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
        <!-- overlayScrollbars -->
        <script src="{{ asset('admin/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js') }}"></script>
        <!-- select2 -->
        <script src="{{ asset('admin/plugins/select2/js/select2.full.min.js') }}"></script>
        <script src="{{ asset('admin/plugins/select2/js/i18n/vi.js') }}"></script>
        <!-- inputmask -->
        <script src="{{ asset('admin/plugins/inputmask/jquery.inputmask.min.js') }}"></script>
        <!-- AdminLTE App -->
        <script src="{{ asset('admin/js/adminlte.min.js') }}"></script>
        <script>
            $(function() {
                $('.select2').select2({
                        width: "100%",
                        theme: "bootstrap4",
                        language: "vi"
                    })
                    .on("select2:open", function(ev) {
                        $(`[aria-controls="select2-${ev.target.id}-results"]`)[0].focus();
                    });

                $('.datemask').inputmask('dd/mm/yyyy', {
                    'placeholder': '__/__/____'
                });
                $('.number-separator').inputmask({
                    alias: "numeric",
                    groupSeparator: ",", // Dấu phẩy phân cách phần nghìn
                    autoGroup: true, // Tự động thêm dấu phân cách
                    digits: 0, // Không có chữ số thập phân
                    removeMaskOnSubmit: true // Loại bỏ ký tự phân cách phần nghìn khi submit form
                });
                $('[data-mask]').inputmask();
            });

            function convertToSlug(text) {
                // Xử lý riêng các ký tự đ/Đ trước khi chuẩn hóa
                text = text.replace(/[đĐ]/g, 'd');

                // Chuyển đổi các ký tự tiếng Việt sang không dấu
                text = text.normalize('NFD').replace(/[\u0300-\u036f]/g, '');

                // Thay thế các ký tự đặc biệt và khoảng trắng
                text = text.toLowerCase()
                    .replace(/[^\w\s-]/g, '') // Loại bỏ các ký tự đặc biệt
                    .replace(/\s+/g, '-') // Thay thế khoảng trắng bằng dấu gạch ngang
                    .replace(/-+/g, '-') // Loại bỏ nhiều dấu gạch ngang liên tiếp
                    .trim(); // Loại bỏ khoảng trắng đầu/cuối

                return text;
            }
        </script>
        @stack('scripts')
    </body>

</html>
