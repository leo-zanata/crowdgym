<?php

namespace App\Http\Controllers;

use App\Mail\PasswordResetMail;
use App\Models\PasswordReset;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class PasswordResetController extends Controller
{
    public function showLinkRequestForm()
    {
        return view('auth.password.forgot');
    }

    public function sendResetLinkEmail(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
        ], [
            'email.exists' => 'O e-mail informado não está cadastrado em nossa base de dados.',
        ]);

        $user = User::where('email', $request->email)->first();

        PasswordReset::where('email', $request->email)->delete();

        $code = strval(random_int(1000, 9999));

        PasswordReset::create([
            'email' => $user->email,
            'code' => $code,
            'expires_at' => Carbon::now()->addMinutes(15),
        ]);

        Mail::to($user->email)->send(new PasswordResetMail($code));

        return redirect()->route('password.verify')->with('email', $user->email)->with('success', 'Um código de 4 dígitos foi enviado para o seu e-mail.');
    }

    public function showVerificationForm(Request $request)
    {
        if (!$request->session()->has('email')) {
            return redirect()->route('password.request');
        }
        return view('auth.password.verify-code');
    }

    public function verifyCode(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'code' => 'required|digits:4',
        ], [
            'code.required' => 'O código de 4 dígitos é obrigatório.',
            'code.digits' => 'O código deve conter 4 dígitos.',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput()->with('email', $request->email);
        }

        $passwordReset = PasswordReset::where('email', $request->email)
            ->where('code', $request->code)
            ->first();

        if (!$passwordReset || Carbon::now()->greaterThan($passwordReset->expires_at)) {
            return back()->withErrors(['code' => 'Código inválido ou expirado.'])->withInput()->with('email', $request->email);
        }

        $token = Str::random(64);
        $passwordReset->token = $token;
        $passwordReset->save();

        return redirect()->route('password.reset', ['token' => $token, 'email' => $request->email]);
    }

    public function showResetForm(Request $request)
    {
        $passwordReset = PasswordReset::where('email', $request->email)
            ->where('token', $request->token)
            ->first();

        if (!$passwordReset) {
            return redirect()->route('password.request')->with('error', 'Token de redefinição inválido.');
        }

        return view('auth.password.reset', ['email' => $request->email, 'token' => $request->token]);
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'token' => 'required|string',
            'password' => 'required|string|min:8|confirmed',
        ], [
            'password.required' => 'A senha é obrigatória.',
            'password.min' => 'A senha deve ter pelo menos 8 caracteres.',
            'password.confirmed' => 'As senhas não coincidem.',
        ]);

        $passwordReset = PasswordReset::where('email', $request->email)
            ->where('token', $request->token)
            ->first();
            
        if (!$passwordReset) {
            return back()->withErrors(['email' => 'Token de redefinição inválido ou expirado.']);
        }

        $user = User::where('email', $request->email)->first();
        if (!$user) {
            return back()->withErrors(['email' => 'Usuário não encontrado.']);
        }

        $user->password = Hash::make($request->password);
        $user->save();
        $passwordReset->delete();

        return redirect()->route('login')->with('success', 'Sua senha foi redefinida com sucesso. Faça login com a nova senha.');
    }
}