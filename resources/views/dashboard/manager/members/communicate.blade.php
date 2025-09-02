@extends('layouts.dashboard')

@section('title', 'Comunicar com Membros')

@section('content')
    <div class="content">
        <h1>Comunicar com Membros</h1>

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

        @if ($errors->has('_token'))
            <div class="alert alert-danger">
                {{ $errors->first('_token') }}
            </div>
        @endif

        <form id="communicationForm" action="{{ route('manager.members.send') }}" method="POST">
            @csrf

            <div class="input-box">
                <label for="subject">Assunto*</label>
                <input type="text" name="subject" id="subject" required value="{{ old('subject') }}">
                @error('subject') <span class="text-red-500">{{ $message }}</span> @enderror
            </div>

            <div class="input-box">
                <label for="message">Mensagem*</label>
                <textarea name="message" id="message" rows="5" required>{{ old('message') }}</textarea>
                @error('message') <span class="text-red-500">{{ $message }}</span> @enderror
            </div>

            <button type="submit" id="submitButton">Enviar Mensagem</button>
        </form>
    </div>
@endsection
@section('js-files')
    <script src="{{ asset('js/disable-submit-button.js') }}"></script>
@endsection