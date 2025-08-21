@extends('layouts.app')

@section('title', 'Tela Inicial')

@section('css-files')
    <link rel="stylesheet" href="{{ asset('css/welcome.css') }}" />
@endsection

@section('content')
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
        <div class="register-gym">
            <a href="{{ route('gym.register') }}"><span>Cadastre sua academia</span></a>
        </div>
    </div>
@endsection