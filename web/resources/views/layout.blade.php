<!DOCTYPE html>
<html lang="{{ App::getLocale() }}">
    <head>
        <meta charset="utf8mb4" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no" />
        <meta name="keywords" content="{{ config('view.keywords') }}" />
        <meta name="description" content="{{ config('view.description') }}" />
        <meta name="author" lang="ru" content="{{ config('view.author') }}" />
        <meta name="robots" content="all" />
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <link href="/favicon.ico" rel="shortcut icon" type="image/x-icon">
        @vite(["resources/js/app.js"])
        <!-- <link href="/css/chunk-vendors.f0ea19bf.css" rel="stylesheet" />
        <link href="/css/app.4ddd1198.css" rel="stylesheet">
        <script defer="defer" src="/js/chunk-vendors.50a3f3b9.js"></script>
        <script defer="defer" src="/js/app.0e014f40.js"></script> -->
        <title>{{ config("view.title") }}</title>
    </head>
    <body class="min-vh-100">
        <noscript>
            <strong>We're sorry but {{ config("view.title") }} doesn't work properly without JavaScript enabled. Please enable it to continue.</strong>
        </noscript>
        <div id="app" class="min-vh-100">
            
        </div>
    </body>
</html>