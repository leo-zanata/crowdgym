<header>
    <nav>
        <div class="list">
            <ul>
                <li class="dropdown">
                    <a href="#"><i class="bi bi-list"></i></a>

                    <div class="dropdown-list">
                        <a href="{{ route('dashboard.member') }}">Menu Inicial</a>
                        <a href="{{ route('gym.my') }}">Minhas Academias</a>
                        <a href="{{ route('gym.search') }}">Buscar Academias</a>
                        <a href="{{ route('payment.data') }}">Dados de Pagamento</a>
                        <a target="_blank" href="{{ route('about') }}">Sobre Nós</a>
                        <a target="_blank" href="{{ route('helpcenter.index') }}">Central de Ajuda</a>
                        <a href="{{ route('logout') }}">Sair</a>
                    </div>
                </li>
            </ul>
        </div>
        <div class="logo">
            <h1>Crowd Gym</h1>
        </div>
            <ul>
                <li class="user-icon">
                    <a href=""><i class="bi bi-person-circle"></i></a>

                    <div class="dropdown-icon">
                        <a href="#">Editar Perfil</a>
                        <a href="#">Alterar Tema</a>
                        <a href="#">Sair da Conta</a>
                    </div>
                </li>
            </ul>
        </div>
    </nav>
</header>