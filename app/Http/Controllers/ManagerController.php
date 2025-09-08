<?php

namespace App\Http\Controllers;

use App\Models\Gym;
use App\Models\OperatingHour;
use App\Models\Subscription;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Mail\MemberCommunicationMail;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use App\Models\Plan;
use App\Models\SupportTicket;
use App\Models\TicketReply;
use App\Services\LocationService;

class ManagerController extends Controller
{
    public function indexFinancialReport()
    {
        $manager = Auth::user();
        $gymId = $manager->gym_id;

        $totalRevenue = Subscription::whereHas('plan', function ($query) use ($gymId) {
            $query->where('gym_id', $gymId);
        })
            ->where('stripe_status', 'active')
            ->sum('paid_amount');

        $monthlyRevenue = Subscription::select(
            DB::raw('DATE_FORMAT(created_at, "%Y-%m") as month'),
            DB::raw('SUM(paid_amount) as total')
        )
            ->whereHas('plan', function ($query) use ($gymId) {
                $query->where('gym_id', $gymId);
            })
            ->where('created_at', '>=', Carbon::now()->subMonths(6))
            ->where('paid_amount', '>', 0)
            ->groupBy('month')
            ->orderBy('month', 'asc')
            ->get();

        $activeSubscriptions = Subscription::whereHas('plan', function ($query) use ($gymId) {
            $query->where('gym_id', $gymId);
        })
            ->where('stripe_status', 'active')
            ->count();

        $canceledSubscriptions = Subscription::whereHas('plan', function ($query) use ($gymId) {
            $query->where('gym_id', $gymId);
        })
            ->where('stripe_status', 'canceled')
            ->count();

        $pendingPayments = Subscription::whereHas('plan', function ($query) use ($gymId) {
            $query->where('gym_id', $gymId);
        })
            ->where('stripe_status', 'pending_payment')
            ->count();

        return view('dashboard.manager.reports.financial', compact(
            'totalRevenue',
            'monthlyRevenue',
            'activeSubscriptions',
            'canceledSubscriptions',
            'pendingPayments'
        ));
    }
    public function exportFinancialReportCsv()
    {
        $manager = Auth::user();
        $gymId = $manager->gym_id;

        $monthlyRevenue = Subscription::select(
            DB::raw('DATE_FORMAT(created_at, "%Y-%m") as month'),
            DB::raw('SUM(paid_amount) as total')
        )
            ->whereHas('plan', function ($query) use ($gymId) {
                $query->where('gym_id', $gymId);
            })
            ->where('created_at', '>=', Carbon::now()->subMonths(6))
            ->where('paid_amount', '>', 0)
            ->groupBy('month')
            ->orderBy('month', 'asc')
            ->get();

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="relatorio_financeiro.csv"',
        ];

        $callback = function () use ($monthlyRevenue) {
            $file = fopen('php://output', 'w');
            fputcsv($file, ['Mês', 'Receita Total']);

            foreach ($monthlyRevenue as $row) {
                fputcsv($file, [$row->month, $row->total]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function create()
    {
        return view('dashboard.manager.employees.create');
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
        ]);

        $gymId = Auth::user()->gym_id;

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'cpf' => $request->cpf,
            'birth' => $request->birth,
            'gender' => $request->gender,
            'type' => 'employee',
            'gym_id' => $gymId,
        ]);

