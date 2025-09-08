@extends('layouts.app')

@section('title', 'Academias Parceiras')

@section('content')
    <main class="bg-gray-100">
        <div class="container mx-auto px-4 py-12 md:py-16">
            <section class="text-center mb-12">
                <h1 class="text-4xl md:text-5xl font-bold text-gray-800 mb-2">Encontre a Academia Perfeita</h1>
                <p class="text-lg text-gray-600 max-w-2xl mx-auto">Explore nossa rede de parceiros e encontre o lugar ideal
                    para o seu próximo treino.</p>
            </section>

            <section class="mb-10 max-w-2xl mx-auto">
                <form action="{{ route('gyms.index') }}" method="GET" role="search">
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-4">
                            <i class="bi bi-search text-gray-500"></i>
                        </span>
                        <input type="search" name="search" placeholder="Buscar por nome ou cidade..."
                            class="w-full py-4 pl-12 pr-4 text-gray-700 border border-gray-300 rounded-full focus:outline-none focus:ring-2 focus:ring-blue-500 transition-shadow"
                            value="{{ request('search') }}" aria-label="Buscar Academia">
                        <button type="submit"
                            class="absolute top-0 right-0 h-full px-6 text-white bg-blue-600 hover:bg-blue-700 rounded-r-full font-semibold transition-colors">
                            Buscar
                        </button>
                    </div>
                </form>
            </section>

            <section>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">

                    @forelse($gyms as $gym)
                        <div class="bg-white rounded-lg shadow-lg overflow-hidden flex flex-col">

                            <div class="relative h-56 w-full">
                                <div class="absolute inset-0 bg-cover bg-center"
                                    style="background-image: url('{{ $gym->image_url ?? 'https://placehold.co/600x400/e2e8f0/4a5568?text=Crowd+Gym' }}')">
                                </div>
                            </div>

                            <div class="p-6 flex-grow">
                                <h3 class="text-xl font-bold text-gray-900 mb-4 truncate">{{ $gym->gym_name }}</h3>

                                <p class="text-gray-600 flex items-start">
                                    <i class="bi bi-geo-alt-fill mr-2 text-gray-500 mt-1"></i>
                                    <span>{{ $gym->address }}, {{ $gym->city }} - {{ $gym->state }}</span>
                                </p>
                            </div>

                            <div class="mt-auto">
                                <a href="{{ route('gyms.show', $gym) }}" class="text-blue-600 font-semibold hover:underline">
                                    Ver Academia
                                </a>
                            </div>

                            <div class="p-6 pt-0">
                                <a href=""
                                    class="block w-full text-center bg-blue-600 text-white font-bold py-3 px-4 rounded-lg hover:bg-blue-700 transition-colors">
                                    Ver Planos
                                </a>
                            </div>

                        </div>
                    @empty
                        <div class="col-span-full text-center py-16">
                            <i class="bi bi-exclamation-triangle-fill text-6xl text-gray-400 mb-4"></i>
                            <h2 class="text-2xl font-bold text-gray-700">Nenhuma academia encontrada</h2>
                            <p class="text-gray-500 mt-2">Tente refinar ou alterar os termos da sua busca.</p>
                        </div>
                    @endforelse

                </div>

                @if ($gyms->hasPages())
                    <div class="mt-12">
                        {{ $gyms->appends(request()->query())->links() }}
                    </div>
                @endif
            </section>

        </div>
    </main>
@endsection