<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\TeamMemberController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\AgencyProfileController;
use App\Http\Controllers\Api\ChatController;
use App\Http\Controllers\Client\InvoiceController as ClientInvoiceController;

// Public Routes
Route::get('/', function () {
    return view('welcome');
});

// Authentication Routes
require __DIR__.'/auth.php';

// --- MAIN APP ROUTES ---
Route::middleware(['auth', 'verified'])->group(function () {

    // 1. DASHBOARD
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // 2. RESOURCES
    Route::resource('clients', ClientController::class);
    Route::resource('projects', ProjectController::class);
    Route::post('/projects/{project}/members', [ProjectController::class, 'assignMember'])->name('projects.members.assign');
    Route::delete('/projects/{project}/members/{user}', [ProjectController::class, 'removeMember'])->name('projects.members.remove');
    Route::resource('tasks', TaskController::class);
    Route::resource('invoices', InvoiceController::class);
    
    Route::post('/dashboard/activity', [DashboardController::class, 'storeActivity'])->name('dashboard.activity.store');

    // 3. USER/TEAM MANAGEMENT (For Owners)
    Route::get('/team', [TeamMemberController::class, 'index'])->name('team.index');
    Route::post('/team/invite', [TeamMemberController::class, 'store'])->name('team.invite');
    Route::delete('/team/{user}', [TeamMemberController::class, 'destroy'])->name('team.remove');

    // 4. PROFILE SETTINGS
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // 5. ADMIN CHAT API (For Dashboard Polling)
    Route::get('/dashboard/chat/{client}/messages', [ChatController::class, 'adminFetch'])->name('admin.chat.fetch');

    // 6. SETTINGS
    Route::get('/settings', [AgencyProfileController::class, 'edit'])->name('settings.edit');
    Route::post('/settings', [AgencyProfileController::class, 'update'])->name('settings.update');

    // 7. CLIENT PORTAL
    Route::middleware(['auth'])->prefix('portal')->group(function () {
        Route::get('/', function() {
            return view('client.dashboard');
        })->name('client.portal');
        Route::get('/invoices/{invoice}', [ClientInvoiceController::class, 'show'])->name('clients.invoices.show');
        Route::get('/projects/{project}', [ProjectController::class, 'clientShow'])->name('client.projects.show');
    });
});
