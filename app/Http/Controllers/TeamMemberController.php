<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use App\Models\Task;
use App\Models\User;
use App\Models\Team;
use App\Models\Project;
use App\Mail\TeamInvitation;
use App\Services\PlanService;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class TeamMemberController extends Controller
{
    /**
     * Show team members list with optional tag filtering
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        $team = $user->currentTeam;

        if (!$team) {
            return redirect()->route('dashboard')->with('error', 'You don\'t have a team. Please contact support.');
        }

        $members = $team->members()->get();
        
        // Filter by tag if provided
        $tagFilter = $request->get('tag');
        if ($tagFilter) {
            $members = $members->filter(function ($member) use ($tagFilter) {
                $memberTags = is_string($member->tags) ? json_decode($member->tags, true) : ($member->tags ?? []);
                return is_array($memberTags) && in_array($tagFilter, $memberTags);
            });
        }
        
        $isOwner = $team->owner_id === $user->id;
        
        // Get projects for optional assignment during invite
        $projects = $team ? Project::where('team_id', $team->id)->where('status', '!=', 'cancelled')->get() : collect();

        return view('team.index', compact('members', 'team', 'isOwner', 'projects', 'tagFilter'));
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

        // Check plan limits (based on team owner's plan)
        $teamOwner = User::find($team->owner_id);
        $planService = app(PlanService::class);
        if (!$planService->canAddTeamMember($teamOwner)) {
            $limit = $planService->getLimit($teamOwner, 'team_members');
            return redirect()->back()->with('error', "You've reached the {$limit} team member limit on your plan. Upgrade to Pro for unlimited team members.");
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
            $assignedProject = null;
            if ($request->project_id) {
                $project = Project::with('client')->findOrFail($request->project_id);
                // Verify project belongs to the team
                if ($project->team_id === $team->id && !$project->members()->where('user_id', $existingUser->id)->exists()) {
                    $project->members()->attach($existingUser->id);
                    $assignedProject = $project;
                }
            }

            // Send notification email for existing user too
            try {
                Mail::to($email)->send(new TeamInvitation(
                    $existingUser,
                    'Your existing password', // They already have a password
                    $team->name,
                    0,
                    ucfirst($request->role),
                    $assignedProject
                ));
            } catch (\Exception $e) {
                \Log::error('Failed to send team invitation email: ' . $e->getMessage());
            }

            return redirect()->back()->with('success', 'Existing user added to your team' . ($request->project_id ? ' and assigned to project' : '') . '.');
        }

        // Create new user with temporary password
        $tempPassword = Str::random(10);

        // Get tags from checkbox array
        $tags = $request->tags ?? [];

        $newUser = User::create([
            'name' => $request->name,
            'email' => $email,
            'password' => Hash::make($tempPassword),
            'role' => 'member',
            'current_team_id' => $team->id,
            'tags' => $tags,
        ]);

        // Add to team with specified role and budget
        $team->members()->attach($newUser->id, [
            'role' => $request->role,
            'budget_limit' => $request->budget_limit ?? 0,
        ]);

        // Optionally assign to project if provided
        $assignedProject = null;
        if ($request->project_id) {
            $project = Project::with('client')->findOrFail($request->project_id);
            // Verify project belongs to the team
            if ($project->team_id === $team->id) {
                $project->members()->attach($newUser->id);
                $assignedProject = $project;
            }
        }

        // Send invitation email
        try {
            Mail::to($email)->send(new TeamInvitation(
                $newUser,
                $tempPassword,
                $team->name,
                0, // No budget in Atlassian model
                ucfirst($request->role),
                $assignedProject
            ));
        } catch (\Exception $e) {
            \Log::error('Failed to send team invitation email: ' . $e->getMessage());
        }

        return redirect()->back()->with('success', 'Team member invited! Email sent with login credentials.');
    }

    /**
     * Remove a team member and completely delete their account
     * When re-added, they will be a fresh new user
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

        // Don't allow deleting the team owner
        if ($user->id === $team->owner_id) {
            return redirect()->back()->with('error', 'Cannot remove the team owner.');
        }

        // Delete user's activities (chat messages)
        Activity::where('user_id', $user->id)->delete();

        // Unassign user's tasks (set assigned_to to null instead of deleting)
        Task::where('assigned_to_user_id', $user->id)
            ->update(['assigned_to_user_id' => null]);

        // Detach from all projects
        $user->projects()->detach();

        // Detach from all teams
        $user->teams()->detach();

        // Completely delete the user from the database
        $user->delete();

        return redirect()->back()->with('success', 'Member completely removed from the system.');
    }
}
