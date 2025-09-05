<?php

use App\Http\Controllers\HelpCenterController;
use App\Http\Controllers\AboutController;
use App\Http\Controllers\SubscriptionController;
use App\Http\Controllers\MyGymController;
use App\Http\Controllers\GymSearchController;
use App\Http\Controllers\GymController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AdminGymController;
use App\Http\Controllers\AdminManagerController;
use App\Http\Controllers\ManagerController;
use App\Http\Controllers\PasswordResetController;

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

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware('auth')->group(function () {
    Route::get('/dashboard/admin', [DashboardController::class, 'showAdminDashboard'])->name('dashboard.admin');
    Route::get('/dashboard/manager', [DashboardController::class, 'showManagerDashboard'])->name('dashboard.manager');
    Route::get('/dashboard/member', [DashboardController::class, 'showMemberDashboard'])->name('dashboard.member');
    Route::get('/dashboard/employee', [DashboardController::class, 'showEmployeeDashboard'])->name('dashboard.employee');
});

Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin/gyms/create', [AdminGymController::class, 'create'])->name('admin.gyms.create');
    Route::post('/admin/gyms', [AdminGymController::class, 'store'])->name('admin.gyms.store');
    Route::get('/admin/gyms/pending', [AdminGymController::class, 'pending'])->name('admin.gyms.pending');
    Route::post('/admin/gyms/{gym}/approve', [AdminGymController::class, 'approve'])->name('admin.gyms.approve');
    Route::post('/admin/gyms/{gym}/reject', [AdminGymController::class, 'reject'])->name('admin.gyms.reject');
    Route::get('/admin/managers/create', [AdminManagerController::class, 'create'])->name('admin.managers.create');
    Route::post('/admin/managers', [AdminManagerController::class, 'store'])->name('admin.managers.store');
});

Route::middleware(['auth', 'role:manager'])->group(function () {
    Route::get('/dashboard/manager', [DashboardController::class, 'showManagerDashboard'])->name('dashboard.manager');
    Route::get('/manager/employees/create', [ManagerController::class, 'create'])->name('manager.employees.create');
    Route::post('/manager/employees', [ManagerController::class, 'store'])->name('manager.employees.store');
    Route::get('/manager/reports/financial', [ManagerController::class, 'indexFinancialReport'])->name('manager.reports.financial');
    Route::get('/manager/members/communicate', [ManagerController::class, 'showCommunicationForm'])->name('manager.members.communicate');
    Route::post('/manager/members/send', [ManagerController::class, 'sendCommunication'])->name('manager.members.send');

    Route::get('/manager/plans', [ManagerController::class, 'indexPlans'])->name('manager.plans.index');
    Route::get('/manager/plans/create', [ManagerController::class, 'createPlans'])->name('manager.plans.create');
    Route::post('/manager/plans', [ManagerController::class, 'storePlans'])->name('manager.plans.store');
    Route::get('/manager/plans/{plan}/edit', [ManagerController::class, 'editPlans'])->name('manager.plans.edit');
    Route::put('/manager/plans/{plan}', [ManagerController::class, 'updatePlans'])->name('manager.plans.update');
    Route::delete('/manager/plans/{plan}', [ManagerController::class, 'destroyPlans'])->name('manager.plans.destroy');

    Route::get('/manager/members', [ManagerController::class, 'indexMembers'])->name('manager.members.index');

    Route::get('/manager/tickets', [ManagerController::class, 'indexTickets'])->name('manager.tickets.index');
    Route::get('/manager/tickets/{ticket}', [ManagerController::class, 'showTicket'])->name('manager.tickets.show');
    Route::post('/manager/tickets/{ticket}/reply', [ManagerController::class, 'storeTicketReply'])->name('manager.tickets.reply.store');
    Route::put('/manager/tickets/{ticket}/resolve', [ManagerController::class, 'resolveTicket'])->name('manager.tickets.resolve');

    Route::get('/manager/employees', [ManagerController::class, 'indexEmployees'])->name('manager.employees.index');
    Route::get('/manager/employees/{employee}/edit', [ManagerController::class, 'editEmployees'])->name('manager.employees.edit');
    Route::put('/manager/employees/{employee}', [ManagerController::class, 'updateEmployees'])->name('manager.employees.update');
    Route::delete('/manager/employees/{employee}', [ManagerController::class, 'destroyEmployees'])->name('manager.employees.destroy');
});

Route::get('/dashboard/member/gym-search', [GymSearchController::class, 'index'])->name('gym.search');
Route::get('/plans/{gym_id}', [GymSearchController::class, 'showPlans'])->name('plans.show');

Route::get('/my-gyms', [MyGymController::class, 'index'])->name('gym.my');

Route::get('/payment-data', [SubscriptionController::class, 'index'])->name('payment.data');

Route::get('/about', [AboutController::class, 'index'])->name('about');

Route::get('/helpcenter', [HelpCenterController::class, 'index'])->name('helpcenter.index');
Route::get('/helpcenter/ticket', [HelpCenterController::class, 'showTicketForm'])->name('helpcenter.ticket.create');
Route::post('/helpcenter/ticket', [HelpCenterController::class, 'storeTicket'])->name('helpcenter.ticket.store');

Route::get('/forgot-password', [PasswordResetController::class, 'showLinkRequestForm'])->name('password.request');
Route::post('/forgot-password', [PasswordResetController::class, 'sendResetLinkEmail'])->name('password.email');
Route::get('/forgot-password/verify', [PasswordResetController::class, 'showVerificationForm'])->name('password.verify');
Route::post('/forgot-password/verify', [PasswordResetController::class, 'verifyCode'])->name('password.verify.post');
Route::get('/forgot-password/reset', [PasswordResetController::class, 'showResetForm'])->name('password.reset');
Route::post('/forgot-password/reset', [PasswordResetController::class, 'resetPassword'])->name('password.reset.post');