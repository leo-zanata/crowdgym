<?php

namespace App\Http\Controllers;

use App\Models\Gym;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\RegisteredGym;
use Illuminate\Validation\Rule;

class GymController extends Controller
{
    public function create()
    {
        $states = ['PE' => 'Pernambuco','PR' => 'Paraná', 'RJ' => 'Rio de Janeiro', 'SC' => 'Santa Catarina', 'SP' => 'São Paulo'];
        return view('gym.register', ['states' => $states]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'gymName' => 'required|string|max:100',
            'managerName' => 'required|string|max:100',
            'gymPhone' => 'required|string|max:20',
            'managerPhone' => 'required|string|max:20',
            'email' => 'required|email|unique:gyms,manager_email',
            'cpf' => 'required|string|size:11|unique:gyms,manager_cpf',
            'zipCode' => 'required|string|size:8',
            'state' => 'required|string|size:2',
            'city' => 'required|string|max:100',
            'neighborhood' => 'required|string|max:100',
            'street' => 'required|string|max:100',
            'number' => 'required|integer',
            'complement' => 'nullable|string|max:255',
            'opening' => 'required|date_format:H:i',
            'closing' => 'required|date_format:H:i|after:opening',
            'weekDays' => 'required|array|min:1',
            'weekDays.*' => 'in:Segunda,Terça,Quarta,Quinta,Sexta,Sábado,Domingo',
        ]);

        $selectedDays = implode(', ', $request->weekDays);

        $gymData = Gym::create([
            'gym_name' => $request->gymName,
            'manager_name' => $request->managerName,
            'gym_phone' => $request->gymPhone,
            'manager_phone' => $request->managerPhone,
            'manager_email' => $request->email,
            'manager_cpf' => $request->cpf,
            'zip_code' => $request->zipCode,
            'state' => $request->state,
            'city' => $request->city,
            'neighborhood' => $request->neighborhood,
            'street' => $request->street,
            'number' => $request->number,
            'complement' => $request->complement,
            'opening' => $request->opening,
            'closing' => $request->closing,
            'week_day' => $selectedDays,
            'status' => 'pending'
        ]);

        return redirect()->back()->with('success', 'Formulário enviado com sucesso! Entraremos em contato em breve.');
    }
}