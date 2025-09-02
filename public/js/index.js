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