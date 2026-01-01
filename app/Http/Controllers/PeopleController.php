<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Team;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PeopleController extends Controller
{
    /**
     * Display all people with filtering and sorting
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        $team = $user->currentTeam;
        
        if (!$team) {
            return redirect()->route('dashboard')->with('error', 'No team found.');
        }

        // Get filter parameters
        $tagFilter = $request->get('tag');
        $sortBy = $request->get('sort', 'all'); // 'all' or 'by_team'
        
        // Get all team members (not owner)
        $members = $team->members()
            ->where('user_id', '!=', $team->owner_id)
            ->get();

        // Filter by tag if provided
        if ($tagFilter) {
            $members = $members->filter(function ($member) use ($tagFilter) {
                $memberTags = is_string($member->tags) ? json_decode($member->tags, true) : ($member->tags ?? []);
                if (!is_array($memberTags)) return false;
                
                // Check if any tag contains the filter (for "Developer" to match both Backend/Frontend)
                foreach ($memberTags as $tag) {
                    if (stripos($tag, $tagFilter) !== false) {
                        return true;
                    }
                }
                return false;
            });
        }

        // Calculate tag counts for sidebar (count unique people per category)
        $tagCounts = [
            'Developer' => 0,
            'Designer' => 0,
            'Project Manager' => 0,
            'Viewer Only' => 0,
            'HR Only' => 0,
        ];
        
        foreach ($team->members()->where('user_id', '!=', $team->owner_id)->get() as $member) {
            $memberTags = is_string($member->tags) ? json_decode($member->tags, true) : ($member->tags ?? []);
            if (is_array($memberTags)) {
                $tagString = implode(' ', $memberTags);
                
                // Count each person once per category
                if (stripos($tagString, 'Developer') !== false) {
                    $tagCounts['Developer']++;
                }
                if (stripos($tagString, 'Designer') !== false) {
                    $tagCounts['Designer']++;
                }
                if (stripos($tagString, 'Project Manager') !== false) {
                    $tagCounts['Project Manager']++;
                }
                if (stripos($tagString, 'Viewer') !== false) {
                    $tagCounts['Viewer Only']++;
                }
                if (stripos($tagString, 'HR') !== false) {
                    $tagCounts['HR Only']++;
                }
            }
        }

        return view('people.index', compact('members', 'team', 'tagFilter', 'sortBy', 'tagCounts'));
    }
}
