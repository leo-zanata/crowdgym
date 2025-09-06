@extends('layouts.dashboard')

@section('title', 'Ticket de Suporte #' . ($ticket?->id ?? ''))

@section('content')
    <div class="container mx-auto px-4 py-8 max-w-2xl">
        <div class="bg-white rounded-lg shadow-xl p-8 mb-6">
            <div class="flex justify-between items-center mb-4">
                <h1 class="text-3xl font-bold text-gray-800">Ticket #{{ $ticket?->id }}</h1>
                <a href="{{ route('admin.tickets.index') }}"
                    class="text-blue-600 hover:text-blue-800 transition duration-150 ease-in-out">
                    &larr; Voltar para a lista
                </a>
            </div>

            <div class="bg-gray-100 p-6 rounded-lg mb-6">
                <div class="flex items-center space-x-4 mb-2">
                    <div class="flex-shrink-0">
                        <img class="h-10 w-10 rounded-full"
                            src="https://ui-avatars.com/api/?name={{ urlencode($ticket->user?->name ?? 'U') }}"
                            alt="Avatar">
                    </div>
                    <div class="flex-1">
                        <p class="font-bold text-gray-900">{{ $ticket->user?->name ?? 'Usuário Desconhecido' }}</p>
                        <p class="text-sm text-gray-500">{{ $ticket->created_at?->format('d/m/Y H:i') ?? '' }}</p>
                    </div>
                </div>
                <h2 class="text-xl font-semibold text-gray-800 mt-4">{{ $ticket?->subject }}</h2>
                <p class="text-gray-600 mt-2">{{ $ticket?->message }}</p>
            </div>

            @if (session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg relative mb-4"
                    role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif

            <div class="space-y-4 mb-6">
                @forelse($ticket?->replies ?? [] as $reply)
                    <div
                        class="p-4 rounded-lg {{ $reply->user_id === Auth::id() ? 'bg-indigo-100 text-indigo-900' : 'bg-gray-200 text-gray-800' }}">
                        <p class="font-semibold">{{ $reply->user?->name ?? 'Usuário Desconhecido' }}</p>
                        <p class="text-sm text-gray-600">{{ $reply->created_at?->format('d/m/Y H:i') ?? '' }}</p>
                        <p class="mt-2">{{ $reply->message }}</p>
                    </div>
                @empty
                    <p class="text-center text-gray-500">Nenhuma resposta ainda. Seja o primeiro a responder!</p>
                @endforelse
            </div>

            @if ($ticket?->status !== 'resolved')
                <div class="mt-4">
                    <form action="{{ route('admin.tickets.reply.store', $ticket) }}" method="POST" class="mb-4">
                        @csrf
                        <div>
                            <label for="message" class="block text-sm font-medium text-gray-700">Sua Resposta</label>
                            <textarea name="message" id="message" rows="4" required
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"></textarea>
                            @error('message')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="mt-4 text-right">
                            <button type="submit"
                                class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded-lg shadow-lg transition duration-300 ease-in-out transform hover:scale-105">
                                Enviar Resposta
                            </button>
                        </div>
                    </form>

                    <form action="{{ route('admin.tickets.resolve', $ticket) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <button type="submit"
                            class="w-full bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-4 rounded-lg shadow-lg transition duration-300 ease-in-out transform hover:scale-105">
                            Marcar como Resolvido
                        </button>
                    </form>
                </div>
            @else
                <div class="mt-4 p-4 rounded-lg bg-green-100 text-green-800 text-center font-semibold">
                    Este ticket já foi resolvido.
                </div>
            @endif
        </div>
    </div>
@endsection