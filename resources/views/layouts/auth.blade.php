<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport" />
    <meta name="author" content="Budi Prastyo <budi@prastyo.com>">
    <title>{{ $title }} &mdash; {{ config('app.name').' '.config('app.subtitle') }}</title>
    <link type="text/css" rel="stylesheet" href="{{ asset('modules/bootstrap/bootstrap.min.css?v=1728534875') }}">
    <link type="text/css" rel="stylesheet" href="{{ asset('modules/fontawesome-free/css/all.min.css?v=1728534876') }}">
    <link type="text/css" rel="stylesheet" href="{{ asset('css/style.css?v=1728534874') }}">
    <link type="text/css" rel="stylesheet" href="{{ asset('css/components.css?v=1728534874') }}">
    <link type="text/css" rel="stylesheet" href="{{ asset('css/custom.css?v=1728534874') }}">
</head>

<body>
    <div id="app">
        <section class="section">
            <div class="container mt-5">
                <div class="row">
                    <div
                        class="col-12 col-sm-10 offset-sm-1 col-md-8 offset-md-2 col-lg-8 offset-lg-2 col-xl-6 offset-xl-3">
                        @include('components.auth.header')
                        @yield('content')
                    </div>
                </div>
                @include('components.auth.footer')
            </div>
        </section>
    </div>
    <script src="{{ asset('modules/jquery/jquery.min.js?v=1728534876') }}"></script>
    <script src="{{ asset('modules/bootstrap/bootstrap.bundle.min.js?v=1728534875') }}"></script>
    <script src="{{ asset('js/stisla.js?v=1728534875') }}"></script>
    <script src="{{ asset('js/scripts.js?v=1728534875') }}"></script>
</body>
</html>