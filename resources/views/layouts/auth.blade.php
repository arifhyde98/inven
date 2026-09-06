<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
    <title>@yield('title', 'Login') &mdash; {{ \App\Models\PengaturanUmum::first()->title ?? 'JInventory' }}</title>

    <!-- General CSS Files -->
    <link rel="stylesheet" href="{{ asset('assets/modules/bootstrap/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/modules/fontawesome/css/all.min.css') }}">

    <!-- Template CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/components.css') }}">
    <link rel="shortcut icon" href="{{ asset('assets/images/profiles/' . (\App\Models\PengaturanUmum::first()->favicon ?? 'default.png')) }}" type="image/x-icon">
</head>

<body>
    <div id="app">
        <section class="section">
            <div class="container mt-5">
                <div class="row">
                    <div class="col-12 col-sm-8 offset-sm-2 col-md-6 offset-md-3 col-lg-6 offset-lg-3 col-xl-4 offset-xl-4">
                        <div class="login-brand mb-4">
                            <h3 class="text-primary font-weight-bold">{{ \App\Models\PengaturanUmum::first()->nama_perusahaan ?? 'Joona Inventory' }}</h3>
                            <p class="text-muted small">{{ \App\Models\PengaturanUmum::first()->alamat_perusahaan ?? '' }}</p>
                        </div>

                        @if(session('error'))
                            <div class="alert alert-danger alert-dismissible show fade">
                                <div class="alert-body">
                                    <button class="close" data-dismiss="alert"><span>&times;</span></button>
                                    {{ session('error') }}
                                </div>
                            </div>
                        @endif

                        @if(session('success'))
                            <div class="alert alert-success alert-dismissible show fade">
                                <div class="alert-body">
                                    <button class="close" data-dismiss="alert"><span>&times;</span></button>
                                    {{ session('success') }}
                                </div>
                            </div>
                        @endif

                        @yield('content')

                        <div class="simple-footer">
                            {{ \App\Models\PengaturanUmum::first()->footer ?? 'Copyright &copy; 2026' }}
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <!-- General JS Scripts -->
    <script src="{{ asset('assets/modules/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/modules/popper.js') }}"></script>
    <script src="{{ asset('assets/modules/bootstrap/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('assets/js/stisla.js') }}"></script>
    <script src="{{ asset('assets/js/scripts.js') }}"></script>
</body>
</html>
