<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;

// Public Routes
Route::get('/', function () {
    return view('welcome');
});

// Authentication Routes (Login, Register, Password Reset)
require __DIR__.'/auth.php';

Route::middleware(['auth', 'verified'])->group(function () {

    // --- ADMIN AREA (Locked) ---
    // Only 'admin' or 'super_admin' can access these
    Route::middleware(['role:admin'])->group(function () {

        // Agency Dashboard
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

        // Agency Resources
        Route::resource('clients', ClientController::class);
        Route::resource('projects', ProjectController::class);
        Route::resource('tasks', TaskController::class);
        Route::resource('invoices', InvoiceController::class);
    });

    // --- SUPER ADMIN AREA (Locked) ---
    Route::prefix('admin')->name('super_admin.')->middleware(['role:super_admin'])->group(function () {
        Route::get('/dashboard', function () {
            return view('super_admin.dashboard');
        })->name('dashboard');
    });

    // --- CLIENT / USER AREA (Open to all logged in users) ---
    // If a normal user tries to go to /dashboard, the middleware kicks them here.
    Route::get('/portal', [ProfileController::class, 'show'])->name('client.portal');

    // Profile Settings
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});
