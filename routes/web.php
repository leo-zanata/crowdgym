<?php

use App\Http\Controllers\HelpCenterController;
use App\Http\Controllers\AboutController;
use App\Http\Controllers\SubscriptionController;
use App\Http\Controllers\MyGymController;
use App\Http\Controllers\GymController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AdminGymController;
use App\Http\Controllers\AdminManagerController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ManagerController;
use App\Http\Controllers\PasswordResetController;
use App\Http\Controllers\Admin\AdminUserController;
use App\Http\Controllers\PlanController;
use App\Http\Controllers\CheckoutController;

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);

Route::get('/register', [AuthController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);

Route::get('/email/verify', [AuthController::class, 'showEmailVerificationForm'])->name('verification.notice');
Route::post('/email/verify', [AuthController::class, 'verifyEmail'])->name('verification.verify');
Route::post('/email/verify/resend', [AuthController::class, 'resendVerificationCode'])->name('verification.resend');

Route::get('/register-gym', [GymController::class, 'create'])->name('gym.register');
Route::post('/register-gym', [GymController::class, 'store'])->name('gym.store');

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('checkout/success', [CheckoutController::class, 'success'])->name('checkout.success');
Route::get('checkout/cancel', [CheckoutController::class, 'cancel'])->name('checkout.cancel');

Route::middleware('auth')->group(function () {
    Route::get('checkout/{plan}', [CheckoutController::class, 'create'])->name('checkout.create');
});

Route::middleware('auth')->group(function () {
    Route::get('/dashboard/admin', [DashboardController::class, 'showAdminDashboard'])->name('dashboard.admin');
    Route::get('/dashboard/manager', [DashboardController::class, 'showManagerDashboard'])->name('dashboard.manager');
    Route::get('/dashboard/member', [DashboardController::class, 'showMemberDashboard'])->name('dashboard.member');
    Route::get('/dashboard/employee', [DashboardController::class, 'showEmployeeDashboard'])->name('dashboard.employee');

    Route::get('/helpcenter', [HelpCenterController::class, 'index'])->name('helpcenter.index');
    Route::get('/helpcenter/ticket', [HelpCenterController::class, 'showTicketForm'])->name('helpcenter.ticket.create');
    Route::post('/helpcenter/ticket', [HelpCenterController::class, 'storeTicket'])->name('helpcenter.ticket.store');
});

Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin/gyms/create', [AdminGymController::class, 'create'])->name('admin.gyms.create');
    Route::post('/admin/gyms', [AdminGymController::class, 'store'])->name('admin.gyms.store');
    Route::get('/admin/gyms/pending', [AdminGymController::class, 'pending'])->name('admin.gyms.pending');
    Route::post('/admin/gyms/{gym}/approve', [AdminGymController::class, 'approve'])->name('admin.gyms.approve');
    Route::post('/admin/gyms/{gym}/reject', [AdminGymController::class, 'reject'])->name('admin.gyms.reject');
    Route::get('/admin/managers/create', [AdminManagerController::class, 'create'])->name('admin.managers.create');
    Route::post('/admin/managers', [AdminManagerController::class, 'store'])->name('admin.managers.store');

    Route::get('/admin/tickets', [AdminController::class, 'indexTickets'])->name('admin.tickets.index');
    Route::get('/admin/tickets/{ticket}', [AdminController::class, 'showTicket'])->name('admin.tickets.show');
    Route::post('/admin/tickets/{ticket}/reply', [AdminController::class, 'storeTicketReply'])->name('admin.tickets.reply.store');
    Route::put('/admin/tickets/{ticket}/resolve', [AdminController::class, 'resolveTicket'])->name('admin.tickets.resolve');

    Route::get('/admin/gyms', [AdminGymController::class, 'index'])->name('admin.gyms.index');
    Route::get('/admin/gyms/{gym}/edit', [AdminGymController::class, 'edit'])->name('admin.gyms.edit');
    Route::put('/admin/gyms/{gym}', [AdminGymController::class, 'update'])->name('admin.gyms.update');
    Route::delete('/admin/gyms/{gym}', [AdminGymController::class, 'destroy'])->name('admin.gyms.destroy');

    Route::get('/admin/users', [AdminUserController::class, 'index'])->name('admin.users.index');
    Route::get('/admin/users/{user}/edit', [AdminUserController::class, 'edit'])->name('admin.users.edit');
    Route::put('/admin/users/{user}', [AdminUserController::class, 'update'])->name('admin.users.update');
    Route::delete('/admin/users/{user}', [AdminUserController::class, 'destroy'])->name('admin.users.destroy');
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

    Route::get('/manager/gym', [ManagerController::class, 'editGym'])->name('manager.gym.edit');
    Route::put('/manager/gym', [ManagerController::class, 'updateGym'])->name('manager.gym.update');
});

Route::get('/gyms', [GymController::class, 'index'])->name('gyms.index');
Route::get('/gyms/{gym}', [GymController::class, 'show'])->name('gyms.show');

Route::get('/plans/{gym}', [PlanController::class, 'index'])->name('plans.index');

Route::get('/my-gyms', [MyGymController::class, 'index'])->name('gym.my');

Route::get('/payment-data', [SubscriptionController::class, 'index'])->name('payment.data');

Route::get('/about', [AboutController::class, 'index'])->name('about');

Route::get('/forgot-password', [PasswordResetController::class, 'showLinkRequestForm'])->name('password.request');
Route::post('/forgot-password', [PasswordResetController::class, 'sendResetLinkEmail'])->name('password.email');
Route::get('/forgot-password/verify', [PasswordResetController::class, 'showVerificationForm'])->name('password.verify');
Route::post('/forgot-password/verify', [PasswordResetController::class, 'verifyCode'])->name('password.verify.post');
Route::get('/forgot-password/reset', [PasswordResetController::class, 'showResetForm'])->name('password.reset');
Route::post('/forgot-password/reset', [PasswordResetController::class, 'resetPassword'])->name('password.reset.post');