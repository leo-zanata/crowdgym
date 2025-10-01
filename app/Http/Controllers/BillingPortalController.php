<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BillingPortalController extends Controller
{
    /**
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function create(Request $request)
    {
        return $request->user()->redirectToBillingPortal(route('dashboard.member'));
    }
}