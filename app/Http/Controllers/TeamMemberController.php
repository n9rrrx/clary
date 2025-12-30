<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use App\Models\Task;
use App\Models\User;
use App\Models\Team;
use App\Models\Project;
use App\Mail\TeamInvitation;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class TeamMemberController extends Controller
{
    /**
     * Show team members list
     */
    public function index()
    {
        $user = Auth::user();
        $team = $user->currentTeam;

        if (!$team) {
            return redirect()->route('dashboard')->with('error', 'You don\'t have a team. Please contact support.');
        }

        $members = $team->members()->get();
        $isOwner = $team->owner_id === $user->id;
        
        // Get projects for optional assignment during invite
        $projects = $team ? Project::where('team_id', $team->id)->where('status', '!=', 'cancelled')->get() : collect();

        return view('team.index', compact('members', 'team', 'isOwner', 'projects'));
    }

    /**
     * Invite a new team member (Atlassian-style: just email, name, role)
     */
    public function store(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'name' => 'required|string|max:255',
            'role' => 'required|in:admin,member,viewer',
            'project_id' => 'nullable|exists:projects,id',
        ]);

        $currentUser = Auth::user();
        $team = $currentUser->currentTeam;

        // Only owner/admin can invite
        if ($team->owner_id !== $currentUser->id) {
            return redirect()->back()->with('error', 'Only the team owner can invite members.');
        }

        $email = $request->email;

        // Check if user already exists
        $existingUser = User::where('email', $email)->first();

        if ($existingUser) {
            // Check if already in team
            if ($team->members()->where('user_id', $existingUser->id)->exists()) {
                return redirect()->back()->with('error', 'This user is already in your team.');
            }

            // Add existing user to team
            $team->members()->attach($existingUser->id, [
                'role' => $request->role,
            ]);

            // Optionally assign to project if provided
            if ($request->project_id) {
                $project = Project::findOrFail($request->project_id);
                // Verify project belongs to the team
                if ($project->team_id === $team->id && !$project->members()->where('user_id', $existingUser->id)->exists()) {
                    $project->members()->attach($existingUser->id);
                }
            }

            return redirect()->back()->with('success', 'Existing user added to your team' . ($request->project_id ? ' and assigned to project' : '') . '.');
        }

        // Create new user with temporary password
        $tempPassword = Str::random(10);

        $newUser = User::create([
            'name' => $request->name,
            'email' => $email,
            'password' => Hash::make($tempPassword),
            'role' => 'member',
            'current_team_id' => $team->id,
        ]);

        // Add to team with specified role
        $team->members()->attach($newUser->id, [
            'role' => $request->role,
        ]);

        // Optionally assign to project if provided
        if ($request->project_id) {
            $project = Project::findOrFail($request->project_id);
            // Verify project belongs to the team
            if ($project->team_id === $team->id) {
                $project->members()->attach($newUser->id);
            }
        }

        // Send invitation email
        try {
            Mail::to($email)->send(new TeamInvitation(
                $newUser,
                $tempPassword,
                $team->name,
                0, // No budget in Atlassian model
                $request->role
            ));
        } catch (\Exception $e) {
            \Log::error('Failed to send team invitation email: ' . $e->getMessage());
        }

        return redirect()->back()->with('success', 'Team member invited! Email sent with login credentials.');
    }

    /**
     * Remove a team member and all their data
     */
    public function destroy(User $user)
    {
        $currentUser = Auth::user();
        $team = $currentUser->currentTeam;

        if ($team->owner_id !== $currentUser->id) {
            return redirect()->back()->with('error', 'Only the team owner can remove members.');
        }

        if ($user->id === $currentUser->id) {
            return redirect()->back()->with('error', 'You cannot remove yourself from the team.');
        }

        // Delete user's activities (chat messages)
        Activity::where('user_id', $user->id)->delete();

        // Unassign user's tasks (set assigned_to to null instead of deleting)
        Task::where('assigned_to_user_id', $user->id)
            ->where('team_id', $team->id)
            ->update(['assigned_to_user_id' => null]);

        // Detach from team
        $team->members()->detach($user->id);

        return redirect()->back()->with('success', 'Member removed and their activities cleared.');
    }
}
