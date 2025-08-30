@extends('layouts.dashboard')

@section('title', 'Solicitações Pendentes')

@section('content')
    <main>
        <h1>Solicitações de Academias Pendentes</h1>

        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if ($pendingGyms->isNotEmpty())
            <ul>
                @foreach ($pendingGyms as $gym)
                    <li>
                        <h3>{{ $gym->gym_name }}</h3>
                        <p><strong>Status:</strong> {{ $gym->status }}</p>

                        <h4>Informações do Gerente</h4>
                        <p><strong>Nome:</strong> {{ $gym->manager_name }}</p>
                        <p><strong>E-mail:</strong> {{ $gym->manager_email }}</p>
                        <p><strong>CPF:</strong> {{ $gym->manager_cpf }}</p>
                        <p><strong>Telefone:</strong> {{ $gym->manager_phone }}</p>
                        
                        <h4>Informações da Academia</h4>
                        <p><strong>Telefone:</strong> {{ $gym->gym_phone }}</p>
                        <p><strong>Endereço:</strong> {{ $gym->street }}, {{ $gym->number }} - {{ $gym->neighborhood }}, {{ $gym->city }} - {{ $gym->state }} (CEP: {{ $gym->zip_code }})</p>
                        <p><strong>Complemento:</strong> {{ $gym->complement ?? 'N/A' }}</p>
                        <p><strong>Horário de Funcionamento:</strong> {{ $gym->week_day }} das {{ \Carbon\Carbon::parse($gym->opening)->format('H:i') }} às {{ \Carbon\Carbon::parse($gym->closing)->format('H:i') }}</p>
                        
                        <form action="{{ route('admin.gyms.approve', $gym->id) }}" method="POST" style="display:inline;">
                            @csrf
                            <button type="submit">Aprovar</button>
                        </form>
                        
                        <form action="{{ route('admin.gyms.reject', $gym->id) }}" method="POST" style="display:inline;">
                            @csrf
                            <button type="submit" onclick="return confirm('Tem certeza que deseja rejeitar esta academia? Esta ação não pode ser desfeita.')">Rejeitar</button>
                        </form>
                    </li>
                @endforeach
            </ul>
        @else
            <p>Nenhuma solicitação pendente encontrada.</p>
        @endif
    </main>
@endsection