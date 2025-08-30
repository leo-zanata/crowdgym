<?php

namespace App\Http\Controllers;

use App\Models\Gym;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class AdminGymController extends Controller
{
    public function create()
    {
        return view('dashboard.admin.gyms.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'gymName' => 'required|string|max:100',
            'gymPhone' => 'required|string|max:20',
            'zipCode' => 'required|string|size:8',
            'state' => 'required|string|size:2',
            'city' => 'required|string|max:100',
            'neighborhood' => 'required|string|max:100',
            'street' => 'required|string|max:100',
            'number' => 'required|integer',
            'complement' => 'nullable|string|max:255',
            'opening' => 'required|date_format:H:i',
            'closing' => 'required|date_format:H:i|after:opening',
            'weekDay' => 'required|string',
        ]);

        Gym::create([
            'gym_name' => $request->gymName,
            'gym_phone' => $request->gymPhone,
            'zip_code' => $request->zipCode,
            'state' => $request->state,
            'city' => $request->city,
            'neighborhood' => $request->neighborhood,
            'street' => $request->street,
            'number' => $request->number,
            'complement' => $request->complement,
            'opening' => $request->opening,
            'closing' => $request->closing,
            'week_day' => $request->weekDay,
            'status' => 'approved',
        ]);

        return redirect()->back()->with('success', 'Academia cadastrada com sucesso!');
    }

    public function pending()
    {
        $pendingGyms = Gym::where('status', 'pending')->get();
        return view('dashboard.admin.gyms.pending', compact('pendingGyms'));
    }
}