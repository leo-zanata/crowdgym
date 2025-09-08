@extends('layouts.dashboard')

@section('title', 'Gerenciar Minha Academia')

@section('content')
    <script src="//unpkg.com/alpinejs" defer></script>

    @php
        $daysOfWeek = ['1' => 'Segunda', '2' => 'Terça', '3' => 'Quarta', '4' => 'Quinta', '5' => 'Sexta', '6' => 'Sábado', '0' => 'Domingo'];
        $hourBlocks = old('hours', $gym->operatingHours->groupBy(function ($item) {
            return $item->opening_time . '-' . $item->closing_time;
        })->map(function ($group) {
            return [
                'days' => $group->pluck('day_of_week')->map(fn($day) => (string) $day)->all(),
                'opening_time' => \Carbon\Carbon::parse($group->first()->opening_time)->format('H:i'),
                'closing_time' => \Carbon\Carbon::parse($group->first()->closing_time)->format('H:i'),
            ];
        })->values()->all());
    @endphp

    <div class="container mx-auto px-4 py-8" x-data="gymHours({{ count($hourBlocks) }})">
        <h1 class="text-3xl font-bold text-gray-800 mb-6">Gerenciar Minha Academia</h1>

        <form action="{{ route('manager.gym.update') }}" method="POST">
            @csrf
            @method('PUT')

            <div class="bg-white p-8 rounded-lg shadow-lg">
                <h2 class="text-xl font-semibold mb-4">Informações Gerais</h2>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="gym_name" class="block text-sm font-medium text-gray-700">Nome da Academia</label>
                        <input type="text" name="gym_name" id="gym_name" value="{{ old('gym_name', $gym->gym_name) }}"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                        @error('gym_name') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <label for="gym_phone" class="block text-sm font-medium text-gray-700">Telefone da Academia</label>
                        <input type="text" name="gym_phone" id="gym_phone" value="{{ old('gym_phone', $gym->gym_phone) }}"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                        @error('gym_phone') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <label for="zip_code" class="block text-sm font-medium text-gray-700">CEP</label>
                        <input type="text" name="zip_code" id="zip_code" value="{{ old('zip_code', $gym->zip_code) }}"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                        @error('zip_code') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <label for="state" class="block text-sm font-medium text-gray-700">Estado*</label>
                        <select id="state" name="state" required
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                            <option value="">Selecione um estado</option>
                            @foreach($states as $sigla => $nome)
                                <option value="{{ $sigla }}" {{ old('state', $gym->state) == $sigla ? 'selected' : '' }}>
                                    {{ $nome }}
                                </option>
                            @endforeach
                        </select>
                        @error('state') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <label for="city" class="block text-sm font-medium text-gray-700">Cidade*</label>
                        <select id="city" name="city" required
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                            <option value="">Selecione um estado primeiro</option>
                        </select>
                        @error('city') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>
                    <div class="md:col-span-2">
                        <label for="street" class="block text-sm font-medium text-gray-700">Rua / Logradouro</label>
                        <input type="text" name="street" id="street" value="{{ old('street', $gym->street) }}"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                        @error('street') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <label for="number" class="block text-sm font-medium text-gray-700">Número</label>
                        <input type="text" name="number" id="number" value="{{ old('number', $gym->number) }}"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                        @error('number') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <label for="complement" class="block text-sm font-medium text-gray-700">Complemento
                            (Opcional)</label>
                        <input type="text" name="complement" id="complement"
                            value="{{ old('complement', $gym->complement) }}"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                        @error('complement') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>
                </div>

                <h2 class="text-xl font-semibold mb-4 mt-8 border-t pt-6">Horários de Funcionamento</h2>

                <div class="space-y-4">
                    @foreach ($hourBlocks as $index => $hourBlock)
                        <div class="p-4 border rounded-md relative">
                            <div class="mb-4">
                                <label class="block text-sm font-medium text-gray-700 mb-2">Dias</label>
                                <div class="grid grid-cols-2 sm:grid-cols-4 lg:grid-cols-7 gap-2">
                                    @foreach($daysOfWeek as $dayValue => $dayName)
                                        <label
                                            class="flex items-center space-x-2 p-2 border rounded-md hover:bg-gray-50 cursor-pointer">
                                            <input type="checkbox" name="hours[{{ $index }}][days][]" value="{{ $dayValue }}" {{ in_array($dayValue, $hourBlock['days'] ?? []) ? 'checked' : '' }} class="rounded">
                                            <span>{{ $dayName }}</span>
                                        </label>
                                    @endforeach
                                </div>
                                @error('hours.' . $index . '.days')
                                    <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Abre às</label>
                                    <input type="time" name="hours[{{ $index }}][opening_time]"
                                        value="{{ $hourBlock['opening_time'] ?? '08:00' }}"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                                    @error('hours.' . $index . '.opening_time')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Fecha às</label>
                                    <input type="time" name="hours[{{ $index }}][closing_time]"
                                        value="{{ $hourBlock['closing_time'] ?? '22:00' }}"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                                    @error('hours.' . $index . '.closing_time')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    @endforeach

                    <template x-for="i in newBlocks" :key="i">
                        <div class="p-4 border rounded-md relative">
                            <div class="mb-4">
                                <label class="block text-sm font-medium text-gray-700 mb-2">Dias</label>
                                <div class="grid grid-cols-2 sm:grid-cols-4 lg:grid-cols-7 gap-2">
                                    @foreach($daysOfWeek as $dayValue => $dayName)
                                        <label
                                            class="flex items-center space-x-2 p-2 border rounded-md hover:bg-gray-50 cursor-pointer">
                                            <input type="checkbox" :name="`hours[${i + initialCount -1}][days][]`"
                                                value="{{ $dayValue }}" class="rounded">
                                            <span>{{ $dayName }}</span>
                                        </label>
                                    @endforeach
                                </div>
                            </div>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Abre às</label>
                                    <input type="time" :name="`hours[${i + initialCount -1}][opening_time]`" value="08:00"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Fecha às</label>
                                    <input type="time" :name="`hours[${i + initialCount -1}][closing_time]`" value="22:00"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                                </div>
                            </div>
                        </div>
                    </template>
                </div>

                <button type="button" @click="addBlock()"
                    class="mt-4 bg-gray-200 hover:bg-gray-300 text-gray-800 font-bold py-2 px-4 rounded inline-flex items-center">
                    <i class="bi bi-plus-circle-fill mr-2"></i> Adicionar Bloco de Horário
                </button>

                <div class="mt-8 pt-6 border-t">
                    <button type="submit"
                        class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-6 rounded-lg transition-colors">
                        Salvar Alterações
                    </button>
                </div>
            </div>
        </form>
    </div>
