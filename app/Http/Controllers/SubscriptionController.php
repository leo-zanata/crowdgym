<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SubscriptionController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $subscriptions = $user->subscriptions;

        $invoices = $user->invoices();

        $pendingPayments = [];

        return view('dashboard.member.payment-data', compact('subscriptions', 'invoices', 'pendingPayments'));
    }
}