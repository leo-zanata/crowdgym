<?php

namespace App\Http\Controllers;

use App\Models\Subscription;
use App\Models\User;
use App\Models\Plan;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Laravel\Cashier\Http\Controllers\WebhookController as CashierController;
use Stripe\StripeClient;
use Symfony\Component\HttpFoundation\Response;

class WebhookController extends CashierController
{
    /**
     *
     * @param  array  $payload
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function handleCustomerSubscriptionCreated(array $payload)
    {
        $stripeSubscriptionId = $payload['data']['object']['id'];
        try {
            $stripe = new StripeClient(env('STRIPE_SECRET'));
            $stripeSubscription = $stripe->subscriptions->retrieve($stripeSubscriptionId);

            $stripeCustomerId = $stripeSubscription->customer;
            $stripePriceId = $stripeSubscription->items->data[0]->price->id;

            $user = User::where('stripe_id', $stripeCustomerId)->first();
            $plan = Plan::where('stripe_price_id', $stripePriceId)->first();

            if ($user && $plan) {
                if (!Subscription::where('stripe_id', $stripeSubscription->id)->exists()) {
                    Subscription::create([
                        'user_id' => $user->id,
                        'plan_id' => $plan->id,
                        'stripe_id' => $stripeSubscription->id,
                        'stripe_status' => $stripeSubscription->status,
                        'ends_at' => Carbon::createFromTimestamp($stripeSubscription->current_period_end),
                    ]);
                    Log::info('Assinatura RECORRENTE criada com sucesso.', ['stripe_subscription_id' => $stripeSubscription->id]);
                }
            }
        } catch (\Exception $e) {
            Log::error("Erro (subscription.created): " . $e->getMessage(), ['id' => $stripeSubscriptionId]);
            return $this->errorMethod();
        }
        return $this->successMethod();
    }

    /**
     *
     * @param  array  $payload
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function handleCustomerSubscriptionUpdated(array $payload)
    {
        $stripeSubscriptionId = $payload['data']['object']['id'];

        try {
            $stripe = new StripeClient(env('STRIPE_SECRET'));
            $stripeSubscription = $stripe->subscriptions->retrieve($stripeSubscriptionId);
            $subscription = Subscription::where('stripe_id', $stripeSubscription->id)->first();

            if ($subscription) {
                $subscription->update([
                    'stripe_status' => $stripeSubscription->status,
                    'ends_at' => Carbon::createFromTimestamp($stripeSubscription->current_period_end),
                ]);
                Log::info('Assinatura customizada atualizada com sucesso.', ['stripe_subscription_id' => $stripeSubscription->id]);
            }
        } catch (\Exception $e) {
            Log::error("Erro ao processar webhook (subscription.updated): " . $e->getMessage(), ['stripe_subscription_id' => $stripeSubscriptionId]);
            return $this->errorMethod();
        }

        return $this->successMethod();
    }

    /**
     *
     * @param  array  $payload
     * @return \Symfony\Component\HttpFoundation\Response // <-- CORREÇÃO: Usando o nome completo e correto
     */
    public function handleCheckoutSessionCompleted(array $payload)
    {
        $session = $payload['data']['object'];

        if ($session['mode'] === 'payment') {
            try {
                $stripeCustomerId = $session['customer'];
                $planId = $session['metadata']['plan_id'] ?? null;

                $user = User::where('stripe_id', $stripeCustomerId)->first();
                $plan = Plan::find($planId);

                if ($user && $plan) {
                    Subscription::create([
                        'user_id' => $user->id,
                        'plan_id' => $plan->id,
                        'stripe_id' => $session['payment_intent'],
                        'stripe_status' => 'active',
                        'ends_at' => Carbon::now()->add($plan->duration, $plan->duration_unit),
                    ]);
                    Log::info('Assinatura de plano AVULSO criada com sucesso.', ['payment_intent' => $session['payment_intent']]);
                } else {
                    Log::error('Usuário ou Plano não encontrado (checkout.session.completed).', ['customer' => $stripeCustomerId, 'plan_id' => $planId]);
                }
            } catch (\Exception $e) {
                Log::error("Erro ao processar webhook (checkout.session.completed): " . $e->getMessage(), ['session_id' => $session['id']]);
                return $this->errorMethod();
            }
        }

        return $this->successMethod();
    }
}