@endsection
@section('js-files')
    <script>
        function gymHours(initialCount) {
            return {
                initialCount: initialCount,
                newBlocks: 0,
                addBlock() {
                    this.newBlocks++;
                }
            }
        }
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const stateSelect = document.getElementById('state');
            const citySelect = document.getElementById('city');
            const oldCity = "{{ old('city', $gym->city) }}";

            function fetchCities(stateAbbr, selectedCity = null) {
                if (!stateAbbr) {
                    citySelect.innerHTML = '<option value="">Selecione um estado primeiro</option>';
                    return;
                }

                fetch(`{{ url('/api/cities') }}/${stateAbbr}`)
                    .then(response => response.json())
                    .then(cities => {
                        citySelect.innerHTML = '<option value="">Selecione uma cidade</option>';
                        cities.forEach(city => {
                            const option = document.createElement('option');
                            option.value = city;
                            option.textContent = city;
                            if (city === selectedCity) {
                                option.selected = true;
                            }
                            citySelect.appendChild(option);
                        });
                    })
                    .catch(error => {
                        console.error('Erro ao buscar cidades:', error);
                        citySelect.innerHTML = '<option value="">Erro ao carregar cidades</option>';
                    });
            }

            stateSelect.addEventListener('change', function () {
                fetchCities(this.value);
            });

            if (stateSelect.value) {
                fetchCities(stateSelect.value, oldCity);
            }
        });
    </script>
@endsection