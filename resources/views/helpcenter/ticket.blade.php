@extends('layouts.app')

@section('title', 'Abrir Chamado')

@section('content')
    <main>
        <h1>Abrir um Chamado</h1>
        <form action="{{ route('helpcenter.ticket.store') }}" method="POST">
            @csrf
            <div>
                <label for="subject">Assunto:</label>
                <input type="text" id="subject" name="subject" required>
            </div>
            <div>
                <label for="message">Mensagem:</label>
                <textarea id="message" name="message" required></textarea>
            </div>
            <button type="submit">Enviar</button>
        </form>
    </main>
@endsection