<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="{{ asset('css/welcome.css') }}" />
    <title>Tela inicio</title>
</head>

<body>
    <main>
        <div class="header">
            <div class="crowd">
                <h1>Crowd Gym</h1>
            </div>
        </div>
        <div class="buttons">
            <div class="join-student">
                <a href="{{ route('login') }}"><span>Entrar</span></a>
            </div>
            <div class="register-student">
                <a href="{{ route('register') }}"><span>Criar uma Conta</span></a>
            </div>
            {{--<div class="register-gym">
                <a href="#"><span>Cadastre sua academia</span></a>
            </div>--}}
        </div>
    </main>
    {{-- Blade não tem include, mas pode usar @include --}}
    {{-- @include('partials.footer') --}}
</body>

</html>