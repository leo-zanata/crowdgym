<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>@yield('title') - Crowd Gym</title>

    <link rel="stylesheet" href="{{ asset('css/index.css') }}">
    @yield('css-files')
    <link rel="icon" href="{{ asset('img/favicon.png') }}" type="image/png" sizes="32x32" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" />
    <link rel="stylesheet"
        href="https://cdn.positus.global/production/resources/robbu/whatsapp-button/whatsapp-button.css">
    @yield('links')
    <script src="//unpkg.com/alpinejs" defer></script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>

<body>

    @include('partials.header')

    <main>
        <div class="container">
            @yield('content')
        </div>
        <a id="robbu-whatsapp-button" target="_blank" href="https://api.whatsapp.com/send?phone=0">
            <div class="rwb-tooltip">Fale conosco</div>
            <img src="https://cdn.positus.global/production/resources/robbu/whatsapp-button/whatsapp-icon.svg">
        </a>
    </main>

    @include('partials.footer')

    @yield('js-files')

    <script src="{{ asset('js/index.js') }}"></script>
    @livewireScripts
</body>

</html>