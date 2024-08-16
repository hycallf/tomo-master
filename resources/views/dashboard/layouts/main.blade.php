<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>{{ $pageTitle ?? 'Dashboard' }}</title>

    <meta content="" name="description">
    <meta content="" name="keywords">

    <!-- Favicons -->
    <link href="{{ asset('assets/letter-w.png') }}" rel="icon">
    <link href="{{ asset('assets/letter-w.png') }}" rel="apple-touch-icon">

    <!-- Google Fonts -->
    <link href="https://fonts.gstatic.com" rel="preconnect">
    <link
        href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i"
        rel="stylesheet" type="text/css">

    <!-- Vendor CSS Files -->
    <link href="{{ asset('assets/dashboard/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet"
        type="text/css">
    <link href="{{ asset('assets/dashboard/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet"
        type="text/css">
    <link href="{{ asset('assets/dashboard/vendor/boxicons/css/boxicons.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('assets/dashboard/vendor/remixicon/remixicon.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('assets/dashboard/vendor/datatables.net-bs5/css/dataTables.bootstrap5.min.css') }}"
        rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/dashboard/vendor/datatables.net-responsive-bs5/css/responsive.bootstrap5.min.css') }}"
        rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/dashboard/vendor/datatables.net-buttons-bs5/css/buttons.bootstrap5.min.css') }}"
        rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/dashboard/vendor/datatables.net-select-bs5/css//select.bootstrap5.min.css') }}"
        rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/dashboard/vendor/sweetalert2/sweetalert2.min.css') }}" rel="stylesheet"
        type="text/css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" />
    <link rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" />
    <link href="{{ asset('assets/dashboard/vendor/flatpickr/flatpickr.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('assets/dashboard/vendor/quill/quill.snow.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('assets/dashboard/vendor/quill/quill.bubble.css') }}" rel="stylesheet" type="text/css">

    <!-- Template Main CSS File -->
    <link href="{{ asset('assets/dashboard/css/style.css') }}" rel="stylesheet" type="text/css">

    <!-- My CSS -->
    <link href="{{ asset('assets/dashboard/css/my-style.css') }}" rel="stylesheet" type="text/css">

    @yield('css')
</head>

<body>
    <!-- ======= SweetAlert ======= -->
    @include('sweetalert::alert')
    <!-- End SweetAlert -->

    <!-- ======= Header ======= -->
    @include('dashboard.layouts.components.header')
    <!-- End Header -->

    <!-- ======= Sidebar ======= -->
    @if (auth()->user()->role == 'admin' || auth()->user()->role == 'administrator')
        @include('dashboard.layouts.components.sidebar')
    @endif
    <!-- End Sidebar-->

    <!-- ======= Main ======= -->
    <main id="main" class="main">
        @yield('content')
    </main>
    <!-- End Main -->

    <!-- ======= Footer ======= -->
    @include('dashboard.layouts.components.footer')
    <!-- End Footer -->

    <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i
            class="bi bi-arrow-up-short"></i></a>

    <!-- Vendor JS Files -->
    <script src="{{ asset('assets/dashboard/vendor/jquery/jquery.min.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.30.1/moment.min.js"></script>
    <script src="{{ asset('assets/dashboard/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/dashboard/vendor/datatables.net/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/dashboard/vendor/datatables.net-bs5/js/dataTables.bootstrap5.min.js') }}"></script>
    <script src="{{ asset('assets/dashboard/vendor/datatables.net/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/dashboard/vendor/datatables.net-bs5/js/dataTables.bootstrap5.min.js') }}"></script>
    <script src="{{ asset('assets/dashboard/vendor/datatables.net-responsive/js/dataTables.responsive.min.js') }}">
    </script>
    <script src="{{ asset('assets/dashboard/vendor/datatables.net-responsive-bs5/js/responsive.bootstrap5.min.js') }}">
    </script>
    <script src="{{ asset('assets/dashboard/vendor/datatables.net-buttons/js/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('assets/dashboard/vendor/datatables.net-buttons-bs5/js/buttons.bootstrap5.min.js') }}"></script>
    <script src="{{ asset('assets/dashboard/vendor/datatables.net-buttons/js/buttons.html5.min.js') }}"></script>
    <script src="{{ asset('assets/dashboard/vendor/datatables.net-buttons/js/buttons.flash.min.js') }}"></script>
    <script src="{{ asset('assets/dashboard/vendor/datatables.net-buttons/js/buttons.print.min.js') }}"></script>
    <script src="{{ asset('assets/dashboard/vendor/datatables.net-keytable/js/dataTables.keyTable.min.js') }}"></script>
    <script src="{{ asset('assets/dashboard/vendor/datatables.net-select/js/dataTables.select.min.js') }}"></script>
    <script src="{{ asset('assets/dashboard/vendor/sweetalert2/sweetalert2.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.full.min.js"></script>
    <script src="{{ asset('assets/dashboard/vendor/flatpickr/flatpickr.min.js') }}"></script>
    <script src="{{ asset('assets/dashboard/vendor/quill/quill.min.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.3/js/buttons.colVis.min.js"></script>

    <!-- Template Main JS File -->
    <script src="{{ asset('assets/dashboard/js/main.js') }}"></script>

    @if (auth()->user()->role == 'pelanggan' || auth()->user()->role == 'pekerja')
        <script>
            document.querySelector('body').classList.add('toggle-sidebar');
        </script>
    @endif

    @yield('js')
    @yield('scripts')
</body>

</html>
