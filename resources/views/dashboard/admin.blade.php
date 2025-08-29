@extends('layouts.dashboard')

@section('title', 'Dashboard do Administrador')

@section('content')
    <main>
        <h1>Bem-vindo, Administrador!</h1>

        <section class="admin-summary">
            <div class="summary-card">
                <h2>Novas Solicitações de Academias</h2>
                <p>Você tem {{ $pendingGyms->count() }} solicitações pendentes.</p>
                <a href="{{ route('admin.gyms.pending') }}">Ver Solicitações</a>
            </div>

            <div class="summary-card">
                <h2>Tickets de Suporte Abertos</h2>
                <p>Você tem {{ $openTickets->count() }} tickets de suporte em aberto.</p>
                <a href="{{ route('admin.tickets.open') }}">Ver Tickets</a>
            </div>
        </section>

        <section class="admin-actions">
            <h2>Ações Rápidas</h2>
            <ul>
                <li><a href="{{ route('admin.gyms.create') }}">Cadastrar Nova Academia</a></li>
                <li><a href="{{ route('admin.managers.create') }}">Cadastrar Novo Gerente</a></li>
            </ul>
        </section>
    </main>
@endsection