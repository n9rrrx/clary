<?php

namespace App\Http\Controllers;

use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ClientController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Fetch clients for the logged-in user, ordered by newest first
        $clients = Client::where('user_id', Auth::id())
            ->orderByDesc('updated_at')
            ->get();

        // Pass the variable '$clients' to the view
        return view('clients.index', compact('clients'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('clients.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'type' => 'required|in:customer,lead,partner',
            'status' => 'required|in:active,inactive',
        ]);

        // Create the client linked to the user
        $request->user()->clients()->create($validated);

        return redirect()->route('clients.index');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Client $client)
    {
        // Security: Ensure user owns this client
        if ($client->user_id !== Auth::id()) {
            abort(403);
        }

        return view('clients.edit', compact('client'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Client $client)
    {
        if ($client->user_id !== Auth::id()) {
            abort(403);
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'type' => 'required|in:customer,lead,partner',
            'status' => 'required|in:active,inactive',
        ]);

        $client->update($validated);

        return redirect()->route('clients.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Client $client)
    {
        if ($client->user_id !== Auth::id()) {
            abort(403);
        }

        $client->delete();

        return redirect()->route('clients.index');
    }
}
