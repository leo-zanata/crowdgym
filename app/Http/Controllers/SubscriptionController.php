<?php

namespace App\Http\Controllers;

use App\Models\Subscription;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SubscriptionController extends Controller
{
    /**
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Subscription  $subscription
     */
    public function cancel(Request $request, Subscription $subscription)
    {
        if ($subscription->user_id !== Auth::id()) {
            return redirect()->back()->with('error', 'Você não tem permissão para cancelar esta assinatura.');
        }

        if ($subscription->status === 'inactive') {
            return redirect()->back()->with('error', 'A assinatura já está inativa.');
        }

        $subscription->status = 'inactive';
        $subscription->save();

        return redirect()->back()->with('success', 'Assinatura cancelada com sucesso!');
    }
}