<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HelpCenterController extends Controller
{
    public function index()
    {
        return view('helpcenter.dashboard');
    }
    public function showTicketForm()
    {
        return view('helpcenter.ticket');
    }
}