<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />
        <meta name="asset-url" content="{{ config('app.asset_url') }}">
        <link rel="stylesheet" href="{{ asset('css/app.css') }}">
        <link rel="stylesheet" href="{{ asset('app/main/css/ready.css') }}">
        <link rel="stylesheet" href="{{ asset('app/main/css/demo.css') }}">
        <link rel="stylesheet" href="{{ asset('vendor/fontawesome/css/all.min.css') }}">
        @routes
    </head>
    <body class="center-body">
        @inertia
        <script src="{{ asset('js/app.js') }}"></script>
        <script src="{{ asset('app/main/js/ready.js') }}"></script>
    </body>
</html>