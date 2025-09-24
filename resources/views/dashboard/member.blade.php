@extends('layouts.dashboard')

@section('title', 'Dashboard do Aluno')

@section('css-files')
    <link rel="stylesheet" href="{{ asset('css/member/dashboard.css') }}" />
@endsection

@section('content')
    <section class="mb-8">
        <h2 class="text-2xl font-bold text-gray-800 mb-4">Minha Assinatura</h2>
        @if ($subscription)
            <x-subscription-card :subscription="$subscription" />
        @else
            <div class="bg-blue-100 border-l-4 border-blue-500 text-blue-700 p-4 rounded-md" role="alert">
                <p class="font-bold">Nenhuma assinatura ativa</p>
                <p>Você ainda não possui um plano ativo. Que tal encontrar uma academia e começar a treinar?</p>
                <a href="{{ route('gyms.index') }}"
                    class="mt-3 inline-block bg-blue-500 text-white font-bold py-2 px-4 rounded hover:bg-blue-700">
                    Ver Academias
                </a>
            </div>
        @endif
    </section>

    <section>
        <div class="chart-container">
            <canvas id="graficoHorasTreino"></canvas>
        </div>
        <div class="info">
            <div class="last-train">
                <h2>Último Treino Realizado</h2>
                <p>{{ $lastTrainingDate }}</p>
            </div>
            <div class="time-arrive">
                <h2>Horário de Chegada</h2>
                <p>{{ $checkIn }}</p>
            </div>
            <div class="time-left">
                <h2>Horário de Saída</h2>
                <p>{{ $checkOut }}</p>
            </div>
        </div>
    </section>
@endsection

@section('js-files')
    <script src="{{ asset('js/charts/hours_of_exercise_per_week.js') }}"></script>
@endsection