@extends('layouts.dashboard')

@section('title', 'Dados de Pagamento')

@section('content')
        <h1>Dados de Pagamento</h1>

        <section>
            <h2>Minhas Assinaturas</h2>
            @if ($subscriptions->isNotEmpty())
                <ul>
                    @foreach ($subscriptions as $subscription)
                        <div class="subscription-item">
                            <h3>{{ $subscription->name }}</h3>
                            <p>Status: <span class="status-{{ $subscription->stripe_status }}">{{ $subscription->stripe_status }}</span></p>
                            <p>Início: {{ $subscription->created_at->format('d/m/Y') }}</p>
                            <p>Próximo Pagamento: {{ $subscription->ends_at ? \Carbon\Carbon::parse($subscription->ends_at)->format('d/m/Y') : 'Em andamento' }}</p>
                        </div>
                    @endforeach
                </ul>
            @else
                <p>Nenhuma assinatura ativa encontrada. <a href="{{ route('gym.search') }}">Encontre uma academia para se inscrever!</a></p>
            @endif
        </section>

        <section>
            <h2>Histórico de Pagamentos</h2>
            @if ($invoices->isEmpty())
                <p>Nenhum pagamento encontrado.</p>
            @else
                <ul>
                    @foreach ($invoices as $invoice)
                        <li>
                            <p>Fatura #{{ $invoice->id }} - Total: {{ $invoice->total() }}</p>
                            <a href="{{ route('cashier.download', $invoice->id) }}">Download da Fatura</a>
                        </li>
                    @endforeach
                </ul>
            @endif
        </section>

        <section>
            <h2>Pendências Financeiras</h2>
            <p>Nenhuma pendência encontrada no momento.</p>
        </section>
@endsection