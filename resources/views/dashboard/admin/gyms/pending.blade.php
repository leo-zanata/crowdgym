@extends('layouts.dashboard')

@section('title', 'Solicitações Pendentes')

@section('content')
    <main>
        <h1>Solicitações de Academias Pendentes</h1>

        @if ($pendingGyms->isNotEmpty())
            <ul>
                @foreach ($pendingGyms as $gym)
                    <li>
                        <h3>{{ $gym->gym_name }}</h3>
                        <p>Nome do Gerente: {{ $gym->manager_name }}</p>
                        <p>E-mail: {{ $gym->email }}</p>
                        <p>Telefone: {{ $gym->gym_phone }}</p>
                        <a href="{{ route('admin.gyms.approve', $gym->id) }}">Aprovar</a>
                        <a href="{{ route('admin.gyms.reject', $gym->id) }}">Rejeitar</a>
                    </li>
                @endforeach
            </ul>
        @else
            <p>Nenhuma solicitação pendente encontrada.</p>
        @endif
    </main>
@endsection