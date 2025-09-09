@extends('layouts.dashboard')
@section('title', 'Editar Usuário')

@section('content')
    <div class="container mx-auto px-4 py-8 max-w-2xl">
        <h1 class="text-3xl font-bold text-gray-800 mb-6">Editar Usuário: {{ $user->name }}</h1>

        <div class="bg-white p-8 rounded-lg shadow-lg">
            <form action="{{ route('admin.users.update', $user) }}" method="POST">
                @csrf
                @method('PUT')            
                <div class="mb-4">
                    <label for="name" class="block text-sm font-medium text-gray-700">Nome do Usuário</label>
                    <input type="text" name="name" id="name" value="{{ old('name', $user->name) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                    @error('name') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>
                <div class="mb-4">
                    <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                    <input type="email" name="email" id="email" value="{{ old('email', $user->email) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                    @error('email') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>

                <div class="border-t pt-6 mt-6">
                    <p class="text-sm text-gray-600 mb-4">Deixe os campos abaixo em branco para não alterar a senha do usuário.</p>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-4">
                        <div>
                            <label for="password" class="block text-sm font-medium text-gray-700">Nova Senha</label>
                            <input type="password" name="password" id="password" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                            @error('password') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>
                        <div>
                            <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Confirmar Nova Senha</label>
                            <input type="password" name="password_confirmation" id="password_confirmation" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                        </div>
                    </div>
                </div>

                <div class="mb-4 border-t pt-6 mt-6">
                    <label for="type" class="block text-sm font-medium text-gray-700">Tipo de Usuário</label>
                    <select name="type" id="type" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                        <option value="admin" {{ old('type', $user->type) == 'admin' ? 'selected' : '' }}>Admin</option>
                        <option value="manager" {{ old('type', $user->type) == 'manager' ? 'selected' : '' }}>Gerente</option>
                        <option value="employee" {{ old('type', $user->type) == 'employee' ? 'selected' : '' }}>Funcionário</option>
                        <option value="member" {{ old('type', $user->type) == 'member' ? 'selected' : '' }}>Aluno</option>
                    </select>
                    @error('type') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>

                <div class="mt-6 text-right">
                    <a href="{{ route('admin.users.index') }}" class="text-gray-600 mr-4">Cancelar</a>
                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-6 rounded-lg">
                        Salvar Alterações
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection