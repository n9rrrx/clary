<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\User;
use App\Mail\TeamInvitation;
use App\Services\PlanService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class ClientController extends Controller
{
    /**
     * Display a listing of all Clients (scoped to team).
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        $team = $user->currentTeam;

        $query = Client::query();

        // Filter by sidebar tags if present
        if ($request->has('tag')) {
            $query->whereJsonContains('tags', $request->tag);
        }

        // Scope to current team
        if ($team) {
            $query->where('team_id', $team->id);
        }

        $clients = $query->orderByDesc('updated_at')->get();

        return view('clients.index', compact('clients'));
    }

    /**
     * Show the form for creating a new Client.
     */
    public function create()
    {
        return view('clients.create');
    }

    /**
     * Store a new Client.
     */
    public function store(Request $request)
    {
        $user = Auth::user();
        $team = $user->currentTeam;

        // Check plan limits
        $planService = app(PlanService::class);
        if (!$planService->canCreateClient($user)) {
            $limit = $planService->getLimit($user, 'clients');
            return redirect()->back()->with('error', "You've reached the {$limit} client limit on your plan. Upgrade to Pro for unlimited clients.");
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'type' => 'required|in:customer,lead,partner,prospect',
            'status' => 'required|in:active,inactive',
            'tag' => 'required|in:Developer,Designer,Partner,Prospect',
            'budget' => 'nullable|numeric',
        ]);

        Client::create([
            'team_id' => $team?->id,
            'name' => $validated['name'],
            'email' => $validated['email'],
            'type' => $validated['type'],
            'status' => $validated['status'],
            'tags' => json_encode([$validated['tag']]),
            'budget' => $validated['budget'] ?? 0,
        ]);

        return redirect()->route('clients.index')->with('success', 'Client created successfully.');
    }

    /**
     * Show the edit form.
     */
    public function edit(Client $client)
    {
        $user = Auth::user();
        $team = $user->currentTeam;

        // Permission check: Client must belong to user's team
        if ($team && $client->team_id !== $team->id) {
            abort(403);
        }

        return view('clients.edit', compact('client'));
    }

    /**
     * Update an existing Client.
     */
    public function update(Request $request, Client $client)
    {
        $user = Auth::user();
        $team = $user->currentTeam;

        // Authorization
        if ($team && $client->team_id !== $team->id) {
            abort(403);
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'type' => 'required|in:customer,lead,partner,prospect',
            'status' => 'required|in:active,inactive',
            'tag' => 'required|in:Developer,Designer,Partner,Prospect',
            'budget' => 'nullable|numeric',
        ]);

        $client->update([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'type' => $validated['type'],
            'status' => $validated['status'],
            'tags' => json_encode([$validated['tag']]),
            'budget' => $validated['budget'] ?? 0,
        ]);

        return redirect()->route('clients.index')->with('success', 'Client updated successfully.');
    }

    /**
     * Delete the client.
     */
    public function destroy(Client $client)
    {
        $user = Auth::user();
        $team = $user->currentTeam;

        if ($team && $client->team_id !== $team->id) {
            abort(403);
        }

        $client->delete();

        return redirect()->route('clients.index')->with('success', 'Client deleted successfully.');
    }
}
