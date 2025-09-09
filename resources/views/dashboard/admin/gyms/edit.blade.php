@extends('layouts.dashboard')
@section('title', 'Editar Academia')

@section('content')
    <div class="container mx-auto px-4 py-8 max-w-2xl">
        <h1 class="text-3xl font-bold text-gray-800 mb-6">Editar Academia: {{ $gym->gym_name }}</h1>

        <div class="bg-white p-8 rounded-lg shadow-lg">
            <form action="{{ route('admin.gyms.update', $gym) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-4">
                    <label for="gym_name" class="block text-sm font-medium text-gray-700">Nome da Academia</label>
                    <input type="text" name="gym_name" id="gym_name" value="{{ old('gym_name', $gym->gym_name) }}"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-4">
                    <div>
                        <label for="city" class="block text-sm font-medium text-gray-700">Cidade</label>
                        <input type="text" name="city" id="city" value="{{ old('city', $gym->city) }}"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                    </div>
                    <div>
                        <label for="state" class="block text-sm font-medium text-gray-700">Estado (UF)</label>
                        <input type="text" name="state" id="state" value="{{ old('state', $gym->state) }}"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                    </div>
                </div>

                <div class="mb-4">
                    <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
                    <select name="status" id="status" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                        <option value="pending" {{ old('status', $gym->status) == 'pending' ? 'selected' : '' }}>Pendente
                        </option>
                        <option value="approved" {{ old('status', $gym->status) == 'approved' ? 'selected' : '' }}>Aprovado
                        </option>
                        <option value="rejected" {{ old('status', $gym->status) == 'rejected' ? 'selected' : '' }}>Rejeitado
                        </option>
                    </select>
                </div>

                <div class="mt-6 text-right">
                    <a href="{{ route('admin.gyms.index') }}" class="text-gray-600 mr-4">Cancelar</a>
                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-6 rounded-lg">
                        Salvar Alterações
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection