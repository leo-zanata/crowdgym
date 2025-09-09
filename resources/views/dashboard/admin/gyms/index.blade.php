@extends('layouts.dashboard')
@section('title', 'Gerenciar Academias')

@section('content')
    <div class="container mx-auto px-4 py-8">
        <h1 class="text-3xl font-bold text-gray-800 mb-6">Gerenciar Academias</h1>

        <div class="mb-4">
            <form action="{{ route('admin.gyms.index') }}" method="GET">
                <input type="text" name="search" placeholder="Buscar por nome ou cidade..."
                    class="w-full md:w-1/3 p-2 border border-gray-300 rounded-md" value="{{ request('search') }}">
                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-md">Buscar</button>
            </form>
        </div>

        <div class="bg-white shadow-md rounded-lg overflow-x-auto">
            <table class="min-w-full leading-normal">
                <thead>
                    <tr>
                        <th
                            class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                            ID</th>
                        <th
                            class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                            Nome da Academia</th>
                        <th
                            class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                            Cidade/Estado</th>
                        <th
                            class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                            Status</th>
                        <th
                            class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                            Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($gyms as $gym)
                        <tr>
                            <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">{{ $gym->id }}</td>
                            <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">{{ $gym->gym_name }}</td>
                            <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">{{ $gym->city }} / {{ $gym->state }}
                            </td>
                            <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                <span
                                    class="px-2 py-1 font-semibold leading-tight rounded-full
                                        @if($gym->status == 'approved') bg-green-200 text-green-900 @elseif($gym->status == 'pending') bg-yellow-200 text-yellow-900 @else bg-red-200 text-red-900 @endif">
                                    {{ ucfirst($gym->status) }}
                                </span>
                            </td>
                            <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                <a href="{{ route('admin.gyms.edit', $gym) }}"
                                    class="text-blue-600 hover:text-blue-900 mr-3">Editar</a>
                                <form action="{{ route('admin.gyms.destroy', $gym) }}" method="POST" class="inline-block"
                                    onsubmit="return confirm('Tem certeza que deseja excluir esta academia?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-900">Excluir</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center py-10">Nenhuma academia encontrada.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="mt-4">
            {{ $gyms->links() }}
        </div>
    </div>
@endsection