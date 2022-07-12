<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>Aplikasi Inventaris</title>
        <!-- Favicon -->
        <link rel="icon" href="{{ asset('img/brand/favicon.png') }}" type="image/png">
        <!-- Fonts -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700">
        <!-- Icons -->
        <link rel="stylesheet" href="{{ asset('vendor/nucleo/css/nucleo.css') }}" type="text/css">
        <link rel="stylesheet" href="{{ asset('vendor/@fortawesome/fontawesome-free/css/all.min.css') }}" type="text/css">
        <!-- Argon CSS -->
        <link rel="stylesheet" href="{{ asset('css/argon.css?v=1.1.0') }}" type="text/css">
    </head>
    <body class="bg-default">
        <!-- Main content -->
        <div class="main-content">
            <!-- Header -->
            <div class="header bg-gradient-primary py-7 py-lg-5 pt-lg-5">
                <div class="container">
                <div class="header-body text-center mb-7">
                    <div class="row justify-content-center">
                    <div class="col-xl-5 col-lg-6 col-md-8 px-5">
                        <h1 class="text-white">Selamat Datang!</h1>
                        <p class="text-lead text-white">Silahkan masuk menggunakan akun yang sudah terdaftar pada sistem.</p>
                    </div>
                    </div>
                </div>
                </div>
                <div class="separator separator-bottom separator-skew zindex-100">
                <svg x="0" y="0" viewBox="0 0 2560 100" preserveAspectRatio="none" version="1.1" xmlns="http://www.w3.org/2000/svg">
                    <polygon class="fill-default" points="2560 0 2560 100 0 100"></polygon>
                </svg>
                </div>
            </div>
            <!-- Page content -->
            <div class="container mt--8 pb-5">
                <div class="row justify-content-center">
                    <div class="col-lg-5 col-md-7">
                        <div class="card bg-secondary border-0 mb-0">
                            <div class="card-body px-lg-5 py-lg-5">
                                <div class="text-center text-muted mb-4">
                                    Aplikasi Inventaris
                                </div>
                                @if (count($errors) > 0)
                                <div class="alert alert-danger" role="alert">
                                    <strong>Danger!</strong>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </div>
                                @endif
                                <form role="form" method="POST" action="{{ route('login') }}">
                                    @csrf
                                    <div class="form-group mb-3">
                                        <div class="input-group input-group-merge input-group-alternative">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="ni ni-email-83"></i></span>
                                        </div>
                                            <input class="form-control" placeholder="Email / Username" name="login" id="login" type="text" role="presentation" autocomplete="off">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="input-group input-group-merge input-group-alternative">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="ni ni-lock-circle-open"></i></span>
                                        </div>
                                            <input class="form-control" placeholder="Password" name="password" id="password" type="password" role="presentation" autocomplete="off">
                                        </div>
                                    </div>
                                    <div class="text-center">
                                        <button type="submit" class="btn btn-primary my-4">Sign in</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="row mt-3">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Footer -->
        <footer class="py-5" id="footer-main">
            <div class="container">
                <div class="row align-items-center justify-content-xl-between">
                    <div class="col-xl-6">
                        <div class="copyright text-center text-xl-left text-muted">
                            &copy; 2022
                        </div>
                    </div>
                </div>
            </div>
        </footer>
        <!-- Argon Scripts -->
        <!-- Core -->
        <script src="{{ asset('vendor/jquery/dist/jquery.min.js') }}"></script>
        <script src="{{ asset('vendor/bootstrap/dist/js/bootstrap.bundle.min.js') }}"></script>
        <script src="{{ asset('vendor/js-cookie/js.cookie.js') }}"></script>
        <script src="{{ asset('vendor/jquery.scrollbar/jquery.scrollbar.min.js') }}"></script>
        <script src="{{ asset('vendor/jquery-scroll-lock/dist/jquery-scrollLock.min.js') }}"></script>
        <!-- Argon JS -->
        <script src="{{ asset('js/argon.js?v=1.1.0') }}"></script>
    </body>
</html>
