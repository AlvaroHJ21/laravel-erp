<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title') | {{ config('app.name', 'Laravel') }}</title>

    {{-- JQuery --}}
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>

    {{-- Datatable --}}
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    <script defer src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap4.min.js"></script>

    {{-- Feather Icons --}}
    <script src="https://cdn.jsdelivr.net/npm/feather-icons/dist/feather.min.js"></script>

    {{-- Swal --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    {{-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@sweetalert2/theme-dark@5/dark.css" /> --}}
    {{-- <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.js"></script> --}}

    @vite(['resources/js/app.js', 'resources/css/app.css'])
</head>

<body>

    <div class="wrapper">
        {{-- Sidebar --}}
        <x-sidebar.sidebar />
        <div class="main">
            <!-- HEADER: MENU + HEROE SECTION -->
            <x-header.header />
            <!-- CONTENT -->
            <main class="content">
                <div class="container-fluid p-0">

                    <x-alert.alert />

                    <div class="mb-2">
                        @yield('content_header')
                    </div>

                    @yield('content')

                </div>
            </main>
            <!-- FOOTER: DEBUG INFO + COPYRIGHTS -->

            <x-footer.footer />

        </div>
    </div>

    <script>
        feather.replace();
    </script>

    @yield('js')
</body>

</html>
