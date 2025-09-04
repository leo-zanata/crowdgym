@extends('layouts.dashboard')

@section('title', 'Criar Novo Plano')

@section('content')
    <div class="container mx-auto px-4 py-8 max-w-lg">
        <div class="bg-white rounded-lg shadow-xl p-8">
            <h1 class="text-3xl font-bold text-gray-800 mb-6 text-center">Criar Novo Plano</h1>

            @if ($errors->any())
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg relative mb-4" role="alert">
                    <ul class="list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('manager.plans.store') }}" method="POST" class="space-y-6">
                @csrf
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700">Nome do Plano</label>
                    <input type="text" name="name" id="name" required
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                </div>

                <div>
                    <label for="description" class="block text-sm font-medium text-gray-700">Descrição (Opcional)</label>
                    <textarea name="description" id="description" rows="4"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"></textarea>
                </div>

                <div>
                    <label for="price" class="block text-sm font-medium text-gray-700">Preço</label>
                    <input type="number" name="price" id="price" step="0.01" min="0" required
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Tipo de Plano</label>
                    <div class="mt-2 flex space-x-4">
                        <label class="inline-flex items-center">
                            <input type="radio" name="type" value="principal" id="type-principal" checked
                                class="form-radio text-indigo-600">
                            <span class="ml-2 text-gray-700">Principal (Assinatura ou Avulso)</span>
                        </label>
                        <label class="inline-flex items-center">
                            <input type="radio" name="type" value="additional" id="type-additional"
                                class="form-radio text-indigo-600">
                            <span class="ml-2 text-gray-700">Adicional (Add-on)</span>
                        </label>
                    </div>
                </div>

                <div id="principal-plan-options">
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label for="duration" class="block text-sm font-medium text-gray-700">Duração</label>
                            <input type="number" name="duration" id="duration" min="1" required
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        </div>
                        <div>
                            <label for="duration_unit" class="block text-sm font-medium text-gray-700">Unidade de
                                Duração</label>
                            <select name="duration_unit" id="duration_unit" required
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                <option value="month">Mês(es)</option>
                                <option value="day">Dia(s) (Para aula avulsa)</option>
                            </select>
                        </div>
                    </div>

                    <div class="mt-6">
                        <label class="block text-sm font-medium text-gray-700">Fidelidade</label>
                        <div class="mt-2">
                            <label class="inline-flex items-center">
                                <input type="radio" name="loyalty_option" value="no_loyalty" checked
                                    class="form-radio text-indigo-600">
                                <span class="ml-2 text-gray-700">Sem Fidelidade</span>
                            </label>
                            <label class="inline-flex items-center ml-6">
                                <input type="radio" name="loyalty_option" value="with_loyalty"
                                    class="form-radio text-indigo-600">
                                <span class="ml-2 text-gray-700">Com Fidelidade</span>
                            </label>
                        </div>
                        <div id="loyalty-months-container" class="mt-4 hidden">
                            <label for="loyalty_months" class="block text-sm font-medium text-gray-700">Meses de
                                Fidelidade</label>
                            <input type="number" name="loyalty_months" id="loyalty_months" min="1"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                disabled>
                        </div>
                    </div>

                    <div class="mt-6">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Opções de Parcelamento
                            (Opcional)</label>
                        <label class="inline-flex items-center mr-4 mb-2">
                            <input type="checkbox" id="select-all-installments"
                                class="form-checkbox text-indigo-600 rounded">
                            <span class="ml-2 text-gray-700 font-bold">Selecionar Todas</span>
                        </label>

                        <div class="space-y-2">
                            @foreach([1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12] as $installment)
                                <label class="inline-flex items-center mr-4">
                                    <input type="checkbox" name="installment_options[]" value="{{ $installment }}"
                                        class="form-checkbox installment-option text-indigo-600 rounded">
                                    <span class="ml-2 text-gray-700">
                                        @if($installment === 1)
                                            À vista (1x)
                                        @else
                                            {{ $installment }}x
                                        @endif
                                    </span>
                                </label>
                            @endforeach
                        </div>
                    </div>

                    <div class="flex justify-end">
                        <button type="submit"
                            class="bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-4 rounded-lg shadow-lg transition duration-300 ease-in-out transform hover:scale-105">
                            Salvar Plano
                        </button>
                    </div>
            </form>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const typePrincipal = document.getElementById('type-principal');
            const typeAdditional = document.getElementById('type-additional');
            const principalOptions = document.getElementById('principal-plan-options');
            const loyaltyOptions = document.querySelectorAll('input[name="loyalty_option"]');
            const loyaltyMonthsContainer = document.getElementById('loyalty-months-container');
            const loyaltyMonthsInput = document.getElementById('loyalty_months');
            const selectAllInstallments = document.getElementById('select-all-installments');
            const installmentOptions = document.querySelectorAll('.installment-option');

            function togglePrincipalOptions() {
                if (typePrincipal.checked) {
                    principalOptions.classList.remove('hidden');
                    document.querySelectorAll('#principal-plan-options input, #principal-plan-options select').forEach(el => el.disabled = false);
                } else {
                    principalOptions.classList.add('hidden');
                    document.querySelectorAll('#principal-plan-options input, #principal-plan-options select').forEach(el => el.disabled = true);
                }
            }

            function toggleLoyaltyMonths() {
                const selectedOption = document.querySelector('input[name="loyalty_option"]:checked').value;
                if (selectedOption === 'with_loyalty') {
                    loyaltyMonthsContainer.classList.remove('hidden');
                    loyaltyMonthsInput.disabled = false;
                    loyaltyMonthsInput.required = true;
                } else {
                    loyaltyMonthsContainer.classList.add('hidden');
                    loyaltyMonthsInput.disabled = true;
                    loyaltyMonthsInput.required = false;
                    loyaltyMonthsInput.value = '';
                }
            }

            function toggleAllInstallments() {
                const isChecked = selectAllInstallments.checked;
                installmentOptions.forEach(checkbox => {
                    checkbox.checked = isChecked;
                });
            }

            typePrincipal.addEventListener('change', togglePrincipalOptions);
            typeAdditional.addEventListener('change', togglePrincipalOptions);

            loyaltyOptions.forEach(radio => {
                radio.addEventListener('change', toggleLoyaltyMonths);
            });

            selectAllInstallments.addEventListener('change', toggleAllInstallments);

            togglePrincipalOptions();
            toggleLoyaltyMonths();
        });
    </script>
@endsection