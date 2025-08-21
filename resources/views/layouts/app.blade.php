<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>@yield('title') - Crowd Gym</title>

    <link rel="stylesheet" href="{{ asset('css/index.css') }}">
    @yield('css-files')
    <link rel="icon" href="{{ asset('img/favicon.png') }}" type="image/png" sizes="32x32" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" />
    @yield('links')
</head>
<body>

@include('partials.header')

<main>
    @yield('content')
</main>

@include('partials.footer')

@yield('js-files')

</body>
</html>