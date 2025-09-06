<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\AdminSupportTicket;
use App\Models\AdminTicketReply;

class AdminController extends Controller
{
    public function indexTickets()
    {
        $tickets = AdminSupportTicket::with('user')
                                ->orderBy('status', 'asc')
                                ->orderBy('created_at', 'desc')
                                ->get();
        
        return view('dashboard.admin.tickets.index', compact('tickets'));
    }

    public function showTicket(AdminSupportTicket $ticket)
    {
        $ticket->load('user', 'replies.user'); 
        return view('dashboard.admin.tickets.show', compact('ticket'));
    }

    public function storeTicketReply(Request $request, AdminSupportTicket $ticket)
    {
        $admin = Auth::user();
        
        $request->validate([
            'message' => 'required|string|min:1',
        ]);
        
        AdminTicketReply::create([
            'ticket_id' => $ticket->id,
            'user_id' => $admin->id,
            'message' => $request->message,
        ]);
        
        if ($ticket->status === 'open') {
            $ticket->status = 'in_progress';
            $ticket->save();
        }
        
        return redirect()->back()->with('success', 'Resposta enviada com sucesso!');
    }
    
    public function resolveTicket(AdminSupportTicket $ticket)
    {
        $ticket->status = 'resolved';
        $ticket->save();

        return redirect()->back()->with('success', 'Ticket marcado como resolvido com sucesso!');
    }
}
