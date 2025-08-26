<?php

use App\Http\Controllers\GymController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);

Route::get('/register', [AuthController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);

Route::get('/register-gym', [GymController::class, 'create'])->name('gym.register');
Route::post('/register-gym', [GymController::class, 'store'])->name('gym.store');

Route::middleware('auth')->group(function () {
    Route::get('/dashboard/admin', [DashboardController::class, 'showAdminDashboard'])->name('dashboard.admin');
    Route::get('/dashboard/manager', [DashboardController::class, 'showManagerDashboard'])->name('dashboard.manager');
    Route::get('/dashboard/member', [DashboardController::class, 'showMemberDashboard'])->name('dashboard.member');
    Route::get('/dashboard/employee', [DashboardController::class, 'showEmployeeDashboard'])->name('dashboard.employee');
});
