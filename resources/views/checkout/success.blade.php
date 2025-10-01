@extends('layouts.auth')

@section('title', 'Pagamento Aprovado')

@section('content')
    <div class="bg-gray-100 min-h-screen flex items-center justify-center">
        <div class="bg-white rounded-2xl shadow-lg p-8 md:p-12 text-center max-w-lg mx-auto">
            <div class="mx-auto flex items-center justify-center h-24 w-24 rounded-full bg-green-100 mb-6">
                <svg class="h-12 w-12 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                    xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
            </div>
            <h2 class="text-3xl font-extrabold text-gray-800 mb-4">Pagamento Aprovado!</h2>

            @if ($plan)
                <p class="text-gray-600 text-lg mb-8">
                    Parabéns! Sua assinatura do <strong>{{ $plan->name }}</strong> foi processada com sucesso. Você já pode
                    aproveitar todos os benefícios.
                </p>
            @else
                <p class="text-gray-600 text-lg mb-8">
                    Obrigado! Sua assinatura foi processada com sucesso. Você já pode aproveitar todos os benefícios do seu
                    plano.
                </p>
            @endif

            <a href="{{ route('dashboard.member') }}"
                class="w-full inline-block bg-blue-600 text-white font-bold py-3 px-6 rounded-lg hover:bg-blue-700 transition-colors shadow-lg">
                Ir para meu Painel
            </a>
        </div>
    </div>
@endsection