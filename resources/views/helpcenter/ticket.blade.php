@extends('layouts.app')

@section('title', 'Abrir Chamado')

@section('content')
    <main>
        <h1 class="text-center">
            Abrir um Chamado
            @if(request('type') == 'gym')
                <small class="block text-sm">para uma de suas Academias</small>
            @else
                <small class="block text-sm">para o Crowd Gym</small>
            @endif
        </h1>
        
        @if (session('error'))
            <div class="alert error">{{ session('error') }}</div>
        @endif

        <form action="{{ route('helpcenter.ticket.store') }}" method="POST">
            @csrf
            <input type="hidden" name="type" value="{{ request('type') }}">

            @if(request('type') == 'gym')
                <div>
                    <label for="gym_id">Para qual academia?</label>
                    <select id="gym_id" name="gym_id" required>
                        <option value="" disabled selected>Selecione uma academia</option>
                        @forelse($gyms ?? [] as $gym)
                            <option value="{{ $gym->id }}">{{ $gym->name }}</option>
                        @empty
                            <option value="" disabled>Você não está matriculado em nenhuma academia.</option>
                        @endforelse
                    </select>
                    @error('gym_id')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>
            @endif

            <div>
                <label for="subject">Assunto:</label>
                <input type="text" id="subject" name="subject" value="{{ old('subject') }}" required>
                 @error('subject')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>
            <div>
                <label for="message">Mensagem:</label>
                <textarea id="message" name="message" required>{{ old('message') }}</textarea>
                 @error('message')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>
            <button type="submit">Enviar</button>
        </form>
    </main>
@endsection