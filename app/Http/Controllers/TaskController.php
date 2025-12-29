<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{
    public function index()
    {
        // Get all tasks for the logged-in user (via their projects)
        // Note: This assumes tasks belong to projects, and projects belong to users.
        $tasks = Task::whereHas('project', function($query) {
            $query->where('user_id', Auth::id());
        })->with('project')->latest()->get();

        return view('tasks.index', compact('tasks'));
    }

    public function create()
    {
        // Fetch User's Projects to populate dropdown
        $projects = Project::where('user_id', Auth::id())->get();
        return view('tasks.create', compact('projects'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255', // CHANGED: matches DB column
            'project_id' => 'required|exists:projects,id',
            // CHANGED: matches DB Enum
            'status' => 'required|string|in:todo,in_progress,review,completed',
            'priority' => 'required|string|in:low,medium,high,urgent',
            'due_date' => 'nullable|date',
            'description' => 'nullable|string',
        ]);

        $task = new Task($validated);
        $task->user_id = Auth::id(); // REQUIRED: Your DB says user_id cannot be null
        $task->save();

        return redirect()->route('projects.show', $request->project_id)
            ->with('success', 'Task created successfully.');
    }

    public function edit($id)
    {
        // Find task securely (ensure it belongs to a project owned by the user)
        $task = Task::whereHas('project', function($query) {
            $query->where('user_id', Auth::id());
        })->findOrFail($id);

        // Get projects for the dropdown
        $projects = Project::where('user_id', Auth::id())->get();

        return view('tasks.edit', compact('task', 'projects'));
    }

    public function update(Request $request, $id)
    {
        $task = Task::whereHas('project', function($query) {
            $query->where('user_id', Auth::id());
        })->findOrFail($id);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'project_id' => 'required|exists:projects,id',
            'status' => 'required|string|in:todo,in_progress,review,completed',
            'priority' => 'required|string|in:low,medium,high,urgent',
            'due_date' => 'nullable|date',
            'description' => 'nullable|string',
        ]);

        $task->update($validated);

        // Redirect back to the project board for a smooth flow
        return redirect()->route('projects.show', $task->project_id)
            ->with('success', 'Task updated successfully.');
    }

    public function show($id)
    {
        // Find task securely
        $task = Task::whereHas('project', function($query) {
            $query->where('user_id', Auth::id());
        })->with('project.client')->findOrFail($id);

        return view('tasks.show', compact('task'));
    }
}
