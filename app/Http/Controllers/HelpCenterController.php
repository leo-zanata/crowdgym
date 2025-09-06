<?php

namespace App\Http\Controllers;

use App\Models\AdminSupportTicket;
use App\Models\SupportTicket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class HelpCenterController extends Controller
{
    public function index()
    {
        return view('helpcenter.index');
    }

    public function showTicketForm()
    {
        $user = Auth::user();
        $gyms = $user->gyms;

        return view('helpcenter.ticket', [
            'gyms' => $gyms
        ]);
    }

    public function storeTicket(Request $request)
    {
        $user = Auth::user();

        if ($request->type === 'admin') {
            
            $request->validate([
                'subject' => 'required|string|max:255',
                'message' => 'required|string',
            ]);

            AdminSupportTicket::create([
                'user_id' => $user->id,
                'subject' => $request->subject,
                'message' => $request->message,
            ]);

            return redirect()->route('helpcenter.index')->with('success', 'Seu ticket de suporte para o Crowd Gym foi enviado com sucesso!');

        } else { 
            
            $request->validate([
                'subject' => 'required|string|max:255',
                'message' => 'required|string',
                'gym_id'  => ['required', 'exists:gyms,id']
            ]);

            $userIsMember = $user->gyms()->where('gym_id', $request->gym_id)->exists();

            if (!$userIsMember) {
                return redirect()->back()->with('error', 'Você não tem permissão para abrir um chamado para esta academia.');
            }

            SupportTicket::create([
                'user_id' => $user->id,
                'gym_id'  => $request->gym_id,
                'subject' => $request->subject,
                'message' => $request->message,
            ]);

            return redirect()->route('helpcenter.index')->with('success', 'Seu ticket de suporte para a academia foi enviado com sucesso!');
        }
    }
}