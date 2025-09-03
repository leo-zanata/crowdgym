@extends('layouts.auth')

@section('title', 'Verificar Código')
@section('css-files')
    <link rel="stylesheet" href="{{ asset('css/auth/password.css') }}" />
@endsection

@section('content')
    <div class="auth-card">
        <h2>Verificar Código</h2>
        <p>Um código de 4 dígitos foi enviado para o seu e-mail. Por favor, insira-o abaixo.</p>

        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="alert alert-danger">
                @foreach ($errors->all() as $error)
                    {{ $error }}
                @endforeach
            </div>
        @endif

        <form action="{{ route('password.verify.post') }}" method="POST">
            @csrf
            <input type="hidden" name="email" value="{{ session('email') }}">
            <div class="input-box">
                <label for="code">Código de Verificação*</label>
                <input type="text" name="code" id="code" required maxlength="4">
            </div>

            <button type="submit">Verificar</button>
        </form>
    </div>
@endsection