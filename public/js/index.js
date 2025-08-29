var Tawk_API = Tawk_API || {}, Tawk_LoadStart = new Date();
(function () {
    var s1 = document.createElement("script"), s0 = document.getElementsByTagName("script")[0];
    s1.async = true;
    s1.src = 'https://embed.tawk.to/6827a6cd36f29c190d216342/1irdh4qa7';
    s1.charset = 'UTF-8';
    s1.setAttribute('crossorigin', '*');
    s0.parentNode.insertBefore(s1, s0);
})();

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