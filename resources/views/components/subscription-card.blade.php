@props(['subscription'])

<div class="bg-white rounded-2xl shadow-lg p-8 border-l-8 border-green-500">
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6">
        <div>
            <h4 class="text-3xl font-extrabold text-gray-800">{{ $subscription->plan->name }}</h4>
            <p class="text-lg text-gray-500 mt-1">
                na <span class="font-semibold">{{ $subscription->plan->gym->gym_name }}</span>
            </p>
        </div>
        <div class="mt-4 md:mt-0 px-4 py-2 bg-green-100 text-green-800 rounded-full text-lg font-bold">
            Ativo
        </div>
    </div>

    <div class="border-t border-gray-200 pt-6">
        <dl class="grid grid-cols-1 md:grid-cols-2 gap-x-6 gap-y-4">
            <div class="flex flex-col">
                <dt class="text-sm font-medium text-gray-500">Data da Compra</dt>
                <dd class="mt-1 text-lg font-semibold text-gray-900">
                    {{ $subscription->created_at->format('d/m/Y') }}
                </dd>
            </div>

            <div class="flex flex-col">
                <dt class="text-sm font-medium text-gray-500">Acesso válido até</dt>
                <dd class="mt-1 text-lg font-semibold text-gray-900">
                    {{ $subscription->ends_at->format('d/m/Y') }}
                </dd>
            </div>

            <div class="flex flex-col">
                <dt class="text-sm font-medium text-gray-500">Alunos treinando agora</dt>
                <dd class="mt-1 text-lg font-semibold text-gray-900">
                    {{ $subscription->total_treinando }}
                </dd>
            </div>
        </dl>
    </div>

    @if ($subscription->plan->billing_type === 'recurring')
        <div class="mt-8 border-t border-gray-200 pt-6">
            <a href="{{ route('billing.portal') }}"
                class="inline-block bg-indigo-600 text-white font-bold py-3 px-5 rounded-lg hover:bg-indigo-700 transition-colors shadow-lg">
                Gerenciar Assinatura &rarr;
            </a>
        </div>
    @endif
</div>