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

    @include('partials.dashboard-header')

    <main>
        @yield('content')
    </main>

    @include('partials.footer')

    @yield('js-files')

    <script type="text/javascript">
        var Tawk_API = Tawk_API || {}, Tawk_LoadStart = new Date();
        (function () {
            var s1 = document.createElement("script"), s0 = document.getElementsByTagName("script")[0];
            s1.async = true;
            s1.src = 'https://embed.tawk.to/6827a6cd36f29c190d216342/1irdh4qa7';
            s1.charset = 'UTF-8';
            s1.setAttribute('crossorigin', '*');
            s0.parentNode.insertBefore(s1, s0);
        })();
    </script>
</body>

</html>