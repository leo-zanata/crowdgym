<?php

namespace App\Http\Controllers;

use App\Models\Gym;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\File;
use App\Rules\AfterOrBeforeTime;

class AdminGymController extends Controller
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

        return view('dashboard.admin.gyms.create', compact('states'));
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

        $gym = Gym::create([
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
            'status' => 'approved',
        ]);

        return redirect()->route('admin.managers.create', [
            'gym_id' => $gym->id,
            'name' => $gym->manager_name,
            'email' => $gym->manager_email,
            'cpf' => $gym->manager_cpf,
        ])->with('success', 'Academia cadastrada. Agora, cadastre o gerente.');
    }

    public function pending()
    {
        $pendingGyms = Gym::where('status', 'pending')->get();
        return view('dashboard.admin.gyms.pending', compact('pendingGyms'));
    }

    public function approve(Gym $gym)
    {
        $gym->status = 'approved';
        $gym->save();

        return redirect()->route('admin.managers.create', [
            'gym_id' => $gym->id,
            'name' => $gym->manager_name,
            'email' => $gym->manager_email,
            'cpf' => $gym->manager_cpf,
        ])->with('success', 'Academia aprovada! Agora, cadastre o gerente.');
    }

    public function reject(Gym $gym)
    {
        $gym->delete();
        return redirect()->route('admin.gyms.pending')->with('success', 'Solicitação rejeitada e excluída do sistema.');
    }
}