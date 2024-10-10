<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
    <meta name="author" content="Budi Prastyo <budi@prastyo.com>">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title }} &mdash; {{ config('app.name').' '.config('app.subtitle') }}</title>

    <link type="text/css" rel="stylesheet" href="{{ asset('modules/bootstrap/bootstrap.min.css?v=1728534875') }}">
    <link type="text/css" rel="stylesheet" href="{{ asset('modules/fontawesome-free/css/all.min.css?v=1728534876') }}">
    <link type="text/css" rel="stylesheet" href="{{ asset('css/style.css?v=1728534874') }}">
    <link type="text/css" rel="stylesheet" href="{{ asset('css/components.css?v=1728534874') }}">
    <link type="text/css" rel="stylesheet" href="{{ asset('modules/summernote/summernote-bs4.min.css?v=1728534877') }}">
    <link type="text/css" rel="stylesheet" href="{{ asset('modules/toastr/toastr.min.css?v=1728534877') }}">
    <link type="text/css" rel="stylesheet" href="{{ asset('css/custom.css?v=1728534874') }}">
    <link type="text/css" rel="stylesheet" href="{{ asset('modules/datatables/dataTables.bootstrap4.min.css?v=1728534876') }}">
    <link type="text/css" rel="stylesheet" href="{{ asset('modules/datatables/responsive.dataTables.css?v=1728534876') }}">
    @stack('styles')
</head>

<body>
    <div class="loading-state" style="display: none">
        <div class="loader"></div>
    </div>
    <div id="app">
        <div class="main-wrapper">
            @include('components.header')
            @include('components.sidebar')
            @yield('content')
            @include('components.footer')
        </div>
    </div>
    <script src="{{ asset('modules/jquery/jquery.min.js?v=1728534876') }}"></script>
    <script src="{{ asset('modules/jquery-ui/jquery-ui.min.js?v=1728534877') }}"></script>
    <script src="{{ asset('modules/bootstrap/bootstrap.bundle.min.js?v=1728534875') }}"></script>
    <script src="{{ asset('modules/jquery.nicescroll/jquery.nicescroll.min.js?v=1728534877') }}"></script>
    <script src="{{ asset('modules/toastr/toastr.min.js?v=1728534877') }}"></script>
    <script src="{{ asset('modules/summernote/summernote-bs4.min.js?v=1728534877') }}"></script>
    <script src="{{ asset('modules/chart.js/Chart.min.js?v=1728534876') }}"></script>
    <script src="{{ asset('modules/datatables/dataTables.min.js?v=1728534876') }}"></script>
    <script src="{{ asset('modules/datatables/dataTables.bootstrap4.min.js?v=1728534876') }}"></script>
    <script src="{{ asset('modules/datatables/responsive.dataTables.js?v=1728534876') }}"></script>
    <script src="{{ asset('modules/datatables/dataTables.responsive.js?v=1728534876') }}"></script>
    <script src="{{ asset('modules/moment/moment.min.js?v=1728534877') }}"></script>
    <script src="{{ asset('modules/jquery.mask.min.js?v=1728534877') }}"></script>
    <script src="{{ asset('js/custom.js?v=1728534875') }}"></script>
    <script src="{{ asset('js/stisla.js?v=1728534875') }}"></script>
    <script src="{{ asset('js/scripts.js?v=1728534875') }}"></script>
    @stack('scripts')
</body>
</html>