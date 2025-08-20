<!DOCTYPE html>
<html lang="pt-br">

<head>
    <title>Login usuário</title>
    <link rel="stylesheet" href="{{ asset('css/index.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/auth/register_login.css') }}" />
</head>

<body>
    <main>
        <div class="container">
            <div class="form">
                <form action="{{ route('login') }}" method="POST" class="formLogin">
                    <div class="form-header">
                        <div class="title">
                            <h1>Crowd Gym</h1>
                        </div>
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
                            <input type="text" name="email" placeholder="Digite o email" maxlength="255" id="email"
                                required value="{{ old('email') }}" />
                        </div>
                        <div class="input-box">
                            <label for="password">Senha*</label>
                            <input type="password" name="password" placeholder="Digite a senha" maxlength="15"
                                id="password" required />
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
                        <div class="button">
                            <input type="submit" value="Acessar conta" />
                        </div>
                        <div class="button">
                            <a href="{{ route('register') }}">Criar Conta</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </main>
</body>

</html>