<?php

use App\Models\Client;
use App\Models\Project;
use App\Models\Task;
use App\Models\Invoice;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    $clients = Client::with(['projects', 'invoices'])->get();
    $projects = Project::with('client')->get();
    $tasks = Task::with(['project', 'assignedUser'])->get();
    $invoices = Invoice::with('client')->get();
    
    return view('dashboard', compact('clients', 'projects', 'tasks', 'invoices'));
})->name('dashboard');

Route::get('/clients', function () {
    $clients = Client::with(['projects', 'invoices'])->get();
    return view('clients.index', compact('clients'));
})->name('clients.index');

Route::get('/projects', function () {
    $projects = Project::with(['client', 'tasks'])->get();
    return view('projects.index', compact('projects'));
})->name('projects.index');

Route::get('/tasks', function () {
    $tasks = Task::with(['project', 'assignedUser'])->get();
    return view('tasks.index', compact('tasks'));
})->name('tasks.index');

Route::get('/invoices', function () {
    $invoices = Invoice::with(['client', 'project'])->get();
    return view('invoices.index', compact('invoices'));
})->name('invoices.index');
