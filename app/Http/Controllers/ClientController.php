<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\User; // <--- Added User model
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ClientController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // LOGIC UPDATE:
        // If Super Admin, show ALL clients.
        // If Agency Admin, show ONLY their clients.

        if (Auth::user()->role === 'super_admin') {
            $clients = Client::with('user') // Eager load user to display name efficiently
            ->orderByDesc('updated_at')
                ->get();
        } else {
            $clients = Client::where('user_id', Auth::id())
                ->orderByDesc('updated_at')
                ->get();
        }

        return view('clients.index', compact('clients'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // LOGIC UPDATE: Fetch list of Agencies for the dropdown
        $agencies = [];
        if (Auth::user()->role === 'super_admin') {
            $agencies = User::where('role', 'admin')->get();
        }

        return view('clients.create', compact('agencies'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // 1. Define Rules
        $rules = [
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'type' => 'required|in:customer,lead,partner,prospect',
            'status' => 'required|in:active,inactive',
            'tag' => 'required|in:Developer,Designer,Partner,Prospect',
        ];

        // 2. Extra Rule for Super Admin
        if (Auth::user()->role === 'super_admin') {
            $rules['owner_id'] = 'required|exists:users,id';
        }

        $validated = $request->validate($rules);

        // 3. Determine Owner
        // If Super Admin, use the picked owner. If Agency Admin, use themselves.
        $ownerId = Auth::user()->role === 'super_admin'
            ? $validated['owner_id']
            : Auth::id();

        // 4. Process Tags
        $tagsJson = json_encode([$validated['tag']]);

        // 5. Create Client
        // We use Client::create instead of $user->clients()->create so we can manually set user_id
        Client::create([
            'user_id' => $ownerId,
            'name' => $validated['name'],
            'email' => $validated['email'],
            'type' => $validated['type'],
            'status' => $validated['status'],
            'tags' => $tagsJson,
        ]);

        return redirect()->route('clients.index');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Client $client)
    {
        // Security: Allow if owner OR super_admin
        if ($client->user_id !== Auth::id() && Auth::user()->role !== 'super_admin') {
            abort(403);
        }

        // LOGIC UPDATE: Fetch list of Agencies for the dropdown (Super Admin only)
        $agencies = [];
        if (Auth::user()->role === 'super_admin') {
            $agencies = User::where('role', 'admin')->get();
        }

        return view('clients.edit', compact('client', 'agencies'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Client $client)
    {
        // Security Check
        if ($client->user_id !== Auth::id() && Auth::user()->role !== 'super_admin') {
            abort(403);
        }

        // 1. Validate (Using 'tag' singular, matching the dropdown)
        $rules = [
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'type' => 'required|in:customer,lead,partner,prospect',
            'status' => 'required|in:active,inactive',
            'tag' => 'required|in:Developer,Designer,Partner,Prospect', // <--- FIXED
        ];

        if (Auth::user()->role === 'super_admin') {
            $rules['owner_id'] = 'required|exists:users,id';
        }

        $validated = $request->validate($rules);

        // 2. Process Tag (Wrap the single tag in an array)
        $tagsJson = json_encode([$validated['tag']]);

        // 3. Prepare Data
        $data = [
            'name' => $validated['name'],
            'email' => $validated['email'],
            'type' => $validated['type'],
            'status' => $validated['status'],
            'tags' => $tagsJson, // <--- Save the array
        ];

        // 4. Update Owner (Super Admin only)
        if (Auth::user()->role === 'super_admin') {
            $data['user_id'] = $validated['owner_id'];
        }

        $client->update($data);

        return redirect()->route('clients.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Client $client)
    {
        if ($client->user_id !== Auth::id() && Auth::user()->role !== 'super_admin') {
            abort(403);
        }

        $client->delete();

        return redirect()->route('clients.index');
    }
}
