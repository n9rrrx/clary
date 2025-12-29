<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Client;
use App\Models\Activity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProjectController extends Controller
{
    // ==========================================
    // ADMIN DASHBOARD METHODS
    // ==========================================

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $projects = Project::with('client')->latest()->paginate(10);
        return view('projects.index', compact('projects'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $clients = Client::all();
        return view('projects.create', compact('clients'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'client_id' => 'required|exists:clients,id',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'budget' => 'nullable|numeric|min:0',
            'status' => 'required|in:planning,in_progress,completed,on_hold,cancelled',
        ]);

        Project::create($validated);

        return redirect()->route('projects.index')->with('success', 'Project created successfully.');
    }

    /**
     * Display the specified resource (Admin View).
     * [FIX]: This was the missing method causing your error.
     */
    public function show(Project $project)
    {
        // Eager load relationships for the view
        $project->load(['client', 'tasks', 'invoices']);

        // Ensure you have a view at resources/views/projects/show.blade.php
        return view('projects.show', compact('project'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Project $project)
    {
        $clients = Client::all();
        return view('projects.edit', compact('project', 'clients'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Project $project)
    {
        $validated = $request->validate([
            'client_id' => 'required|exists:clients,id',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'budget' => 'nullable|numeric|min:0',
            'status' => 'required|in:planning,in_progress,completed,on_hold,cancelled',
        ]);

        $project->update($validated);

        return redirect()->route('projects.index')->with('success', 'Project updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Project $project)
    {
        $project->delete();
        return redirect()->route('projects.index')->with('success', 'Project deleted successfully.');
    }

    // ==========================================
    // CLIENT PORTAL METHODS
    // ==========================================

    public function clientShow(Project $project)
    {
        $user = Auth::user();
        $clientProfile = Client::where('email', $user->email)->first();

        // Security check: Ensure this client owns this project
        if (!$clientProfile || $project->client_id !== $clientProfile->id) {
            abort(403, 'Unauthorized access to this project.');
        }

        $project->load(['tasks']);

        // Fetch activity feed (using the Client Profile ID)
        $activities = Activity::where('client_id', $clientProfile->id)
            ->with('user')
            ->orderBy('created_at', 'asc')
            ->get();

        return view('projects.client_show', compact('project', 'activities'));
    }

    public function storeComment(Request $request, Project $project)
    {
        $request->validate(['body' => 'required|string']);

        $user = Auth::user();
        $clientProfile = Client::where('email', $user->email)->first();

        if (!$clientProfile || $project->client_id !== $clientProfile->id) {
            abort(403);
        }

        Activity::create([
            'user_id' => $user->id,
            'client_id' => $clientProfile->id,
            'type' => 'comment',
            'description' => "posted on project: {$project->name}",
            'body' => $request->body,
        ]);

        if ($request->wantsJson()) {
            return response()->json(['status' => 'success']);
        }

        return back()->with('success', 'Message posted!');
    }
}
