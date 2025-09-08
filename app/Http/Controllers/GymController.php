<?php

namespace App\Http\Controllers;

use App\Models\Gym;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\RegisteredGym;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\File;
use App\Rules\AfterOrBeforeTime;
use App\Http\Requests\StoreGymRequest;
use App\Services\LocationService;

class GymController extends Controller
{
    public function index(Request $request)
    {
        $query = Gym::query()->where('status', 'approved');

        if ($request->filled('search')) {
            $searchTerm = $request->input('search');
            $query->where(function ($q) use ($searchTerm) {
                $q->where('gym_name', 'like', "%{$searchTerm}%")
                    ->orWhere('city', 'like', "%{$searchTerm}%");
            });
        }

        $gyms = $query->paginate(9);

        return view('gyms.index', compact('gyms'));
    }

    public function show(Gym $gym)
    {
        if ($gym->status !== 'approved') {
            abort(404);
        }

        return view('gyms.show', compact('gym'));
    }

    public function create(LocationService $locationService)
    {
        $states = $locationService->getStates();
        return view('gyms.register', compact('states'));
    }

    public function store(StoreGymRequest $request)
    {
        $validatedData = $request->validated();

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

        return redirect()->back()->with('success', 'Formulário enviado com sucesso! Entraremos em contato em breve.');
    }
}