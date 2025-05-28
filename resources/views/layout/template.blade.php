<!DOCTYPE html>
<html lang="en">

<head>
    <title>{{ config('app.name', 'Smart Farming') }}</title>
    <!-- [Meta] -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="description" content="Web Monitoring dan Visualisasi Data Smart Farming">
    <meta name="keywords" content="Web Monitoring Smart Farming">
    <meta name="author" content="Rasyid">
    <meta name="csrf-token" content="{{ csrf_token() }}">


    <!-- [Favicon] icon -->
    <link rel="icon" href="{{ asset('Mantis-Bootstrap-1.0.0/dist/assets/images/favicon.svg') }}"
        type="image/x-icon">
    <!-- [Google Font] Family -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Public+Sans:wght@300;400;500;600;700&display=swap"
        id="main-font-link">
    <!-- [Tabler Icons] https://tablericons.com -->
    <link rel="stylesheet" href="{{ asset('Mantis-Bootstrap-1.0.0/dist/assets/fonts/tabler-icons.min.css') }}">
    <!-- [Feather Icons] https://feathericons.com -->
    <link rel="stylesheet" href="{{ asset('Mantis-Bootstrap-1.0.0/dist/assets/fonts/feather.css') }}">
    <!-- [Font Awesome Icons] https://fontawesome.com/icons -->
    <link rel="stylesheet" href="{{ asset('Mantis-Bootstrap-1.0.0/dist/assets/fonts/fontawesome.css') }}">
    <!-- [Material Icons] https://fonts.google.com/icons -->
    <link rel="stylesheet" href="{{ asset('Mantis-Bootstrap-1.0.0/dist/assets/fonts/material.css') }}">
    <!-- [Template CSS Files] -->
    <link rel="stylesheet" href="{{ asset('Mantis-Bootstrap-1.0.0/dist/assets/css/style.css') }}" id="main-style-link">
    <link rel="stylesheet" href="{{ asset('Mantis-Bootstrap-1.0.0/dist/assets/css/style-preset.css') }}">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">

    <style>
        .hover-underline {
            color: #ffffff;
            position: relative;
            display: inline-block;
        }

        .hover-underline::after,
        .hover-underline::before {
            content: '';
            position: absolute;
            width: 100%;
            height: 2px;
            background: linear-gradient(to right, #227066, #227066);
            bottom: -5px;
            left: 0;
            transform: scaleX(0);
            transform-origin: right;
            transition: transform 0.4s ease-out;
        }

        .hover-underline::before {
            top: -5px;
            transform-origin: left;
        }

        .hover-underline:hover::after,
        .hover-underline:hover::before {
            transform: scaleX(1);
        }
    </style>
</head>
<!-- [Head] end -->

<!-- [Body] Start -->

<body data-pc-preset="preset-1" data-pc-direction="ltr" data-pc-theme="light">
    <!-- [ Pre-loader ] start -->
    <div class="loader-bg">
        <div class="loader-track">
            <div class="loader-fill"></div>
        </div>
    </div>
    <!-- [ Pre-loader ] End -->

    <!-- [ Sidebar Menu ] start -->
    @include('layout.sidebar')
    <!-- [ Sidebar Menu ] end -->

    <!-- [ Header Topbar ] start -->
    @include('layout.header')
    <!-- [ Header ] end -->



    <!-- [ Main Content ] start -->
    <div class="pc-container">
        <div class="pc-content">
            <!-- [ breadcrumb ] start -->
            @include('layout.breadcrumb')
            <!-- [ breadcrumb ] end -->

            <!-- [ Main Content ] start -->
            <section class="content">
                @yield('content')
            </section>
            <!-- [ Main Content ] end -->
        </div>
    </div>
    <!-- [ Main Content ] end -->

    <!-- [ Footer ] start -->
    @include('layout.footer')
    <!-- [ Footer ] end -->

    <!-- Required Js -->
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
    <link href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css" rel="stylesheet">

    <script src="{{ asset('Mantis-Bootstrap-1.0.0/dist/assets/js/plugins/popper.min.js') }}"></script>
    <script src="{{ asset('Mantis-Bootstrap-1.0.0/dist/assets/js/plugins/simplebar.min.js') }}"></script>
    <script src="{{ asset('Mantis-Bootstrap-1.0.0/dist/assets/js/plugins/bootstrap.min.js') }}"></script>
    <script src="{{ asset('Mantis-Bootstrap-1.0.0/dist/assets/js/fonts/custom-font.js') }}"></script>
    <script src="{{ asset('Mantis-Bootstrap-1.0.0/dist/assets/js/pcoded.js') }}"></script>
    <script src="{{ asset('Mantis-Bootstrap-1.0.0/dist/assets/js/plugins/feather.min.js') }}"></script>

    <script>
        layout_change('light');
    </script>
    <script>
        change_box_container('false');
    </script>
    <script>
        layout_rtl_change('false');
    </script>
    <script>
        preset_change("preset-1");
    </script>
    <script>
        font_change("Public-Sans");
    </script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const links = document.querySelectorAll(".pc-link");

            // Fungsi untuk menambahkan class 'active' ke link yang sesuai dengan URL saat ini
            function setActiveLink() {
                const currentUrl = window.location.href;
                links.forEach(link => {
                    if (link.href === currentUrl) {
                        link.classList.add("active");
                    } else {
                        link.classList.remove("active");
                    }
                });
            }

            // Set active link berdasarkan URL saat halaman dimuat
            setActiveLink();

            // Tambahkan event listener untuk mengatur active state saat link diklik
            links.forEach(link => {
                link.addEventListener("click", function() {
                    links.forEach(l => l.classList.remove("active"));
                    this.classList.add("active");
                });
            });
        });
    </script>
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    </script>
    @stack('js')
</body>
<!-- [Body] end -->

</html>
