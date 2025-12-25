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

    public function create() { return view('projects.create'); }
    // Add store, edit, update, destroy methods as needed...
}
