<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Mail\TeamInvitation;
use Illuminate\Support\Facades\Mail;

class TeamController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        if ($user->role === 'super_admin') {
            // Super Admins see ALL users who belong to ANY client
            $team = User::whereNotNull('client_id')->with('clientTenant')->get();
        } else {
            // Company Admins only see users belonging to THEIR specific site
            $team = User::where('client_id', $user->client_id)
                ->where('id', '!=', $user->id)
                ->get();
        }

        return view('clients.team.index', compact('team'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            // Note: your current User model logic ignores this sub-role
            // but keep it if you plan to use Spatie or custom permissions later
            'role' => 'required|in:user,editor,viewer',
        ]);

        // 1. Define the variable name clearly
        $tempPassword = Str::random(12);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($tempPassword),
            'role' => 'user',
            'client_id' => Auth::user()->client_id,
            'company_id' => Auth::user()->company_id
        ]);

        // Send invitation email with sender info
        Mail::to($user->email)->send(new TeamInvitation(
            $user,
            $tempPassword,
            'Your Team', // Team name
            0, // Budget
            'Member', // Role
            null, // Project
            Auth::user() // Pass the sender (owner)
        ));

        return redirect()->back()->with('success', 'Team member invited successfully.');
    }
}
