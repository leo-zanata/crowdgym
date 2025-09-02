<?php

namespace App\Http\Controllers;

use App\Models\Gym;
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
}