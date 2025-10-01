<?php

namespace App\Http\Controllers;

use App\Models\Plan;
use App\Models\Gym;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Stripe\StripeClient;

class CheckoutController extends Controller
{
    public function create(Plan $plan)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        if (!$plan->stripe_price_id) {
            return redirect()->back()->with('error', 'Este plano não está configurado para venda no momento.');
        }

        $gymId = $plan->gym_id;
        $userHasPrincipalPlan = $user->hasActivePrincipalSubscriptionForGym($gymId);
        if ($plan->type === 'principal' && $userHasPrincipalPlan) {
            return redirect()->back()->with('error', 'Você já possui um plano principal ativo nesta academia.');
        }
        if ($plan->type === 'additional' && !$userHasPrincipalPlan) {
            return redirect()->back()->with('error', 'Você precisa ter um plano principal ativo para assinar um plano adicional.');
        }
        if ($plan->type === 'additional' && $user->hasActiveSubscriptionForSpecificPlan($plan)) {
            return redirect()->back()->with('error', 'Você já possui uma assinatura ativa para este plano adicional.');
        }

        try {
            $user->createOrGetStripeCustomer();
            $plan->load('gym');
            
            $checkoutOptions = [
                'success_url' => route('checkout.success') . '?session_id={CHECKOUT_SESSION_ID}',
                'cancel_url' => route('checkout.cancel', ['gym' => $plan->gym]),
                'metadata' => ['plan_id' => $plan->id]
            ];

            if ($plan->billing_type === 'recurring') {
                $checkoutSession = $user->newSubscription('default', $plan->stripe_price_id)
                                        ->checkout($checkoutOptions);
            } 
            else {
                $checkoutOptions['line_items'] = [['price' => $plan->stripe_price_id, 'quantity' => 1]];
                $checkoutOptions['mode'] = 'payment';
                $checkoutSession = $user->checkout(null, $checkoutOptions);
            }

            return redirect($checkoutSession->url);

        } catch (\Exception $e) {
            Log::error("Erro na criação da sessão de checkout Stripe: " . $e->getMessage());
            return back()->with('error', 'Não foi possível iniciar o checkout.');
        }
    }

    public function success(Request $request)
    {
        $sessionId = $request->get('session_id');
        $plan = null;
        if ($sessionId) {
            try {
                $stripe = new StripeClient(env('STRIPE_SECRET'));
                $session = $stripe->checkout->sessions->retrieve($sessionId);
                if (isset($session->metadata->plan_id)) {
                    $plan = Plan::find($session->metadata->plan_id);
                }
            } catch (\Exception $e) {
                Log::error('Erro ao buscar sessão de checkout na página de sucesso: ' . $e->getMessage());
            }
        }
        return view('checkout.success', ['plan' => $plan]);
    }

    public function cancel(Gym $gym)
    {
        return view('checkout.cancel', ['gym' => $gym]);
    }
}