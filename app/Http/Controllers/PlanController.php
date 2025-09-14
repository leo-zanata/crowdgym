<?php

namespace App\Http\Controllers;

use App\Models\Gym;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PlanController extends Controller
{
    /**
     * @param  \App\Models\Gym  $gym 
     * @return \Illuminate\View\View
     */
    public function index(Gym $gym): View
    {
        if ($gym->status !== 'approved') {
            abort(404);
        }

        $plans = $gym->plans()->get();

        return view('plans.index', compact('gym', 'plans'));
    }
}
