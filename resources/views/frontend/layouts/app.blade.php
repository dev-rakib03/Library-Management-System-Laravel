<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- General CSS Files -->
    <link rel="stylesheet" href="{{asset('/')}}backend/assets/css/app.min.css">
    @yield('css')
    <!-- Template CSS -->
    <link rel="stylesheet" href="{{asset('/')}}backend/assets/css/style.css">
    <link rel="stylesheet" href="{{asset('/')}}backend/assets/css/components.css">
    <!-- Custom style CSS -->
    <link rel="stylesheet" href="{{asset('/')}}backend/assets/css/custom.css">
    <link rel='shortcut icon' type='image/x-icon' href='{{asset('/')}}backend/assets/img/favicon.ico' />
</head>
<body style="padding: 25px 2%;">
    <div class="loader"></div>
    <div id="app">
        <div class="main-wrapper main-wrapper-1">
            <section class="section">
                <div class="section-body">
                  <!-- add content here -->
                    @yield('content')
                </div>
            </section>
        </div>
    </div>
    @include('backend.layouts.javascript')
</body>
</html>
