@extends('layouts.app')

@section('title', 'Academias Parceiras')

@section('content')
    <div class="bg-gray-100 min-h-screen py-12">
        <div class="container mx-auto px-4">

            <div class="text-center mb-12">
                <h1 class="text-4xl md:text-5xl font-extrabold text-gray-800">Planos e Preços</h1>
                <p class="text-xl text-gray-600 mt-2">Confira as opções da <span
                        class="font-bold text-blue-600">{{ $gym->gym_name }}</span></p>
                <div class="mt-4">
                    <a href="{{ route('gyms.show', $gym) }}" class="text-blue-500 hover:text-blue-700 transition-colors">
                        &larr; Voltar para a página da academia
                    </a>
                </div>
            </div>

            @if (session('error'))
                <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded-md mb-8" role="alert">
                    <p class="font-bold">Atenção!</p>
                    <p>{{ session('error') }}</p>
                </div>
            @endif

            @if($plans->isEmpty())
                <div class="text-center bg-white p-8 rounded-lg shadow-md">
                    <p class="text-gray-600 text-lg">Esta academia ainda não cadastrou nenhum plano.</p>
                </div>
            @else
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    @foreach ($plans as $plan)
                        <div
                            class="bg-white rounded-2xl shadow-lg p-8 flex flex-col transform hover:scale-105 transition-transform duration-300">
                            <h3 class="text-2xl font-bold text-gray-800 mb-4">{{ $plan->name }}</h3>

                            <div class="mb-6">
                                <span class="text-5xl font-extrabold text-gray-900">
                                    R$ {{ number_format($plan->price, 2, ',', '.') }}
                                </span>
                                <span class="text-lg text-gray-500">/ {{ $plan->duration }} {{ $plan->duration_unit }}</span>
                            </div>

                            <p class="text-gray-600 mb-8 flex-grow">
                                {{ $plan->description }}
                            </p>

                            <div x-data="{ loading: false }" class="mt-auto">
                                <a href="{{ route('checkout.create', $plan) }}"
                                    @click="loading = true; event.preventDefault(); window.location.href = $el.href;"
                                    class="flex items-center justify-center w-full bg-blue-600 text-white text-center font-bold py-3 px-6 rounded-lg hover:bg-blue-700 transition-colors shadow-lg"
                                    :class="{ 'opacity-50 cursor-not-allowed': loading }">

                                    <svg x-show="loading" class="animate-spin -ml-1 mr-3 h-5 w-5 text-white"
                                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4">
                                        </circle>
                                        <path class="opacity-75" fill="currentColor"
                                            d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                        </path>
                                    </svg>

                                    <span x-show="!loading">Assinar Agora</span>
                                    <span x-show="loading">Processando...</span>
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif

        </div>
    </div>
@endsection