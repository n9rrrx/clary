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

// Protected Routes (Require Login & Email Verification)
Route::middleware(['auth', 'verified'])->group(function () {

    // 1. Main Dashboard (Agency Admin)
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // 2. Super Admin Dashboard
    Route::prefix('admin')->name('super_admin.')->group(function () {
        Route::get('/dashboard', function () {
            return view('super_admin.dashboard');
        })->name('dashboard');
    });

    // 3. Client Portal (Your new Profile View)
    // We connect this to the 'show' method you added in ProfileController
    Route::get('/portal', [ProfileController::class, 'show'])->name('client.portal');

    // 4. Profile Settings (Breeze Defaults - Edit/Update/Delete)
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // 5. App Resources
    Route::resource('clients', ClientController::class);
    Route::resource('projects', ProjectController::class);
    Route::resource('tasks', TaskController::class);
    Route::resource('invoices', InvoiceController::class);
});
