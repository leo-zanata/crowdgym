@extends('layouts.auth')

@section('title', 'Redefinir Senha')
@section('css-files')
    <link rel="stylesheet" href="{{ asset('css/auth/password.css') }}" />
@endsection

@section('content')
    <div class="auth-card">
        <h2>Redefinir Senha</h2>
        <p>Insira sua nova senha abaixo.</p>

        @if ($errors->any())
            <div class="alert alert-danger">
                @foreach ($errors->all() as $error)
                    {{ $error }}
                @endforeach
            </div>
        @endif

        <form action="{{ route('password.reset.post') }}" method="POST">
            @csrf
            <input type="hidden" name="email" value="{{ $email ?? '' }}">
            <input type="hidden" name="token" value="{{ $token ?? '' }}">

            <div class="input-box">
                <label for="password">Nova Senha*</label>
                <input type="password" name="password" id="password" required minlength="8">
            </div>

            <div class="input-box">
                <label for="password_confirmation">Confirmar Nova Senha*</label>
                <input type="password" name="password_confirmation" id="password_confirmation" required minlength="8">
            </div>

            <button type="submit">Redefinir Senha</button>
        </form>
    </div>
@endsection