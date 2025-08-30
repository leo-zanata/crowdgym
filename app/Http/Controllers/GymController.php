<?php

namespace App\Http\Controllers;

use App\Models\Gym;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\RegisteredGym;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\File;
use App\Rules\AfterOrBeforeTime;

class GymController extends Controller
{
    public function create()
    {
        $path = storage_path('app/data/states_and_cities.json');

        if (!File::exists($path)) {
            $states = [];
        } else {
            $json = File::get($path);
            $data = json_decode($json, true);
            $states = collect($data['estados'])->pluck('nome', 'sigla');
        }

        return view('gym.register', compact('states'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'gymName' => 'required|string|max:100',
            'managerName' => 'required|string|max:100',
            'gymPhone' => 'required|numeric|digits_between:10,11',
            'managerPhone' => 'required|numeric|digits_between:10,11',
            'manager_email' => 'required|email|unique:gyms,manager_email',
            'manager_cpf' => 'required|numeric|digits:11|unique:gyms,manager_cpf',
            'zipCode' => 'required|numeric|digits:8',
            'state' => 'required|string|size:2',
            'city' => 'required|string|max:100',
            'neighborhood' => 'required|string|max:100',
            'street' => 'required|string|max:100',
            'number' => 'required|numeric',
            'complement' => 'nullable|string|max:255',
            'opening' => 'required|date_format:H:i',
            'closing' => ['required', 'date_format:H:i', new AfterOrBeforeTime],
            'weekDays' => 'required|array|min:1',
            'weekDays.*' => 'in:Segunda,Terça,Quarta,Quinta,Sexta,Sábado,Domingo',
        ]);

        $selectedDays = implode(', ', $request->weekDays);

        $gymData = Gym::create([
            'gym_name' => $request->gymName,
            'manager_name' => $request->managerName,
            'gym_phone' => $request->gymPhone,
            'manager_phone' => $request->managerPhone,
            'manager_email' => $request->manager_email,
            'manager_cpf' => $request->manager_cpf,
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