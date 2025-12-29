<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class UserController extends Controller
{
    /**
     * Enforce Super Admin Only.
     */


    /**
     * Display a listing of the Agencies.
     */
    public function index()
    {
        // 1. Get all users who are 'admin' (Agencies)
        // 2. Count how many clients they have (withCount)
        // 3. Sort by newest first
        $users = User::where('role', 'admin')
            ->withCount('clients')
            ->latest()
            ->paginate(10);

        return view('users.index', compact('users'));
    }

    /**
     * Show the form for creating a new Agency.
     */
    public function create()
    {
        return view('users.create');
    }

    /**
     * Store a newly created Agency in database.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'admin', // FORCE ROLE TO ADMIN (Agency)
        ]);

        return redirect()->route('users.index')->with('success', 'Agency created successfully.');
    }

    /**
     * Show the form for editing the specified Agency.
     */
    public function edit(User $user)
    {
        return view('users.edit', compact('user'));
    }

    /**
     * Update the specified Agency in database.
     */
    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,'.$user->id],
            // Password is optional on update
            'password' => ['nullable', 'confirmed', Rules\Password::defaults()],
        ]);

        $user->name = $request->name;
        $user->email = $request->email;

        // Only update password if they typed a new one
        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        return redirect()->route('users.index')->with('success', 'Agency updated successfully.');
    }

    /**
     * Remove (Ban/Delete) the specified Agency.
     */
    public function destroy(User $user)
    {
        // Prevent deleting yourself just in case
        if ($user->id === Auth::id()) {
            return back()->with('error', 'You cannot delete yourself.');
        }

        $user->delete();

        return redirect()->route('users.index')->with('success', 'Agency deleted successfully.');
    }
}