        return redirect()->back()->with('success', 'Funcionário cadastrado com sucesso!');
    }

    public function indexEmployees()
    {
        $manager = Auth::user();
        if (!$manager) {
            return redirect()->route('login')->with('error', 'Você precisa estar logado para acessar esta página.');
        }

        $employees = User::where('gym_id', $manager->gym_id)
            ->where('type', 'employee')
            ->get();

        return view('dashboard.manager.employees.index', compact('employees'));
    }

    public function editEmployees(User $employee)
    {
        $manager = Auth::user();
        if (!$manager) {
            return redirect()->route('login')->with('error', 'Você precisa estar logado para acessar esta página.');
        }

        if ($employee->gym_id !== $manager->gym_id) {
            return redirect()->route('manager.employees.index')->with('error', 'Você não tem permissão para editar este funcionário.');
        }

        return view('dashboard.manager.employees.edit', compact('employee'));
    }

    public function updateEmployees(Request $request, User $employee)
    {
        $manager = Auth::user();
        if (!$manager) {
            return redirect()->route('login')->with('error', 'Você precisa estar logado para acessar esta página.');
        }

        if ($employee->gym_id !== $manager->gym_id) {
            return redirect()->route('manager.employees.index')->with('error', 'Você não tem permissão para editar este funcionário.');
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($employee->id)],
            'password' => 'nullable|string|min:8|confirmed',
            'cpf' => ['required', 'string', 'max:14', Rule::unique('users')->ignore($employee->id)],
            'birth' => 'required|date',
            'gender' => ['required', Rule::in(['masculino', 'feminino', 'outro'])],
        ]);

        $employee->update([
            'name' => $request->name,
            'email' => $request->email,
            'cpf' => $request->cpf,
            'birth' => $request->birth,
            'gender' => $request->gender,
        ]);

        if ($request->filled('password')) {
            $employee->password = Hash::make($request->password);
            $employee->save();
        }

        return redirect()->route('manager.employees.index')->with('success', 'Funcionário atualizado com sucesso!');
    }

    public function destroyEmployees(User $employee)
    {
        $manager = Auth::user();
        if (!$manager) {
            return redirect()->route('login')->with('error', 'Você precisa estar logado para acessar esta página.');
        }

        if ($employee->gym_id !== $manager->gym_id) {
            return redirect()->route('manager.employees.index')->with('error', 'Você não tem permissão para remover este funcionário.');
        }

        $employee->delete();

        return redirect()->route('manager.employees.index')->with('success', 'Funcionário removido com sucesso!');
    }

    public function showCommunicationForm()
    {
        return view('dashboard.manager.members.communicate');
    }

    public function sendCommunication(Request $request)
    {
        $request->validate([
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
        ]);

        $manager = Auth::user();

        if (!$manager->gym) {
            return redirect()->back()->with('error', 'Sua conta não está associada a uma academia. Não é possível enviar mensagens.');
        }

        $gymId = $manager->gym_id;

        $members = User::where('gym_id', $gymId)
            ->where('type', 'member')
            ->get();

        if ($members->isEmpty()) {
            return redirect()->back()->with('error', 'Nenhum membro encontrado para esta academia.');
        }

        $mailData = [
            'subject' => $request->subject,
            'message' => $request->message,
            'manager_name' => $manager->name,
            'gym_name' => $manager->gym->gym_name,
        ];

        foreach ($members as $member) {
            Mail::to($member->email)->send(new MemberCommunicationMail($mailData));
        }

        return redirect()->back()->with('success', 'Mensagem enviada para todos os membros da academia!');
    }

    public function indexPlans()
    {
        $manager = Auth::user();
        if (!$manager) {
            return redirect()->route('login')->with('error', 'Você precisa estar logado para acessar esta página.');
        }

        $plans = Plan::where('gym_id', $manager->gym_id)->get();
        return view('dashboard.manager.plans.index', compact('plans'));
    }

    public function createPlans()
    {
        $manager = Auth::user();
        if (!$manager) {
            return redirect()->route('login')->with('error', 'Você precisa estar logado para acessar esta página.');
        }
        return view('dashboard.manager.plans.create');
    }

    public function storePlans(Request $request)
    {
        $manager = Auth::user();
        if (!$manager) {
            return redirect()->route('login')->with('error', 'Você precisa estar logado para acessar esta página.');
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'description' => 'nullable|string',
            'type' => 'required|in:principal,additional',
            'duration' => 'required_if:type,principal|integer|min:1',
            'duration_unit' => ['required_if:type,principal', Rule::in(['day', 'month'])],
            'loyalty_months' => 'nullable|integer|min:0',
            'installment_options' => 'nullable|array',
            'installment_options.*' => 'integer|min:2|max:12',
        ]);

        Plan::create([
            'name' => $request->name,
            'price' => $request->price,
            'description' => $request->description,
            'duration' => $request->duration,
            'duration_unit' => $request->duration_unit,
            'loyalty_months' => $request->loyalty_months,
            'installment_options' => $request->installment_options,
            'type' => $request->type,
            'gym_id' => $manager->gym_id,
        ]);

        return redirect()->route('manager.plans.index')->with('success', 'Plano criado com sucesso!');
    }

    public function editPlans(Plan $plan)
    {
        $manager = Auth::user();
        if (!$manager) {
            return redirect()->route('login')->with('error', 'Você precisa estar logado para acessar esta página.');
        }
        if ($plan->gym_id !== $manager->gym_id) {
            return redirect()->route('manager.plans.index')->with('error', 'Você não tem permissão para editar este plano.');
        }
        return view('dashboard.manager.plans.edit', compact('plan'));
    }

    public function updatePlans(Request $request, Plan $plan)
    {
        $manager = Auth::user();
        if (!$manager) {
            return redirect()->route('login')->with('error', 'Você precisa estar logado para acessar esta página.');
        }
        if ($plan->gym_id !== $manager->gym_id) {
            return redirect()->route('manager.plans.index')->with('error', 'Você não tem permissão para editar este plano.');
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'description' => 'nullable|string',
            'type' => 'required|in:principal,additional',
            'duration' => 'required_if:type,principal|integer|min:1',
            'duration_unit' => ['required_if:type,principal', Rule::in(['day', 'month'])],
            'loyalty_months' => 'nullable|integer|min:0',
            'installment_options' => 'nullable|array',
            'installment_options.*' => 'integer|min:1|max:12',
        ]);

        $plan->update([
            'name' => $request->name,
            'price' => $request->price,
            'description' => $request->description,
            'duration' => $request->duration,
            'duration_unit' => $request->duration_unit,
            'loyalty_months' => $request->loyalty_months,
            'installment_options' => $request->installment_options,
            'type' => $request->type,
        ]);

        return redirect()->route('manager.plans.index')->with('success', 'Plano atualizado com sucesso!');
    }

    public function destroyPlans(Plan $plan)
    {
        $manager = Auth::user();
        if (!$manager) {
            return redirect()->route('login')->with('error', 'Você precisa estar logado para acessar esta página.');
        }
        if ($plan->gym_id !== $manager->gym_id) {
            return redirect()->route('manager.plans.index')->with('error', 'Você não tem permissão para remover este plano.');
        }

        $plan->delete();

        return redirect()->route('manager.plans.index')->with('success', 'Plano removido com sucesso!');
    }

    public function indexMembers()
    {
        $manager = Auth::user();
        if (!$manager) {
            return redirect()->route('login')->with('error', 'Você precisa estar logado para acessar esta página.');
        }

        $members = User::where('gym_id', $manager->gym_id)
            ->where('type', 'member')
            ->with('subscription.plan')
            ->get();

        return view('dashboard.manager.members.index', compact('members'));
    }

    public function indexTickets()
    {
        $manager = Auth::user();
        if (!$manager) {
            return redirect()->route('login')->with('error', 'Você precisa estar logado para acessar esta página.');
        }

        $tickets = SupportTicket::where('gym_id', $manager->gym_id)
            ->with('user')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('dashboard.manager.tickets.index', compact('tickets'));
    }

    public function showTicket(SupportTicket $ticket)
    {
        $manager = Auth::user();
        if (!$manager) {
            return redirect()->route('login')->with('error', 'Você precisa estar logado para acessar esta página.');
        }

        if ($ticket->gym_id !== $manager->gym_id) {
            return redirect()->route('manager.tickets.index')->with('error', 'Você não tem permissão para visualizar este ticket.');
        }

        $ticket->load('user', 'replies.user');
        return view('dashboard.manager.tickets.show', compact('ticket'));
    }

    public function storeTicketReply(Request $request, SupportTicket $ticket)
    {
        $manager = Auth::user();
        if (!$manager) {
            return redirect()->route('login')->with('error', 'Você precisa estar logado para acessar esta página.');
        }

        if ($ticket->gym_id !== $manager->gym_id) {
            return redirect()->route('manager.tickets.index')->with('error', 'Você não tem permissão para responder a este ticket.');
        }

        $request->validate([
            'message' => 'required|string|min:1',
        ]);

        TicketReply::create([
            'ticket_id' => $ticket->id,
            'user_id' => $manager->id,
            'message' => $request->message,
        ]);

        if ($ticket->status === 'open') {
            $ticket->status = 'in_progress';
            $ticket->save();
        }

        return redirect()->back()->with('success', 'Resposta enviada com sucesso!');
    }
    public function resolveTicket(SupportTicket $ticket)
    {
        $manager = Auth::user();
        if (!$manager) {
            return redirect()->route('login')->with('error', 'Você precisa estar logado para acessar esta página.');
        }

        if ($ticket->gym_id !== $manager->gym_id) {
            return redirect()->route('manager.tickets.index')->with('error', 'Você não tem permissão para gerenciar este ticket.');
        }

        $ticket->status = 'resolved';
        $ticket->save();

        return redirect()->back()->with('success', 'Ticket marcado como resolvido!');
    }

    public function editGym(LocationService $locationService)
    {
        $manager = Auth::user();
        /** @var \App\Models\User $manager */

        $gym = Gym::with('operatingHours')->findOrFail($manager->gym_id);

        $states = $locationService->getStates();

        return view('dashboard.manager.gym.edit', compact('gym', 'states'));
    }

    public function updateGym(Request $request)
    {
        $manager = Auth::user();
        /** @var \App\Models\User $manager */

        $gym = Gym::findOrFail($manager->gym_id);

        $validatedData = $request->validate([
            'gym_name' => 'required|string|max:100',
            'gym_phone' => 'required|numeric|digits_between:10,11',
            'zip_code' => 'required|numeric|digits:8',
            'state' => 'required|string|size:2',
            'city' => 'required|string|max:100',
            'street' => 'required|string|max:100',
            'number' => 'required|numeric',
            'complement' => 'nullable|string|max:255',
            'hours' => 'nullable|array',
            'hours.*.days' => 'required_with:hours|array|min:1',
            'hours.*.days.*' => 'in:0,1,2,3,4,5,6',
            'hours.*.opening_time' => 'required_with:hours|date_format:H:i',
            'hours.*.closing_time' => 'required_with:hours|date_format:H:i|after:hours.*.opening_time',
        ]);

        $gym->update([
            'gym_name' => $validatedData['gym_name'],
            'gym_phone' => $validatedData['gym_phone'],
            'zip_code' => $validatedData['zip_code'],
            'state' => $validatedData['state'],
            'city' => $validatedData['city'],
            'street' => $validatedData['street'],
            'number' => $validatedData['number'],
            'complement' => $validatedData['complement'],
        ]);

        $gym->operatingHours()->delete();

        if ($request->filled('hours')) {
            foreach ($request->hours as $hourBlock) {
                if (empty($hourBlock['days'])) {
                    continue;
                }
                foreach ($hourBlock['days'] as $day) {
                    OperatingHour::create([
                        'gym_id' => $gym->id,
                        'day_of_week' => $day,
                        'opening_time' => $hourBlock['opening_time'],
                        'closing_time' => $hourBlock['closing_time'],
                    ]);
                }
            }
        }

        return redirect()->route('manager.gym.edit')->with('success', 'Informações da academia atualizadas com sucesso!');
    }
}