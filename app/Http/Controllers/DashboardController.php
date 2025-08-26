<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

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
        $gymId = Auth::user()->gym_id;

        $pendingRegistrations = DB::table('gyms')
            ->where('status', 'pending')
            ->get();

        return view('dashboard.manager', compact('pendingRegistrations'));
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
        $pendingGyms = DB::table('gyms')
            ->where('status', 'pending')
            ->get();

        return view('dashboard.admin', compact('pendingGyms'));
    }
}