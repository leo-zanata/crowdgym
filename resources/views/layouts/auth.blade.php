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
    <link rel="stylesheet"
        href="https://cdn.positus.global/production/resources/robbu/whatsapp-button/whatsapp-button.css">
    @yield('links')
</head>

<body>

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

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const perfilBtn = document.getElementById('profileButton');
            const opcoes = document.getElementById('profileOptions');

            perfilBtn.addEventListener('click', function (e) {
                e.stopPropagation();
                opcoes.classList.toggle('show');
            });

            document.addEventListener('click', function (event) {
                if (!perfilBtn.contains(event.target) && !opcoes.contains(event.target)) {
                    opcoes.classList.remove('show');
                }
            });
        });
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const searchIcon = document.getElementById('searchIcon');
            const searchBar = document.getElementById('searchBar');
            const searchInput = document.getElementById('searchInput');

            if (searchIcon && searchBar && searchInput) {
                searchIcon.addEventListener('click', function () {
                    searchBar.classList.add('active');
                    searchInput.focus();
                });

                searchInput.addEventListener('blur', function () {
                    setTimeout(function () {
                        searchBar.classList.remove('active');
                    }, 200);
                });
            }
        });
    </script>



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