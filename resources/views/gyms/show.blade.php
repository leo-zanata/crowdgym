@extends('layouts.app')

@section('title', $gym->gym_name)

@section('content')
    <div class="container mx-auto px-4 py-12 md:py-16">
        <div class="bg-white rounded-lg shadow-xl overflow-hidden">
            <div class="h-64 md:h-80 bg-cover bg-center"
                style="background-image: url('{{ $gym->image_url ?? 'https://placehold.co/1200x400/e2e8f0/4a5568?text=Crowd+Gym' }}');">
            </div>

            <div class="p-6 md:p-8">
                <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6">
                    <h1 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4 md:mb-0">{{ $gym->gym_name }}</h1>
                    <a href="{{ route('plans.index', $gym) }}"
                        class="w-full md:w-auto bg-blue-600 text-white font-bold py-3 px-6 rounded-lg hover:bg-blue-700 transition-colors text-center">
                        Ver Planos e Preços
                    </a>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-8 border-t border-gray-200 pt-6">
                    <div>
                        <h2 class="text-xl font-semibold text-gray-800 mb-4 flex items-center">
                            <i class="bi bi-geo-alt-fill mr-3 text-blue-600"></i>
                            Endereço
                        </h2>
                        <address class="not-italic text-gray-700 space-y-1">
                            <p>{{ $gym->street }}, {{ $gym->number }}
                                {{ $gym->complement ? '- ' . $gym->complement : '' }}
                            </p>
                            <p>{{ $gym->neighborhood }}</p>
                            <p>{{ $gym->city }} - {{ $gym->state }}</p>
                            <p>CEP: {{ $gym->zip_code }}</p>
                        </address>
                    </div>

                    @php
                        $daysOfWeek = [1 => 'Segunda-feira', 2 => 'Terça-feira', 3 => 'Quarta-feira', 4 => 'Quinta-feira', 5 => 'Sexta-feira', 6 => 'Sábado', 0 => 'Domingo'];
                        $groupedHours = $gym->operatingHours->groupBy(function ($item) {
                            return $item->opening_time . ' - ' . $item->closing_time;
                        });
                    @endphp

                    <div>
                        <h2 class="text-xl font-semibold text-gray-800 mb-4 flex items-center">
                            <i class="bi bi-clock-history mr-3 text-blue-600"></i>
                            Horário de Funcionamento
                        </h2>
                        <div class="text-gray-700 space-y-2">
                            @forelse($groupedHours as $timeRange => $hours)
                                @php
                                    $days = $hours->pluck('day_of_week')->map(fn($day) => $daysOfWeek[$day])->join(', ');
                                @endphp
                                <p><strong>{{ $days }}:</strong>
                                    {{ \Carbon\Carbon::parse(explode(' - ', $timeRange)[0])->format('H:i') }} -
                                    {{ \Carbon\Carbon::parse(explode(' - ', $timeRange)[1])->format('H:i') }}
                                </p>
                            @empty
                                <p>Horários não informados.</p>
                            @endforelse
                        </div>
                    </div>

                </div>

                <div class="mt-8 border-t border-gray-200 pt-6">
                    <h2 class="text-xl font-semibold text-gray-800 mb-4 flex items-center">
                        <i class="bi bi-images mr-3 text-blue-600"></i>
                        Galeria de Fotos
                    </h2>
                    <p class="text-gray-500">Em breve, você poderá ver mais fotos do espaço aqui!</p>
                </div>
            </div>
        </div>
    </div>
@endsection