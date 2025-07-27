<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ env('APP_NAME') }}</title>
    <link rel="stylesheet" href="{{ asset('assets/bootstrap/dist/css/bootstrap.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/bootstrap/dist/css/bootstrap-theme.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/fontawesome/css/all.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/style.css') }}">
</head>
<body>
    <div id="main" class="col-md-12">
        @yield('content')
    </div>
    <script src="{{ asset('assets/jQuery.js') }}"></script>
    <script src="{{ asset('assets/bootstrap/dist/js/bootstrap.js') }}"></script>
</body>
</html>