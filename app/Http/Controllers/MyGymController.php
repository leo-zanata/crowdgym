<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Subscription;
use App\Models\CheckInOut;
use Carbon\Carbon;

class MyGymController extends Controller
{
    public function index()
    {
        $memberId = Auth::id();

        $subscriptions = Subscription::with('plan.gym')
            ->where('user_id', $memberId)
            ->where('stripe_status', 'active')
            ->where('ends_at', '>=', Carbon::now())
            ->get();

        $subscriptions->each(function ($subscription) {
            $totalTreinando = CheckInOut::where('gym_id', $subscription->plan->gym->id)
                ->whereNull('check_out')
                ->count();

            $subscription->total_treinando = $totalTreinando;
        });

        return view('dashboard.member.my-gyms', compact('subscriptions'));
    }
}