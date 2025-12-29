<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Activity;
use App\Models\Client;
use App\Models\Project;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{
    // 1. CLIENT FETCH
    public function clientFetch(Request $request, Project $project)
    {
        $user = Auth::user();
        $clientProfile = Client::where('email', $user->email)->first();

        if (!$clientProfile || $project->client_id !== $clientProfile->id) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        // Just fetch data. No marking as read.
        return $this->getComments($clientProfile->id, $user->id);
    }

    // 2. ADMIN FETCH
    public function adminFetch(Request $request, Client $client)
    {
        $user = Auth::user();
        if (!in_array($user->role, ['admin', 'super_admin'])) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        return $this->getComments($client->id, $user->id);
    }

    // SHARED LOGIC
    private function getComments($clientId, $viewerId)
    {
        $activities = Activity::where('client_id', $clientId)
            ->with('user') // We only need the author info
            ->orderBy('created_at', 'asc')
            ->get();

        return response()->json([
            'activities' => $activities->map(function($activity) use ($viewerId) {
                return [
                    'id' => $activity->id,
                    'body' => $activity->body,
                    'is_mine' => $activity->user_id === $viewerId,
                    'user_name' => $activity->user->name,
                    'role' => $activity->user->role, // Useful for styling badges (e.g. "Admin")
                    'initial' => substr($activity->user->name, 0, 1),
                    'time' => $activity->created_at->format('M d, g:i A'), // "Dec 30, 2:30 PM"
                    // No status field needed anymore
                ];
            })
        ]);
    }
}
