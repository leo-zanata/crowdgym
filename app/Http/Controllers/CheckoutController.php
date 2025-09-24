<?php

namespace App\Http\Controllers;

use App\Models\Plan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class CheckoutController extends Controller
{
    public function create(Plan $plan)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        $gymId = $plan->gym_id;

        $userHasPrincipalPlan = $user->hasActivePrincipalSubscriptionForGym($gymId);

        if ($plan->type === 'principal' && $userHasPrincipalPlan) {
            return redirect()->back()->with('error', 'Você já possui um plano principal ativo nesta academia.');
        }

        if ($plan->type === 'additional' && !$userHasPrincipalPlan) {
            return redirect()->back()->with('error', 'Você precisa ter um plano principal ativo para assinar um plano adicional.');
        }

        if ($plan->type === 'additional') {
            if ($user->hasActiveSubscriptionForSpecificPlan($plan)) {
                return redirect()->back()->with('error', 'Você já possui uma assinatura ativa para este plano adicional.');
            }
        }

        $priceInCents = (int) round($plan->price * 100);

        try {
            $hasStripeId = $user->stripe_id;
            $stripeCustomer = $user->createOrGetStripeCustomer();

            if (!$hasStripeId) {
                $user->save();
            }

            $stripeSession = $user->stripe()->checkout->sessions->create([
                'payment_method_types' => ['card'],
                'line_items' => [
                    [
                        'price_data' => [
                            'currency' => 'BRL',
                            'product_data' => ['name' => $plan->name],
                            'unit_amount' => $priceInCents,
                        ],
                        'quantity' => 1,
                    ],
                ],
                'metadata' => [
                    'plan_id' => $plan->id,
                ],
                'customer' => $stripeCustomer->id,
                'mode' => 'payment',
                'success_url' => route('checkout.success'),
                'cancel_url' => route('checkout.cancel'),
            ]);

            return redirect($stripeSession->url);

        } catch (\Exception $e) {
            Log::error("Erro na criação da sessão Stripe: " . $e->getMessage());
            return back()->withErrors(['stripe_error' => 'Não foi possível iniciar o checkout.']);
        }
    }

    public function success(Request $request)
    {
        return view('checkout.success');
    }

    public function cancel()
    {
        return view('checkout.cancel');
    }
}