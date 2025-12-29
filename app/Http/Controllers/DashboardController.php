<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Client;
use App\Models\Activity;
use App\Models\Task;
use App\Models\Invoice;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();

        // =========================================================
        // 1. CLIENT PORTAL LOGIC (For users like "him")
        // =========================================================
        if ($user->role === 'user') {
            $clientProfile = Client::where('email', $user->email)->first();

            $invoices = $clientProfile
                ? Invoice::where('client_id', $clientProfile->id)->orderByDesc('issue_date')->get()
                : collect();

            $projects = $clientProfile
                ? \App\Models\Project::where('client_id', $clientProfile->id)
                    ->with('tasks')
                    ->orderByDesc('updated_at')
                    ->get()
                : collect();

            return view('dashboard.client_view', compact('invoices', 'clientProfile', 'projects'));
        }

        // =========================================================
        // 2. AGENCY / ADMIN DASHBOARD LOGIC (For You)
        // =========================================================

        // Fetch Client List
        $sort = $request->get('sort', 'desc');
        $query = Client::with('latestActivity.user')->orderBy('updated_at', $sort);

        if ($user->role !== 'super_admin') {
            $query->where('user_id', $user->id);
        }

        $updates = $query->get();

        // Determine Selected Client
        if ($request->has('client_id')) {
            $check = Client::where('id', $request->client_id);
            if ($user->role !== 'super_admin') {
                $check->where('user_id', $user->id);
            }
            $selectedClient = $check->first();
        } else {
            $selectedClient = $updates->first();
        }

        // Determine Active Tab
        $tab = $request->get('tab', 'activity');

        // Fetch Feed & Tasks
        $feed = collect();
        $clientTasks = collect();

        if ($selectedClient) {
            // === NEW: MARK MESSAGES AS SEEN ===
            // When Admin views this client, mark client's unread messages as READ
            Activity::where('client_id', $selectedClient->id)
                ->where('user_id', '!=', Auth::id()) // Messages from the client
                ->whereNull('read_at')
                ->update(['read_at' => now()]);
            // ==================================

            $feed = Activity::where('client_id', $selectedClient->id)
                ->with('user')
                ->orderByDesc('created_at')
                ->get();

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

        // FIX: If the request comes from JavaScript, return JSON instead of reloading page
        if ($request->wantsJson()) {
            return response()->json(['status' => 'success']);
        }

        return redirect()->route('dashboard', ['client_id' => $request->client_id, 'tab' => 'activity'])
            ->with('success', 'Comment posted');
    }
}
