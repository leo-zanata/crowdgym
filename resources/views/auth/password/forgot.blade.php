@extends('layouts.auth')

@section('title', 'Esqueci a Senha')
@section('css-files')
    <link rel="stylesheet" href="{{ asset('css/auth/password.css') }}" />
@endsection

@section('content')
    <div class="auth-card">
        <div class="header-logo">
            <a href="{{ route('home') }}">
                <img src="{{ asset('img/favicon.png') }}" alt="Logo da Crowd Gym" />
            </a>
        </div>
        <h2>Esqueci a Senha</h2>
        <p>Insira seu e-mail para receber um código de recuperação.</p>

        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="alert alert-danger">
                @foreach ($errors->all() as $error)
                    {{ $error }}
                @endforeach
            </div>
        @endif

        <form action="{{ route('password.email') }}" method="POST" id="communicationForm">
            @csrf
            <div class="input-box">
                <label for="email">E-mail*</label>
                <input type="email" name="email" id="email" required value="{{ old('email') }}">
            </div>

            <button type="submit" id="submitButton">Enviar Código</button>
        </form>
        <a href="{{ route('login') }}" class="back-link">Voltar para o Login</a>
    </div>
@endsection

@section('js-files')
    <script src="{{ asset('js/disable-submit-button.js') }}"></script>
@endsection