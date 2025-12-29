<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // Import Auth

class ClientController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // 1. If Client is logged in, only show their OWN profile
        // (Optional security step depending on your needs)
        if (Auth::user()->role === 'user') {
            $clients = Client::where('email', Auth::user()->email)
                ->with(['projects', 'invoices'])
                ->paginate(15);
        } else {
            // Admins see everyone
            $clients = Client::with(['projects', 'invoices'])->paginate(15);
        }

        return response()->json($clients);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // 1. Security: Only Admins can create new Clients via API
        if (Auth::user()->role === 'user') {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:255',
            'company' => 'nullable|string|max:255',
            'address' => 'nullable|string',
            'notes' => 'nullable|string',
            'status' => 'nullable|in:active,inactive',
        ]);

        // Default to active if not set
        $validated['status'] = $validated['status'] ?? 'active';

        $client = Client::create($validated);
        return response()->json($client, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Client $client)
    {
        // 1. Security: If Client, allow only if it matches their email
        if (Auth::user()->role === 'user' && $client->email !== Auth::user()->email) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        return response()->json($client->load(['projects', 'invoices']));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Client $client)
    {
        // 1. Security: If Client, allow only if it matches their email
        if (Auth::user()->role === 'user' && $client->email !== Auth::user()->email) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        // 2. Define Rules
        $rules = [
            'name' => 'sometimes|required|string|max:255',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:255',
            'company' => 'nullable|string|max:255',
            'address' => 'nullable|string',
            'notes' => 'nullable|string',
        ];

        // 3. RBAC LOGIC: Only Admins can update 'status'
        if (Auth::user()->role !== 'user') {
            $rules['status'] = 'nullable|in:active,inactive';
        }

        $validated = $request->validate($rules);

        // 4. Extra Safety: Explicitly unset status if a 'user' tried to sneak it in
        if (Auth::user()->role === 'user' && isset($validated['status'])) {
            unset($validated['status']);
        }

        $client->update($validated);
        return response()->json($client);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Client $client)
    {
        // 1. Security: Only Admins can delete
        if (Auth::user()->role === 'user') {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $client->delete();
        return response()->json(null, 204);
    }
}
