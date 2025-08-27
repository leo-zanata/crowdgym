<?php

namespace App\Http\Controllers;

use App\Models\CheckInOut;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckInOutController extends Controller
{
    public function process(Request $request)
    {
        $request->validate([
            'member_id' => 'required|exists:users,id',
            'gym_id' => 'required|exists:gyms,id',    
        ]);

        $memberId = $request->member_id;
        $gymId = $request->gym_id;

        $user = User::find($memberId);
        if (!$user || !$user->hasActiveSubscriptionForGym($gymId)) {
            return response()->json(['status' => 'error', 'message' => 'Assinatura inválida para esta academia.'], 403);
        }

        $activeCheckIn = CheckInOut::where('member_id', $memberId)
            ->where('gym_id', $gymId)
            ->whereNull('check_out')
            ->first();

        if ($activeCheckIn) {
            $activeCheckIn->update(['check_out' => now()]);
            return response()->json(['status' => 'success', 'message' => 'Check-out realizado com sucesso!']);
        } else {
            CheckInOut::create([
                'member_id' => $memberId,
                'gym_id' => $gymId,
                'check_in' => now(),
            ]);
            return response()->json(['status' => 'success', 'message' => 'Check-in realizado com sucesso!']);
        }
    }
}