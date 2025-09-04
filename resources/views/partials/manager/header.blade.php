<header class="navbar">
    <div class="nav-header">
        <div class="logo">
            <a href="{{ route('home') }}">
                <img src="{{ asset('img/favicon.png') }}" alt="Logo da Crowd Gym" />
            </a>
        </div>

        <nav class="nav-buttons">
            <a href="{{ route('dashboard.manager') }}" class="header-buttons">Dashboard</a>
            <a href="" class="header-buttons">Funcionários</a>
            <a href="{{ route('manager.members.index') }}" class="header-buttons">Alunos</a>
            <a href="{{ route('manager.plans.index') }}" class="header-buttons">Planos</a>

            <div id="searchBar" class="search-bar">
                <input type="text" id="searchInput" placeholder="Buscar " autocomplete="off" />
                <ul id="searchResults" class="search-results"></ul>
            </div>

            <div id="searchIcon" class="search-icon">
                <i class="bi bi-search"></i>
            </div>

            <div class="buttons-profile">
                <div id="profileButton" class="profile-button">
                    <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="#ffffffff" viewBox="0 0 24 24">
                        <path
                            d="M12 12c2.7 0 5-2.3 5-5s-2.3-5-5-5-5 2.3-5 5 2.3 5 5 5zm0 2c-3.3 0-10 1.7-10 5v3h20v-3c0-3.3-6.7-5-10-5z" />
                    </svg>
                </div>

                <div id="profileOptions" class="profile-options">
                    @auth
                        <a href="">Meu Perfil</a>
                        <a href="">Configurações</a>
                        <a href="">Notificações</a>
                        <a href="{{ route('helpcenter.index') }}">Ajuda</a>
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit" class="profile-options-link">Sair</button>
                        </form>
                    @elseguest
                        <a href="{{ route('login') }}">Fazer Login</a>
                        <a href="{{ route('register') }}">Criar Conta</a>
                        <a href="{{ route('helpcenter.index') }}">Ajuda</a>
                    @endauth
                </div>
            </div>
        </nav>
    </div>
</header>