@extends('layouts.dashboard')

@section('title', 'Buscar Academias')

@section('css-files')
    <link rel="stylesheet" href="{{ asset('css/aluno/buscar_academia.css') }}" />
@endsection

@section('content')
        <h1>Pesquisar Academias</h1>

        <form method="get" action="{{ route('gym.search') }}">
            <input type="text" name="filtro" placeholder="Nome ou Cidade" value="{{ $filter }}">
            <button type="submit">Pesquisar</button>
        </form>

        <ul>
            @foreach ($gyms as $gym)
                <li>
                    <h3>{{ htmlspecialchars($gym->gym_name) }}</h3>
                    <p>Telefone: {{ htmlspecialchars($gym->gym_phone) }}</p>
                    <p>Funcionamento: {{ htmlspecialchars($gym->week_day . ' das ' . $gym->opening . ' às ' . $gym->closing) }}</p>
                    <p>Endereço: {{ htmlspecialchars($gym->street . ', ' . $gym->number . ' - ' . $gym->neighborhood . ', ' . $gym->city . ' - ' . $gym->state) }}</p>
                    <a href="{{ route('plans.show', ['gym_id' => $gym->id]) }}">Ver Planos</a>
                </li>
            @endforeach
        </ul>
@endsection