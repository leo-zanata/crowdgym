@extends('layouts.dashboard')

@section('title', 'Cadastrar Funcionário')

@section('content')
    <main>
        <h1>Cadastrar Novo Funcionário</h1>

        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <form action="{{ route('manager.employees.store') }}" method="POST">
            @csrf

            <div class="input-group">
                <div class="input-box">
                    <label for="name">Nome Completo*</label>
                    <input type="text" name="name" id="name" required value="{{ old('name') }}">
                    @error('name') <span class="text-red-500">{{ $message }}</span> @enderror
                </div>

                <div class="input-box">
                    <label for="email">E-mail*</label>
                    <input type="email" name="email" id="email" required value="{{ old('email') }}">
                    @error('email') <span class="text-red-500">{{ $message }}</span> @enderror
                </div>

                <div class="input-box">
                    <label for="password">Senha*</label>
                    <input type="password" name="password" id="password" required>
                    @error('password') <span class="text-red-500">{{ $message }}</span> @enderror
                </div>

                <div class="input-box">
                    <label for="password_confirmation">Confirmar Senha*</label>
                    <input type="password" name="password_confirmation" id="password_confirmation" required>
                </div>

                <div class="input-box">
                    <label for="cpf">CPF*</label>
                    <input type="text" name="cpf" id="cpf" required value="{{ old('cpf') }}">
                    @error('cpf') <span class="text-red-500">{{ $message }}</span> @enderror
                </div>

                <div class="input-box">
                    <label for="birth">Data de Nascimento*</label>
                    <input type="date" name="birth" id="birth" required value="{{ old('birth') }}">
                    @error('birth') <span class="text-red-500">{{ $message }}</span> @enderror
                </div>

                <div class="input-box">
                    <label for="gender">Gênero*</label>
                    <select name="gender" id="gender" required>
                        <option value="">Selecione o gênero</option>
                        <option value="masculino" {{ old('gender') == 'masculino' ? 'selected' : '' }}>Masculino</option>
                        <option value="feminino" {{ old('gender') == 'feminino' ? 'selected' : '' }}>Feminino</option>
                        <option value="outro" {{ old('gender') == 'outro' ? 'selected' : '' }}>Outro</option>
                    </select>
                    @error('gender') <span class="text-red-500">{{ $message }}</span> @enderror
                </div>
            </div>

            <button type="submit">Cadastrar Funcionário</button>
        </form>
    </main>
@endsection