@extends('layouts.dashboard')

@section('title', 'Minhas Academias')

@section('css-files')
    <link rel="stylesheet" href="{{ asset('css/aluno/minhas_academias.css') }}">
@endsection

@section('content')
        @if ($subscriptions->isNotEmpty())
            <h2>Minhas Academias</h2>
            <ul>
                @foreach ($subscriptions as $subscription)
                    <div class="academia">
                        <h3>{{ $subscription->plan->gym->gym_name }}</h3>
                        <p>Status: {{ $subscription->stripe_status }}</p>
                        <p>Data de término: {{ \Carbon\Carbon::parse($subscription->ends_at)->format('d/m/Y') }}</p>
                        <p>Alunos treinando agora: <strong>{{ $subscription->total_treinando }}</strong></p>
                        @if ($subscription->stripe_status === 'active')
                            <form action="{{ route('subscription.cancel', ['id' => $subscription->id]) }}" method="post">
                                @csrf
                                <button type="submit"
                                    onclick="return confirm('Tem certeza que deseja cancelar esta assinatura?')">Cancelar
                                    Assinatura</button>
                            </form>
                        @endif
                    </div>
                @endforeach
            </ul>
        @else
            <h2>Nenhuma Academia Registrada</h2>
            <p>Você ainda não possui assinaturas de academias no momento.</p>
            <a href="{{ route('gym.search') }}">Clique aqui para buscar uma academia</a>
        @endif
@endsection