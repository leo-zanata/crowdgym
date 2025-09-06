@extends('layouts.auth')

@section('title', 'Verificar E-mail')

@section('content')
    <div class="auth-card">
        <h2>Verificar E-mail</h2>
        <p>Um código de verificação foi enviado para o seu e-mail. Por favor, insira-o abaixo para continuar.</p>

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

        <form action="{{ route('verification.verify') }}" method="POST">
            @csrf
            <div class="input-box">
                <label for="code">Código de Verificação*</label>
                <input type="text" name="code" id="code" required maxlength="4">
            </div>

            <button type="submit">Verificar</button>
        </form>

        <form action="{{ route('verification.resend') }}" method="POST" style="margin-top: 1rem;">
            @csrf
            <button type="submit" class="link-button">Reenviar Código</button>
        </form>

        <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Sair</a>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
            @csrf
        </form>
    </div>
@endsection