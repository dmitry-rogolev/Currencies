<!DOCTYPE html>
<html lang="ru">
    <head>
        <meta charset="utf8mb4" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no" />
        @vite ([
            "resources/scss/app.scss", 
            "node_modules/bootstrap/dist/css/bootstrap.min.css", 
            "node_modules/jquery/dist/jquery.min.js?commonjs-entry", 
            "node_modules/bootstrap/dist/js/bootstrap.bundle.min.js?commonjs-entry"
        ])
        <title>Курсы валют</title>
    </head>
    <body class="vh-100 bg-secondary overflow-hidden">
        <div class="h-100 overflow-auto">
            {{ $slot }}
        </div>
    </body>
</html>