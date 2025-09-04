@extends('layouts.dashboard') 

@section('title', 'Gerenciar Membros')

@section('content')

<div class="container mx-auto px-4 py-8">
<div class="flex justify-between items-center mb-6">
<h1 class="text-3xl font-bold text-gray-800">Membros da Academia</h1>
</div>

@if (session('success'))
    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg relative mb-4" role="alert">
        <span class="block sm:inline">{{ session('success') }}</span>
    </div>
@endif

<div class="bg-white rounded-lg shadow-xl overflow-hidden">
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nome</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">E-mail</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Plano de Assinatura</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status da Assinatura</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse ($members as $member)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $member->name }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $member->email }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            @if($member->subscription && $member->subscription->plan)
                                {{ $member->subscription->plan->name }}
                            @else
                                Nenhum plano
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                            @if($member->subscription)
                                @php
                                    $statusClass = '';
                                    switch ($member->subscription->stripe_status) {
                                        case 'active':
                                            $statusClass = 'bg-green-100 text-green-800';
                                            break;
                                        case 'canceled':
                                            $statusClass = 'bg-red-100 text-red-800';
                                            break;
                                        case 'pending_payment':
                                            $statusClass = 'bg-yellow-100 text-yellow-800';
                                            break;
                                        default:
                                            $statusClass = 'bg-gray-100 text-gray-800';
                                            break;
                                    }
                                @endphp
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $statusClass }}">
                                    {{ ucfirst($member->subscription->stripe_status) }}
                                </span>
                            @else
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">
                                    Inativo
                                </span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center">Nenhum membro encontrado.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

</div>
@endsection