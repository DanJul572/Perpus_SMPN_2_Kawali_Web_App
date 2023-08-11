<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="asset-url" content="{{ config('app.asset_url') }}">
        <link rel="icon" type="image/x-icon" href="{{ asset('app/landing/image/favicon.ico') }}"/>
        <link href="https://fonts.googleapis.com/css?family=Merriweather+Sans:400,700" rel="stylesheet" />
        <link href="https://fonts.googleapis.com/css?family=Merriweather:400,300,300italic,400italic,700,700italic" rel="stylesheet" type="text/css" />
        <link href="{{ asset('app/landing/css/styles.css') }}" rel="stylesheet" />
        @routes
    </head>
    <body>
        @inertia
        <script src="{{ asset('js/app.js') }}"></script>
    </body>
</html>
