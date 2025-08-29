@extends('layouts.app')

@section('title', 'Central de Ajuda')

@section('css-files')
    <link rel="stylesheet" href="{{ asset('css/suporte.css') }}">
@endsection

@section('content')
    <header class="navbar">
        <div class="nav-central">
            <h1>Como podemos ajudar?</h1>
            <div class="search-bar">
                <input type="text" id="searchInput" placeholder="Pesquise por ajuda...">
            </div>
        </div>
    </header>

    <main>
        <section class="help-categories">
            <div class="categories-grid">
                <a href="#" class="category-item">
                    <i class="bi bi-person-lock"></i>
                    <h3>Acesso e Login</h3>
                    <p>Problemas para acessar ou redefinir senha.</p>
                </a>
                <a href="{{ route('helpcenter.ticket.create') }}" class="category-item special">
                    <i class="bi bi-envelope-plus"></i>
                    <h3>Abrir um Chamado</h3>
                    <p>Não encontrou o que precisa? Fale conosco.</p>
                </a>
            </div>
        </section>
    </main>
@endsection

@section('js-files')
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const searchInput = document.getElementById('searchInput');
            const cards = document.querySelectorAll('.category-item');

            searchInput.addEventListener('input', function () {
                const searchText = searchInput.value.toLowerCase();

                cards.forEach(card => {
                    const cardText = card.textContent.toLowerCase();
                    if (cardText.includes(searchText)) {
                        card.style.display = 'block';
                    } else {
                        card.style.display = 'none';
                    }
                });
            });
        });
    </script>
@endsection