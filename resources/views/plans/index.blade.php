@extends('layouts.app')

@section('title', 'Academias Parceiras')

@section('content')
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

                        <a href="#"
                            class="mt-auto block w-full bg-blue-600 text-white text-center font-bold py-3 px-6 rounded-lg hover:bg-blue-700 transition-colors shadow-lg">
                            Assinar Agora
                        </a>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
@endsection