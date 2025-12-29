<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Client;
use App\Models\Activity;
use App\Models\Task; // Import Task model
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();

        // 1. Fetch Client List
        $sort = $request->get('sort', 'desc'); // Default to Newest
        $query = Client::with('latestActivity.user')
            ->orderBy('updated_at', $sort);

        if ($user->role !== 'super_admin') {
            $query->where('user_id', $user->id);
        }

        $updates = $query->get();

        // 2. Determine which client is selected
        if ($request->has('client_id')) {
            $check = Client::where('id', $request->client_id);
            if ($user->role !== 'super_admin') {
                $check->where('user_id', $user->id);
            }
            $selectedClient = $check->first();
        } else {
            $selectedClient = $updates->first();
        }

        // 3. Determine Active Tab (Default to 'activity')
        $tab = $request->get('tab', 'activity');

        // 4. Fetch Data based on Client
        $feed = collect();
        $clientTasks = collect();

        if ($selectedClient) {
            // Fetch Activity Feed
            $feed = Activity::where('client_id', $selectedClient->id)
                ->with('user')
                ->orderByDesc('created_at')
                ->get();

            // Fetch Tasks (Find tasks belonging to projects owned by this client)
            $clientTasks = Task::whereHas('project', function($q) use ($selectedClient) {
                $q->where('client_id', $selectedClient->id);
            })->with('project')->orderBy('due_date')->get();
        }

        return view('dashboard', compact('updates', 'selectedClient', 'feed', 'clientTasks', 'tab'));
    }

    public function storeActivity(Request $request)
    {
        $request->validate([
            'client_id' => 'required|exists:clients,id',
            'body' => 'required|string',
        ]);

        Activity::create([
            'user_id' => Auth::id(),
            'client_id' => $request->client_id,
            'type' => 'comment',
            'description' => 'posted a comment',
            'body' => $request->body,
        ]);

        // Redirect back ensuring we stay on the activity tab
        return redirect()->route('dashboard', ['client_id' => $request->client_id, 'tab' => 'activity'])
            ->with('success', 'Comment posted');
    }
}
