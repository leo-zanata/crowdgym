@extends('layouts.auth')

@section('title', 'Login do Usuário')

@section('css-files')
    <link rel="stylesheet" href="{{ asset('css/auth/register_login.css') }}" />
@endsection

@section('content')
    <form action="{{ route('login') }}" method="POST" class="formLogin">
        <div class="form-header">
            <a href="{{ route('home') }}">
                <img src="{{ asset('img/favicon.png') }}" alt="Logo da Crowd Gym" />
            </a>
        </div>
        <div class="form-subheader">
            <div class="subtitle">
                <h2>Login</h2>
                <p>Digite os dados de acesso no campo abaixo.</p>
            </div>
        </div>
        @csrf <div class="input-group">
            <div class="input-box">
                <label for="email">E-mail*</label>
                <input type="text" name="email" placeholder="Digite o email" maxlength="255" id="email" required
                    value="{{ old('email') }}" />
            </div>
            <div class="input-box">
                <label for="password">Senha*</label>
                <input type="password" name="password" placeholder="Digite a senha" maxlength="15" id="password" required />
            </div>
            <div>
                <div class="forgot-password-group">
                    <div class="error">
                        @if ($errors->any())
                            <p id="mensagemErro" style="color: red;">{{ $errors->first('email') }}</p>
                        @endif
                    </div>
                    <div class="forgot-password">
                        <a href="recover_password.php">Esqueci minha senha</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="button-group">
            <input type="submit" value="Acessar conta" />
            <a href="{{ route('register') }}">Criar Conta</a>
        </div>
    </form>
@endsection