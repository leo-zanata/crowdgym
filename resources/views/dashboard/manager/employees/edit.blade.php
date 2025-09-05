@extends('layouts.dashboard')

@section('title', 'Editar Funcionário')

@section('content')

<div class="container mx-auto px-4 py-8 max-w-lg">
<div class="bg-white rounded-lg shadow-xl p-8">
<h1 class="text-3xl font-bold text-gray-800 mb-6 text-center">Editar Funcionário</h1>

    @if ($errors->any())
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg relative mb-4" role="alert">
            <ul class="list-disc list-inside">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('manager.employees.update', $employee) }}" method="POST" class="space-y-6">
        @csrf
        @method('PUT')
        
        <div>
            <label for="name" class="block text-sm font-medium text-gray-700">Nome</label>
            <input type="text" name="name" id="name" value="{{ old('name', $employee->name) }}" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
        </div>

        <div>
            <label for="email" class="block text-sm font-medium text-gray-700">E-mail</label>
            <input type="email" name="email" id="email" value="{{ old('email', $employee->email) }}" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
        </div>

        <div>
            <label for="cpf" class="block text-sm font-medium text-gray-700">CPF</label>
            <input type="text" name="cpf" id="cpf" value="{{ old('cpf', $employee->cpf) }}" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
        </div>
        
        <div>
            <label for="birth" class="block text-sm font-medium text-gray-700">Data de Nascimento</label>
            <input type="date" name="birth" id="birth" value="{{ old('birth', \Carbon\Carbon::parse($employee->birth)->format('Y-m-d')) }}" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
        </div>
        
        <div>
            <label for="gender" class="block text-sm font-medium text-gray-700">Gênero</label>
            <select name="gender" id="gender" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                <option value="masculino" @if(old('gender', $employee->gender) == 'masculino') selected @endif>Masculino</option>
                <option value="feminino" @if(old('gender', $employee->gender) == 'feminino') selected @endif>Feminino</option>
                <option value="outro" @if(old('gender', $employee->gender) == 'outro') selected @endif>Outro</option>
            </select>
        </div>
        
        <hr class="border-gray-300 my-4">
        
        <div>
            <label for="password" class="block text-sm font-medium text-gray-700">Nova Senha (Opcional)</label>
            <input type="password" name="password" id="password" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
        </div>
        
        <div>
            <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Confirmar Nova Senha</label>
            <input type="password" name="password_confirmation" id="password_confirmation" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
        </div>

        <div class="flex justify-between mt-6">
            <a href="{{ route('manager.employees.index') }}" class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded-lg shadow-lg transition duration-300 ease-in-out transform hover:scale-105">
                Cancelar
            </a>
            <button type="submit" class="bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-4 rounded-lg shadow-lg transition duration-300 ease-in-out transform hover:scale-105">
                Atualizar Funcionário
            </button>
        </div>
    </form>
</div>

</div>
@endsection