<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Client;
use App\Models\Activity;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     * - Owners/Admins: See all projects in team
     * - Members: See only projects where they have tasks assigned
     * - Viewers: Same as members
     */
    public function index()
    {
        $user = Auth::user();
        $team = $user->currentTeam;

        $query = Project::latest();

        if ($team) {
            $query->where('team_id', $team->id);

            // Check user's role in team
            $membership = $user->teams()->where('team_id', $team->id)->first();
            $role = $membership?->pivot?->role ?? 'member';

            // Non-admins only see projects with assigned tasks
            if (!in_array($role, ['admin', 'owner']) && $team->owner_id !== $user->id) {
                $query->whereHas('tasks', function ($q) use ($user) {
                    $q->where('assigned_to_user_id', $user->id);
                });
            }
        }

        $projects = $query->paginate(10);
        return view('projects.index', compact('projects'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $user = Auth::user();
        $team = $user->currentTeam;

        // Only get clients for this team
        $clients = $team ? Client::where('team_id', $team->id)->get() : collect();
        
        return view('projects.create', compact('clients'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $user = Auth::user();
        $team = $user->currentTeam;

        $validated = $request->validate([
            'client_id' => 'nullable|exists:clients,id',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'budget' => 'nullable|numeric|min:0',
            'status' => 'required|in:planning,in_progress,completed,on_hold,cancelled',
        ]);

        $validated['team_id'] = $team?->id;

        Project::create($validated);

        return redirect()->route('projects.index')->with('success', 'Project created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Project $project)
    {
        $user = Auth::user();
        $team = $user->currentTeam;
        
        $project->load(['client', 'tasks.assignedTo', 'invoices', 'members']);
        
        // Get all team members for the assignment dropdown (owners/admins only)
        $teamMembers = ($user->isOwnerOfCurrentTeam() && $team) 
            ? $team->members()->get()
            : collect();
        
        return view('projects.show', compact('project', 'teamMembers'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Project $project)
    {
        $user = Auth::user();
        $team = $user->currentTeam;

        $clients = $team ? Client::where('team_id', $team->id)->get() : collect();
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

        if (!$clientProfile || $project->client_id !== $clientProfile->id) {
            abort(403, 'Unauthorized access to this project.');
        }

        $project->load(['tasks']);

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

    // ==========================================
    // PROJECT MEMBER MANAGEMENT
    // ==========================================

    /**
     * Assign a user to a project
     */
    public function assignMember(Request $request, Project $project)
    {
        $user = Auth::user();
        
        // Only owners/admins can assign members
        if (!$user->isOwnerOfCurrentTeam()) {
            return redirect()->back()->with('error', 'Only team owners can assign project members.');
        }

        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
        ]);

        // Check if user is already assigned
        if ($project->members()->where('user_id', $validated['user_id'])->exists()) {
            return redirect()->back()->with('error', 'User is already assigned to this project.');
        }

        // Check if user belongs to the same team
        $team = $user->currentTeam;
        $targetUser = User::findOrFail($validated['user_id']);
        
        if (!$team->members()->where('user_id', $targetUser->id)->exists()) {
            return redirect()->back()->with('error', 'User must be a team member first.');
        }

        $project->members()->attach($validated['user_id']);

        return redirect()->back()->with('success', 'Team member assigned to project successfully.');
    }

    /**
     * Remove a user from a project
     */
    public function removeMember(Project $project, User $user)
    {
        $currentUser = Auth::user();
        
        // Only owners/admins can remove members
        if (!$currentUser->isOwnerOfCurrentTeam()) {
            return redirect()->back()->with('error', 'Only team owners can remove project members.');
        }

        $project->members()->detach($user->id);

        return redirect()->back()->with('success', 'Team member removed from project successfully.');
    }
}
