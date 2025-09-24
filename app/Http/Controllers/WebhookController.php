<?php

namespace App\Http\Controllers;

use App\Models\Subscription;
use App\Models\User;
use App\Models\Plan;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;
use Stripe\Exception\SignatureVerificationException;
use Stripe\Webhook;
use UnexpectedValueException;

class WebhookController extends Controller
{
    public function handleWebhook(Request $request)
    {
        $payload = $request->getContent();
        $sig_header = $request->server('HTTP_STRIPE_SIGNATURE');
        $endpoint_secret = env('STRIPE_WEBHOOK_SECRET');
        $event = null;

        try {
            $event = Webhook::constructEvent($payload, $sig_header, $endpoint_secret);
        } catch (\Exception $e) {
            return response('Webhook Error: ' . $e->getMessage(), 400);
        }

        if ($event->type == 'checkout.session.completed') {
            $session = $event->data->object;

            Log::info('Webhook checkout.session.completed recebido!', ['session_id' => $session->id]);

            $stripeCustomerId = $session->customer;
            $planId = $session->metadata->plan_id ?? null;

            Log::info('Dados recebidos:', ['stripe_customer_id' => $stripeCustomerId, 'plan_id' => $planId]);

            $user = User::where('stripe_id', $stripeCustomerId)->first();
            $plan = Plan::find($planId);

            if (!$user) {
                Log::error('Usuário não encontrado com stripe_id:', ['stripe_id' => $stripeCustomerId]);
            } else {
                Log::info('Usuário encontrado:', ['user_id' => $user->id, 'email' => $user->email]);
            }

            if (!$plan) {
                Log::error('Plano não encontrado com plan_id:', ['plan_id' => $planId]);
            } else {
                Log::info('Plano encontrado:', ['plan_name' => $plan->name]);
            }

            if ($user && $plan) {
                Subscription::create([
                    'user_id' => $user->id,
                    'plan_id' => $plan->id,
                    'stripe_session_id' => $session->id,
                    'stripe_status' => 'active',
                    'ends_at' => Carbon::now()->add($plan->duration, $plan->duration_unit),
                ]);
                Log::info('Assinatura criada com sucesso!');
            }
        }

        return response('Webhook Handled', 200);
    }
}