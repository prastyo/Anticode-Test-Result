<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
    <meta name="author" content="Budi Prastyo <budi@prastyo.com>">
    <title>{{ __('site.login') }} &mdash; {{ config('app.name').' '.config('app.subtitle') }}</title>
    <link type="text/css" rel="stylesheet" href="{{ asset('modules/bootstrap/bootstrap.min.css?v=1728534875') }}">
    <link type="text/css" rel="stylesheet" href="{{ asset('modules/fontawesome-free/css/all.min.css?v=1728534876') }}">
    <link type="text/css" rel="stylesheet" href="{{ asset('css/style.css?v=1728534874') }}">
    <link type="text/css" rel="stylesheet" href="{{ asset('css/components.css?v=1728534874') }}">
    <link type="text/css" rel="stylesheet" href="{{ asset('css/custom.css?v=1728534874') }}">
</head>

<body>
    <div id="app">
        <section class="section">
            <div class="d-flex flex-wrap align-items-stretch">
                <div class="col-lg-4 col-md-6 col-12 order-lg-1 min-vh-100 order-2 bg-white">
                    <div class="p-4 m-3">
                        <span class="d-flex justify-content-center"><img src="{{ asset('img/stisla-fill.svg?v=1728534875') }}"
                                alt="logo" width="80" class="shadow-light rounded-circle mb-4"></span>
                        <h4 class="text-dark font-weight-bold d-flex justify-content-center">{{ config('app.name') }}</h4>
                        <H5 class="font-weight-normal d-flex justify-content-center mb-5">{{ config('app.subtitle') }}</H5>
                        @if (session('status'))
                            <div class="alert alert-success">
                                {{ session('status') }}
                            </div>
                        @endif
                        <form method="POST" action="#" class="needs-validation" novalidate="">
                            @csrf
                            <div class="form-group">
                                <label for="login">{{ __('email') }} / {{ __('username') }}</label>
                                <input id="login" type="text"
                                    class="form-control @error('login') is-invalid @enderror" name="login"
                                    tabindex="1" required autofocus>
                                @error('login')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <div class="d-block">
                                    <label for="password" class="control-label">{{ __('password') }}</label>
                                </div>
                                <input id="password" type="password"
                                    class="form-control @error('password') is-invalid @enderror" name="password"
                                    tabindex="2" required>
                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="form-group text-right">
                                <a href="{{ route('password.request') }}" class="float-left mt-3">
                                    {{ __('site.forgot_password') }}?
                                </a>
                                <button type="submit" class="btn btn-primary btn-lg btn-icon icon-right"
                                    tabindex="4">
                                    {{ __('site.login') }}
                                </button>
                            </div>
                        </form>

                        @include('components.auth.footer')
                    </div>
                </div>
                <div class="col-lg-8 col-12 order-lg-2 order-1 min-vh-100 background-walk-y position-relative overlay-gradient-bottom" data-background="{{ asset('img/login/bg-19.jpg?v=1728534875') }}">
                    <div class="absolute-bottom-left index-2">
                        <div class="text-light p-5 pb-2">
                            <div class="mb-5 pb-3">
                                <h1 class="mb-2 display-4 font-weight-bold" id="parse_greeting"></h1>
                                <h5 class="font-weight-normal text-muted-transparent">Nusantara Baru, Indonesia Maju</h5>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <script src="{{ asset('modules/jquery/jquery.min.js?v=1728534876') }}"></script>
    <script src="{{ asset('modules/bootstrap/bootstrap.bundle.min.js?v=1728534875') }}"></script>
    <script src="{{ asset('js/stisla.js?v=1728534875') }}"></script>
    <script src="{{ asset('js/scripts.js?v=1728534875') }}"></script>

    <!-- Page Specific JS File -->
    <script>
        const time = new Date().getHours();
        let greeting;
        if (time >= 5 && time< 11) {
            greeting = "{{ __('site.good_morning') }}";
        }else if (time >= 11 && time < 15) {
            greeting = "{{ __('site.good_afternoon') }}";
        } else if (time >= 15 && time < 18) {
            greeting = "{{ __('site.good_evening') }}";
        } else {
            greeting = "{{ __('site.good_night') }}";
        }
        document.getElementById("parse_greeting").innerHTML = greeting;
    </script>
</body>
</html>