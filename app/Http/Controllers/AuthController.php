<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use App\Mail\EmailVerificationMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Carbon;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $credentials = [
            'email' => $request->email,
            'password' => $request->password,
        ];

        if (Auth::attempt($credentials)) {
            $user = Auth::user();

            if (is_null($user->email_verified_at)) {
                return redirect()->route('verification.notice');
            }

            $request->session()->regenerate();

            if ($user->type === 'admin') {
                return redirect()->intended(route('dashboard.admin'));
            } elseif ($user->type === 'manager') {
                return redirect()->intended(route('dashboard.manager'));
            } elseif ($user->type === 'employee') {
                return redirect()->intended(route('dashboard.employee'));
            }

            return redirect()->intended(route('dashboard.member'));
        }

        return back()->withErrors([
            'email' => 'As credenciais fornecidas não correspondem aos nossos registros.',
        ])->onlyInput('email');
    }

    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:100',
            'email' => 'required|email|unique:users',
            'cpf' => 'required|string|size:11|unique:users',
            'birth' => 'required|date',
            'gender' => ['required', Rule::in(['feminino', 'masculino', 'outro'])],
            'password' => 'required|string|min:8|max:15|confirmed',
        ], [
            'password.confirmed' => 'As senhas não coincidem.',
            'cpf.size' => 'O CPF deve ter exatamente 11 caracteres.',
        ]);

        $code = strval(random_int(1000, 9999));

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'cpf' => $request->cpf,
            'birth' => $request->birth,
            'gender' => $request->gender,
            'password' => Hash::make($request->password),
            'email_verification_code' => $code,
        ]);

        Mail::to($user->email)->send(new EmailVerificationMail($code));

        Auth::login($user);

        return redirect()->route('verification.notice');
    }

    public function showEmailVerificationForm(Request $request)
    {
        if (Auth::check() && !is_null(Auth::user()->email_verified_at)) {
            return redirect()->route('dashboard.member');
        }

        return view('auth.verify-email');
    }

    public function verifyEmail(Request $request)
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Por favor, faça login para verificar seu e-mail.');
        }

        $request->validate([
            'code' => 'required|digits:4',
        ], [
            'code.required' => 'O código de 4 dígitos é obrigatório.',
            'code.digits' => 'O código deve conter 4 dígitos.',
        ]);

        $user = Auth::user();

        if ($request->code == $user->email_verification_code) {
            $user->email_verified_at = Carbon::now();
            $user->save();

            return redirect()->intended(route('dashboard.member'))->with('success', 'E-mail verificado com sucesso!');
        }

        return back()->withErrors(['code' => 'Código de verificação inválido.']);
    }
    
    public function resendVerificationCode(Request $request)
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Por favor, faça login para reenviar o código.');
        }

        $user = Auth::user();
        $code = strval(random_int(1000, 9999));

        $user->email_verification_code = $code;
        $user->save();

        Mail::to($user->email)->send(new EmailVerificationMail($code));

        return back()->with('success', 'Um novo código de verificação foi enviado para o seu e-mail.');
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}