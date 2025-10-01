@extends('layouts.dashboard')

@section('title', 'Editar Plano')

@section('content')
<div class="container mx-auto px-4 py-8 max-w-2xl">
    <div class="bg-white rounded-lg shadow-xl p-8">
        <h1 class="text-3xl font-bold text-gray-800 mb-6 text-center">Editar Plano: {{ $plan->name }}</h1>

        @if(session('error'))
            <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded-md mb-6" role="alert">
                <p class="font-bold">Erro!</p>
                <p>{{ session('error') }}</p>
            </div>
        @endif
        @if ($errors->any())
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg relative mb-6" role="alert">
            <ul class="list-disc list-inside">
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <form action="{{ route('manager.plans.update', $plan) }}" method="POST" class="space-y-6" x-data="{ billing_type: '{{ old('billing_type', $plan->billing_type) }}' }">
            @csrf
            @method('PUT')

            <div>
                <label for="name" class="block text-sm font-medium text-gray-700">Nome do Plano</label>
                <input type="text" name="name" id="name" value="{{ old('name', $plan->name) }}" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
            </div>

            <div>
                <label for="description" class="block text-sm font-medium text-gray-700">Descrição (Opcional)</label>
                <textarea name="description" id="description" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">{{ old('description', $plan->description) }}</textarea>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Modelo de Cobrança</label>
                <p class="text-xs text-gray-500">Este campo não pode ser alterado após a criação.</p>
                <div class="mt-2 grid grid-cols-2 gap-4">
                    <div class="border rounded-lg p-4 text-center {{ $plan->billing_type === 'recurring' ? 'border-indigo-600 ring-2 ring-indigo-600 bg-gray-50' : 'border-gray-300 bg-gray-100 text-gray-400' }}">
                        <span class="font-medium">Recorrente</span>
                    </div>
                    <div class="border rounded-lg p-4 text-center {{ $plan->billing_type === 'one-time' ? 'border-indigo-600 ring-2 ring-indigo-600 bg-gray-50' : 'border-gray-300 bg-gray-100 text-gray-400' }}">
                        <span class="font-medium">Avulso</span>
                    </div>
                    <input type="hidden" name="billing_type" value="{{ $plan->billing_type }}">
                </div>
            </div>

            <div>
                <label for="price" class="block text-sm font-medium text-gray-700">Preço</label>
                <p class="text-xs text-gray-500">Alterar o preço irá criar um novo preço na Stripe e arquivar o antigo. Assinaturas existentes não serão afetadas.</p>
                <input type="number" name="price" id="price" value="{{ old('price', $plan->price) }}" step="0.01" min="0" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
            </div>

            <div x-show="billing_type === 'recurring'" x-transition class="space-y-4 border-t pt-6">
                <div>
                    <label for="duration_unit" class="block text-sm font-medium text-gray-700">Período de Faturamento</label>
                    <p class="text-xs text-gray-500">Este campo não pode ser alterado após a criação.</p>
                    <select name="duration_unit" id="duration_unit" class="mt-1 block w-full rounded-md border-gray-300 bg-gray-100 shadow-sm" disabled>
                        <option value="day" {{ $plan->duration_unit == 'day' ? 'selected' : '' }}>Diário</option>
                        <option value="week" {{ $plan->duration_unit == 'week' ? 'selected' : '' }}>Semanal</option>
                        <option value="month" {{ $plan->duration_unit == 'month' ? 'selected' : '' }}>Mensal</option>
                        <option value="year" {{ $plan->duration_unit == 'year' ? 'selected' : '' }}>Anual</option>
                    </select>
                </div>

                <div>
                    <label for="loyalty_months" class="block text-sm font-medium text-gray-700">Meses de Fidelidade (Opcional, 0 para sem fidelidade)</label>
                    <input type="number" name="loyalty_months" id="loyalty_months" value="{{ old('loyalty_months', $plan->loyalty_months ?? 0) }}" min="0" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Opções de Parcelamento (Opcional)</label>
                    <div class="grid grid-cols-4 gap-2">
                         @foreach([1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12] as $installment)
                            <label class="inline-flex items-center">
                                <input type="checkbox" name="installment_options[]" value="{{ $installment }}" 
                                @if(is_array(old('installment_options', $plan->installment_options)) && in_array($installment, old('installment_options', $plan->installment_options))) checked @endif
                                class="form-checkbox installment-option text-indigo-600 rounded">
                                <span class="ml-2 text-gray-700">{{ $installment === 1 ? 'À vista' : $installment.'x' }}</span>
                            </label>
                        @endforeach
                    </div>
                </div>
            </div>

            <input type="hidden" name="duration" value="{{ $plan->duration }}">
            <input type="hidden" name="type" value="{{ $plan->type }}">

            <div class="flex justify-end pt-4">
                <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded-lg shadow-lg">
                    Atualizar Plano
                </button>
            </div>
        </form>
    </div>
</div>
@endsection