@extends('layouts.auth')

@section('title', 'Pagamento Cancelado')

@section('content')
    <div class="bg-gray-100 min-h-screen flex items-center justify-center">
        <div class="bg-white rounded-2xl shadow-lg p-8 md:p-12 text-center max-w-lg mx-auto">
            <div class="mx-auto flex items-center justify-center h-24 w-24 rounded-full bg-red-100 mb-6">
                <svg class="h-12 w-12 text-red-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                    stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </div>
            <h2 class="text-3xl font-extrabold text-gray-800 mb-4">Pagamento Cancelado</h2>
            <p class="text-gray-600 text-lg mb-8">
                A sua transação foi cancelada ou não pôde ser concluída. Nenhum valor foi cobrado.
            </p>

            <a href="{{ route('plans.index', $gym) }}"
                class="w-full inline-block bg-gray-600 text-white font-bold py-3 px-6 rounded-lg hover:bg-gray-700 transition-colors shadow-lg">
                Voltar aos Planos da Academia
            </a>
        </div>
    </div>
@endsection