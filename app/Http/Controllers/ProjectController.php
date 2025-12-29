<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProjectController extends Controller
{
    public function index()
    {
        // Fetch projects with their client data
        $projects = Project::where('user_id', Auth::id())
            ->with('client')
            ->orderByDesc('updated_at')
            ->get();

        return view('projects.index', compact('projects'));
    }

    public function create()
    {
        // We need the list of clients to populate the dropdown
        $clients = \App\Models\Client::all();

        return view('projects.create', compact('clients'));
    }
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'client_id' => 'required|exists:clients,id',
            'status' => 'required|string|in:planning,in_progress,completed,on_hold,cancelled',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date',
            'description' => 'nullable|string',
        ]);

        $project = new Project($validated);
        $project->user_id = Auth::id();
        $project->save();

        return redirect()->route('projects.index')->with('success', 'Project created successfully.');
    }

    // Show the Edit Form
    public function edit($id)
    {
        // Find project belonging to the logged-in user
        $project = Project::where('user_id', Auth::id())->findOrFail($id);

        // Get clients for the dropdown
        $clients = \App\Models\Client::all();

        return view('projects.edit', compact('project', 'clients'));
    }

    // Handle the Update logic
    public function update(Request $request, $id)
    {
        $project = Project::where('user_id', Auth::id())->findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'client_id' => 'required|exists:clients,id',
            'status' => 'required|string|in:planning,in_progress,completed,on_hold,cancelled',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'description' => 'nullable|string',
            'budget' => 'nullable|numeric|min:0|max:99999999',
        ]);

        $project->update($validated);

        return redirect()->route('projects.index')->with('success', 'Project updated successfully.');
    }

    public function show($id)
    {
        // If Super Admin, find any project. If regular user, only find their own.
        $query = Project::with(['client', 'tasks', 'invoices']);

        if (Auth::user()->role !== 'super_admin') {
            $query->where('user_id', Auth::id());
        }

        $project = $query->findOrFail($id);

        return view('projects.show', compact('project'));
    }

}
