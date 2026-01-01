<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();
        $team = $user->currentTeam;

        $query = Task::with(['project.client', 'assignedTo'])->latest();

        if ($team) {
            $query->where('team_id', $team->id);

            // If user is not owner, only show tasks assigned to them
            if (!$user->isOwnerOfCurrentTeam()) {
                $query->where('assigned_to_user_id', $user->id);
            }
        }

        $tasks = $query->paginate(15);
        
        // Get team members for assignment dropdown (owners only)
        $teamMembers = $user->isOwnerOfCurrentTeam() && $team 
            ? $team->members()->get() 
            : collect();

        return view('tasks.index', compact('tasks', 'teamMembers'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $user = Auth::user();
        $team = $user->currentTeam;

        // Get projects for this team
        $projects = $team 
            ? Project::where('team_id', $team->id)->where('status', '!=', 'cancelled')->get()
            : collect();

        // Get team members for assignment (exclude owner - they don't work on tasks)
        $teamMembers = $team 
            ? $team->members()->where('user_id', '!=', $team->owner_id)->get() 
            : collect();

        return view('tasks.create', compact('projects', 'teamMembers'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $user = Auth::user();
        $team = $user->currentTeam;

        $validated = $request->validate([
            'project_id' => 'required|exists:projects,id',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'required|in:pending,in_progress,completed',
            'priority' => 'required|in:low,medium,high',
            'due_date' => 'nullable|date',
            'assigned_to_user_id' => 'nullable|exists:users,id',
        ]);

        $validated['team_id'] = $team?->id;

        Task::create($validated);

        return redirect()->route('tasks.index')
            ->with('success', 'Task created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Task $task)
    {
        $task->load(['project.client', 'assignedTo']);
        return view('tasks.show', compact('task'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Task $task)
    {
        $user = Auth::user();
        $team = $user->currentTeam;

        $projects = $team 
            ? Project::where('team_id', $team->id)->where('status', '!=', 'cancelled')->get()
            : collect();

        // Get team members for assignment (exclude owner)
        $teamMembers = $team 
            ? $team->members()->where('user_id', '!=', $team->owner_id)->get() 
            : collect();

        return view('tasks.edit', compact('task', 'projects', 'teamMembers'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Task $task)
    {
        $validated = $request->validate([
            'project_id' => 'required|exists:projects,id',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'required|in:pending,in_progress,completed',
            'priority' => 'required|in:low,medium,high',
            'due_date' => 'nullable|date',
            'assigned_to_user_id' => 'nullable|exists:users,id',
        ]);

        $task->update($validated);

        return redirect()->back()->with('success', 'Task updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Task $task)
    {
        $task->delete();
        return redirect()->back()->with('success', 'Task deleted successfully.');
    }
}
