<!DOCTYPE html>
<html lang="en">

<head>
    <title>Acceptance | Agrilink Vocpro</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="description"
        content="Platform website untuk monitoring smart farming dengan visualisasi data sensor pertanian secara real-time dan prediksi cuaca berbasis web.">
    <meta name="keywords"
        content="Smart Farming, Monitoring Pertanian, Website Pertanian, Visualisasi Data Sensor, Dashboard Pertanian, Prediksi Cuaca, IoT Pertanian, Agritech, Sistem Monitoring Greenhouse">
    <meta name="author" content="Rasyid Razeka Alamsyah">
    <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate" />
    <meta http-equiv="Pragma" content="no-cache" />
    <meta http-equiv="Expires" content="0" />

    <link rel="icon" href="{{ asset('storage/asset_web/LOGO NO BG.png') }}" type="image/x-icon">
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Public+Sans:wght@300;400;500;600;700&display=swap"
        id="main-font-link">
    <link rel="stylesheet" href="{{ asset('Mantis-Bootstrap-1.0.0/dist/assets/fonts/tabler-icons.min.css') }}">
    <link rel="stylesheet" href="{{ asset('Mantis-Bootstrap-1.0.0/dist/assets/fonts/feather.css') }}">
    <link rel="stylesheet" href="{{ asset('Mantis-Bootstrap-1.0.0/dist/assets/fonts/fontawesome.css') }}">
    <link rel="stylesheet" href="{{ asset('Mantis-Bootstrap-1.0.0/dist/assets/fonts/material.css') }}">
    <link rel="stylesheet" href="{{ asset('Mantis-Bootstrap-1.0.0/dist/assets/css/style.css') }}" id="main-style-link">
    <link rel="stylesheet" href="{{ asset('Mantis-Bootstrap-1.0.0/dist/assets/css/style-preset.css') }}">
    <link rel="stylesheet" href="{{ asset('css/login.css') }}">
    <style>
        .auth-main {
            background: url("{{ asset('storage/asset_web/bg login.png') }}") no-repeat center center fixed;
            background-size: cover;
            min-height: 100vh !important;
            display: flex !important;
            align-items: center !important;
            justify-content: center !important;
        }

        .auth-form {
            background: none !important;
        }
    </style>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
</head>

<body>
    @include('sweetalert::alert')
    <div class="loader-bg">
        <div class="loader-track">
            <div class="loader-fill"></div>
        </div>
    </div>

    <div class="auth-main">
        <div class="auth-wrapper v3">
            <div class="auth-form">
                <div class="auth-header">
                    <a href="{{ route('login.index') }}"><img src="{{ asset('storage/asset_web/logo.png') }}"
                            alt="img" style="width: 180px; height: auto;"></a>
                </div>
                <div class="card my-5">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-end mb-4">
                            <h3 class="mb-0"><b>Buat Password</b></h3>
                        </div>
                        <form action="{{ route('acceptance.process', ['token' => request('token')]) }}" method="POST">
                            @csrf
                            <div class="form-group mb-3">
                                <label class="form-label">Password</label>
                                <input type="password" class="form-control  @error('password') is-invalid @enderror"
                                    id="password" name="password" placeholder="Masukkan Password" required>
                                @error('password')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group mb-3">
                                <label class="form-label">Konfirmasi Password</label>
                                <input type="password"
                                    class="form-control  @error('password_confirmation') is-invalid @enderror"
                                    id="password_confirmation" name="password_confirmation"
                                    placeholder="Masukkan Ulang Password" required>
                                @if ($errors->has('password_confirmation'))
                                    <span class="text-danger">{{ $errors->first('password_confirmation') }}</span>
                                @endif
                            </div>
                            <div class="d-grid mt-4">
                                <button type="submit" class="btn btn-primary">Kirim</button>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="auth-footer row">
                    <div class="col my-1">
                        <p class="m-0">Copyright © Agrilink Vocpro</p>
                    </div>
                    <div class="col-auto my-1">
                        <ul class="list-inline footer-link mb-0">
                            <li class="list-inline-item"><a href="{{ route('login.index') }}">Home</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="{{ asset('Mantis-Bootstrap-1.0.0/dist/assets/js/plugins/popper.min.js') }}"></script>
    <script src="{{ asset('Mantis-Bootstrap-1.0.0/dist/assets/js/plugins/simplebar.min.js') }}"></script>
    <script src="{{ asset('Mantis-Bootstrap-1.0.0/dist/assets/js/plugins/bootstrap.min.js') }}"></script>
    <script src="{{ asset('Mantis-Bootstrap-1.0.0/dist/assets/js/fonts/custom-font.js') }}"></script>
    <script src="{{ asset('Mantis-Bootstrap-1.0.0/dist/assets/js/pcoded.js') }}"></script>
    <script src="{{ asset('Mantis-Bootstrap-1.0.0/dist/assets/js/plugins/feather.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    </script>
    <script>
        window.addEventListener("pageshow", function(event) {
            if (event.persisted || (window.performance && window.performance.navigation.type === 2)) {
                window.location.reload();
            }
        });
    </script>

</body>

</html>
