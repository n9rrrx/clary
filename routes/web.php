<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

// Public Routes
Route::get('/', function () {
    return view('welcome');
});

// Authentication Routes
require __DIR__.'/auth.php';

// --- MAIN APP ROUTES ---
Route::middleware(['auth', 'verified'])->group(function () {

    // 1. DASHBOARD & AGENCY RESOURCES
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::resource('clients', ClientController::class);
    Route::resource('projects', ProjectController::class);
    Route::resource('tasks', TaskController::class);
    Route::resource('invoices', InvoiceController::class);
    Route::post('/dashboard/activity', [DashboardController::class, 'storeActivity'])->name('dashboard.activity.store');

    // 2. SUPER ADMIN ONLY: Agency Management (Users)
    // We strictly use the Gate check here. No extra closure needed.
    Route::resource('users', UserController::class)->middleware('can:access-agencies');

    // 3. PROFILE SETTINGS
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // 4. CLIENT PORTAL
    Route::get('/portal', function() {
        return "Client Portal Coming Soon";
    })->name('client.portal');

});
