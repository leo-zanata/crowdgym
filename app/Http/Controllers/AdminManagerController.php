<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Gym;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class AdminManagerController extends Controller
{
    public function create()
    {
        $gyms = Gym::where('status', 'approved')->get();
        return view('dashboard.admin.managers.create', compact('gyms'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'cpf' => 'required|string|max:14|unique:users',
            'birth' => 'required|date',
            'gender' => ['required', Rule::in(['masculino', 'feminino', 'outro'])],
            'gym_id' => 'required|exists:gyms,id',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'cpf' => $request->cpf,
            'birth' => $request->birth,
            'gender' => $request->gender,
            'type' => 'manager',
            'gym_id' => $request->gym_id,
        ]);

        return redirect()->back()->with('success', 'Gerente cadastrado com sucesso!');
    }
}