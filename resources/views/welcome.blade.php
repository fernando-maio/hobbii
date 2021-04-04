<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Hobbii Code Challenge</title>

        <!-- Bootstrap -->
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

    </head>

    <body class="text-center">
        <div class="cover-container d-flex h-100 p-3 mx-auto flex-column">
    
            <main role="main" class="inner cover">
                <h2 class="cover-heading">Hobbii</h2>
                <p class="lead">Code Challenge (PHP)</p>
                <p class="lead">
                    <a href="{{ route('actions') }}"class="btn btn-lg btn-secondary">{{ __('Access') }}</a>
                </p>
                <a href="https://github.com/fernando-maio/hobbii#readme" target="_blank">{{ __('Documentation') }}</a>
            </main>    
            <footer class="mastfoot mt-auto">
                <div class="inner">
                    
                </div>
            </footer>
        </div>
    </body>
</html>