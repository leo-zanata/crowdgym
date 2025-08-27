<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Gym;

class GymSearchController extends Controller
{
    public function index(Request $request)
    {
        $filter = $request->input('filtro');

        $query = Gym::query();

        if ($filter) {
            $query->where('gym_name', 'like', "%{$filter}%")
                  ->orWhere('city', 'like', "%{$filter}%");
        }

        $gyms = $query->get();

        return view('dashboard.member.gym-search', compact('gyms', 'filter'));
    }
}