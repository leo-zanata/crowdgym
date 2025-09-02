<?php

namespace App\Http\Controllers;

use App\Models\Gym;
use App\Models\SupportTicket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Models\CheckInOut;
use App\Models\Subscription;
use App\Models\User;

class DashboardController extends Controller
{
    public function showMemberDashboard()
    {
        $memberId = Auth::id();

        $lastTraining = DB::table('check_in_out')
            ->where('user_id', $memberId)
            ->orderBy('check_in', 'desc')
            ->first();

        if ($lastTraining) {
            $lastTrainingDate = Carbon::parse($lastTraining->check_in)->locale('pt_BR')->isoFormat('ddd, DD [de] MMM');
            $checkIn = Carbon::parse($lastTraining->check_in)->format('H:i');
            $checkOut = $lastTraining->check_out ? Carbon::parse($lastTraining->check_out)->format('H:i') : '--:--';
        } else {
            $lastTrainingDate = "Nenhum treino registrado";
            $checkIn = "--:--";
            $checkOut = "--:--";
        }

        return view('dashboard.member', compact('lastTrainingDate', 'checkIn', 'checkOut'));
    }

    public function showManagerDashboard()
    {
        $manager = Auth::user();
        
        if (!$manager->gym_id) {
            return redirect()->route('home')->with('error', 'Sua conta não está associada a uma academia.');
        }

        $gymId = $manager->gym_id;

        $studentsInGym = CheckInOut::where('gym_id', $gymId)
            ->whereNull('check_out')
            ->count();
        $recentEnrollments = Subscription::whereHas('plan', function ($query) use ($gymId) {
            $query->where('gym_id', $gymId);
        })
        ->with('user')
        ->orderBy('created_at', 'desc')
        ->limit(5)
        ->get();
        $expiringSubscriptions = Subscription::whereHas('plan', function ($query) use ($gymId) {
            $query->where('gym_id', $gymId);
        })
        ->with('user')
        ->where('stripe_status', 'active')
        ->where('ends_at', '>=', Carbon::now())
        ->where('ends_at', '<=', Carbon::now()->addDays(30))
        ->orderBy('ends_at', 'asc')
        ->get();

        $dailyFlowData = CheckInOut::select(
            DB::raw('DATE(check_in) as date'),
            DB::raw('COUNT(DISTINCT user_id) as total_students')
        )
        ->where('gym_id', $gymId)
        ->where('check_in', '>=', Carbon::now()->subDays(7))
        ->groupBy('date')
        ->orderBy('date', 'asc')
        ->get();

        $enrollmentAndChurnData = Subscription::select(
            DB::raw('DATE(created_at) as date'),
            DB::raw('COUNT(*) as total_enrollments'),
            DB::raw('SUM(CASE WHEN stripe_status = "canceled" THEN 1 ELSE 0 END) as total_churn')
        )
        ->whereHas('plan', function ($query) use ($gymId) {
            $query->where('gym_id', $gymId);
        })
        ->where('created_at', '>=', Carbon::now()->subMonths(6))
        ->groupBy('date')
        ->orderBy('date', 'asc')
        ->get();

        $monthlyRevenue = Subscription::select(
            DB::raw('DATE_FORMAT(created_at, "%Y-%m") as month'),
            DB::raw('SUM(paid_amount) as total_revenue')
        )
        ->whereHas('plan', function ($query) use ($gymId) {
            $query->where('gym_id', $gymId);
        })
        ->where('created_at', '>=', Carbon::now()->subMonths(6))
        ->where('paid_amount', '>', 0)
        ->groupBy('month')
        ->orderBy('month', 'asc')
        ->get();

        $peakHoursData = CheckInOut::select(
            DB::raw('HOUR(check_in) as hour'),
            DB::raw('COUNT(*) as total_students')
        )
        ->where('gym_id', $gymId)
        ->where('check_in', '>=', Carbon::now()->subDays(7))
        ->groupBy('hour')
        ->orderBy('hour', 'asc')
        ->get();

        $pendingPayments = Subscription::whereHas('plan', function ($query) use ($gymId) {
            $query->where('gym_id', $gymId);
        })
        ->where('stripe_status', 'pending_payment')
        ->count();

        $topEmployees = User::select('users.name', DB::raw('COUNT(subscriptions.id) as total_sales'))
            ->join('subscriptions', 'subscriptions.employee_id', '=', 'users.id')
            ->where('users.type', 'employee')
            ->where('users.gym_id', $gymId)
            ->groupBy('users.name')
            ->orderBy('total_sales', 'desc')
            ->limit(3)
            ->get();
            
        $gym = Gym::find($gymId);
        $maxCapacity = $gym->max_capacity ?? 1;
        $occupancyRate = ($studentsInGym / $maxCapacity) * 100;

        return view('dashboard.manager', compact(
            'studentsInGym',
            'recentEnrollments',
            'expiringSubscriptions',
            'dailyFlowData',
            'enrollmentAndChurnData',
            'monthlyRevenue',
            'peakHoursData',
            'pendingPayments',
            'topEmployees',
            'occupancyRate'
        ));
    }

    public function showEmployeeDashboard()
    {
        $gymId = Auth::user()->gym_id;

        $members = DB::table('users')
            ->where('gym_id', $gymId)
            ->where('type', 'member')
            ->get();

        return view('dashboard.employee', compact('members'));
    }

    public function showAdminDashboard()
    {
        $pendingGyms = Gym::where('status', 'pending')->get();

        $openTickets = SupportTicket::where('status', 'open')->get();

        return view('dashboard.admin', compact('pendingGyms', 'openTickets'));
    }
}