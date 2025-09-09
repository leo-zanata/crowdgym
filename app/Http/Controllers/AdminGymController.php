<?php

namespace App\Http\Controllers;

use App\Models\Gym;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\File;
use App\Rules\AfterOrBeforeTime;
use App\Http\Requests\StoreGymRequest;
use App\Services\LocationService;

class AdminGymController extends Controller
{
    public function index(Request $request)
    {
        $query = Gym::query();

        if ($request->filled('search')) {
            $searchTerm = $request->input('search');
            $query->where('gym_name', 'like', "%{$searchTerm}%")
                  ->orWhere('city', 'like', "%{$searchTerm}%");
        }

        $gyms = $query->latest()->paginate(15);

        return view('dashboard.admin.gyms.index', compact('gyms'));
    }

    public function edit(Gym $gym)
    {
        return view('dashboard.admin.gyms.edit', compact('gym'));
    }

    public function update(Request $request, Gym $gym)
    {
        $validatedData = $request->validate([
            'gym_name' => 'required|string|max:100',
            'city' => 'required|string|max:100',
            'state' => 'required|string|size:2',
            'status' => ['required', Rule::in(['pending', 'approved', 'rejected'])],
        ]);

        $gym->update($validatedData);

        return redirect()->route('admin.gyms.index')->with('success', 'Academia atualizada com sucesso!');
    }

    public function destroy(Gym $gym)
    {
        $gym->delete();
        return redirect()->route('admin.gyms.index')->with('success', 'Academia removida com sucesso!');
    }

    public function create(LocationService $locationService)
    {
        $states = $locationService->getStates();

        return view('dashboard.admin.gyms.create', compact('states'));
    }

    public function store(StoreGymRequest $request)
    {
        $validatedData = $request->validated();

        $validatedData['status'] = 'approved';

        $gym = Gym::create($validatedData);

        $defaultDays = [1, 2, 3, 4, 5];
        foreach ($defaultDays as $day) {
            \App\Models\OperatingHour::create([
                'gym_id' => $gym->id,
                'day_of_week' => $day,
                'opening_time' => '08:00',
                'closing_time' => '22:00',
            ]);
        }

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
        $gym->status = 'rejected';
        $gym->save();

        return redirect()->route('admin.gyms.pending')->with('success', 'Solicitação da academia foi rejeitada.');
    }
}