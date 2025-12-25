<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Client;
use App\Models\Activity;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $userId = Auth::id();

        // 1. Fetch the Client List for the Left Pane ($updates)
        // We use 'with' to eagerly load the latest activity to avoid N+1 queries
        $updates = Client::where('user_id', $userId)
            ->with('latestActivity.user') // Load the user who performed the activity
            ->orderByDesc('updated_at')
            ->get();

        // 2. Determine which client is selected (Center/Right Panes)
        // If ?client_id=5 is in the URL, use that. Otherwise, default to the first one.
        $selectedClient = $request->has('client_id')
            ? Client::where('id', $request->client_id)->where('user_id', $userId)->first()
            : $updates->first();

        // 3. Fetch the Activity Feed ($feed)
        $feed = collect();
        if ($selectedClient) {
            $feed = Activity::where('client_id', $selectedClient->id)
                ->with('user') // Load the user name for the feed
                ->orderByDesc('created_at')
                ->get();
        }

        // Return the view WITH the variables
        return view('dashboard', compact('updates', 'selectedClient', 'feed'));
    }
}
