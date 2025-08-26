@extends('layouts.dashboard')

@section('title', 'Dashboard do Aluno')

@section('css-files')
    <link rel="stylesheet" href="{{ asset('css/member/dashboard.css') }}" />
@endsection

@section('content')
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
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="{{ asset('js/charts/hours_of_exercise_per_week.js') }}"></script>
@endsection