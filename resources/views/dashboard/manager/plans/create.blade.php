@extends('layouts.dashboard')

@section('title', 'Criar Novo Plano')

@section('content')
<div class="container mx-auto px-4 py-8 max-w-2xl">
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

        <form action="{{ route('manager.plans.store') }}" method="POST" class="space-y-6" x-data="{ billing_type: 'recurring' }">
            @csrf

            <div>
                <label for="name" class="block text-sm font-medium text-gray-700">Nome do Plano</label>
                <input type="text" name="name" id="name" value="{{ old('name') }}" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
            </div>

            <div>
                <label for="description" class="block text-sm font-medium text-gray-700">Descrição (Opcional)</label>
                <textarea name="description" id="description" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">{{ old('description') }}</textarea>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Modelo de Cobrança</label>
                <div class="mt-2 grid grid-cols-2 gap-4">
                    <label @click="billing_type = 'recurring'" class="cursor-pointer border rounded-lg p-4 text-center" :class="{ 'border-indigo-600 ring-2 ring-indigo-600': billing_type === 'recurring', 'border-gray-300': billing_type !== 'recurring' }">
                        <input type="radio" name="billing_type" value="recurring" class="sr-only" checked>
                        <span class="font-medium text-gray-900">Recorrente</span>
                        <span class="block text-sm text-gray-500">Cobrar uma tarifa contínua</span>
                    </label>
                    <label @click="billing_type = 'one-time'" class="cursor-pointer border rounded-lg p-4 text-center" :class="{ 'border-indigo-600 ring-2 ring-indigo-600': billing_type === 'one-time', 'border-gray-300': billing_type !== 'one-time' }">
                        <input type="radio" name="billing_type" value="one-time" class="sr-only">
                        <span class="font-medium text-gray-900">Avulso</span>
                        <span class="block text-sm text-gray-500">Cobrar uma tarifa avulsa</span>
                    </label>
                </div>
            </div>

            <div>
                <label for="price" class="block text-sm font-medium text-gray-700">Preço</label>
                <input type="number" name="price" id="price" value="{{ old('price') }}" step="0.01" min="0" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
            </div>

            <div x-show="billing_type === 'recurring'" x-transition class="space-y-4 border-t pt-6">
                <div>
                    <label for="duration_unit" class="block text-sm font-medium text-gray-700">Período de Faturamento</label>
                    <select name="duration_unit" id="duration_unit" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        <option value="day">Diário</option>
                        <option value="week">Semanal</option>
                        <option value="month" selected>Mensal</option>
                        <option value="year">Anual</option>
                    </select>
                </div>

                <div>
                    <label for="loyalty_months" class="block text-sm font-medium text-gray-700">Meses de Fidelidade (Opcional, 0 para sem fidelidade)</label>
                    <input type="number" name="loyalty_months" id="loyalty_months" value="{{ old('loyalty_months', 0) }}" min="0" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Opções de Parcelamento (Opcional)</label>
                    <div class="grid grid-cols-4 gap-2">
                        @foreach([1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12] as $installment)
                            <label class="inline-flex items-center">
                                <input type="checkbox" name="installment_options[]" value="{{ $installment }}" class="form-checkbox installment-option text-indigo-600 rounded">
                                <span class="ml-2 text-gray-700">{{ $installment === 1 ? 'À vista' : $installment.'x' }}</span>
                            </label>
                        @endforeach
                    </div>
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Tipo de Plano</label>
                <div class="mt-2 flex space-x-4">
                    <label class="inline-flex items-center">
                        <input type="radio" name="type" value="principal" class="form-radio text-indigo-600" checked>
                        <span class="ml-2 text-gray-700">Principal</span>
                    </label>
                    <label class="inline-flex items-center">
                        <input type="radio" name="type" value="additional" class="form-radio text-indigo-600">
                        <span class="ml-2 text-gray-700">Adicional</span>
                    </label>
                </div>
            </div>
            
            <input type="hidden" name="duration" value="1">
            
            <div class="flex justify-end pt-4">
                <button type="submit" class="bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-4 rounded-lg shadow-lg transition duration-300 ease-in-out transform hover:scale-105">
                    Salvar Plano
                </button>
            </div>
        </form>
    </div>
</div>
@endsection