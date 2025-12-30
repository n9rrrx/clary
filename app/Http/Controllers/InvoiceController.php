<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\Client;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class InvoiceController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $team = $user->currentTeam;

        $query = Invoice::with(['client', 'project'])->latest();

        // Scope to current team
        if ($team) {
            $query->where('team_id', $team->id);
        }

        $invoices = $query->get();

        return view('invoices.index', compact('invoices'));
    }

    public function create()
    {
        $user = Auth::user();
        $team = $user->currentTeam;

        // Only owners can create invoices
        if (!$user->isOwnerOfCurrentTeam()) {
            abort(403, 'Only team owners can create invoices.');
        }

        $clients = $team ? Client::where('team_id', $team->id)->get() : collect();
        $projects = $team ? Project::where('team_id', $team->id)->get() : collect();

        $nextNumber = 'INV-' . strtoupper(Str::random(5));

        return view('invoices.create', compact('clients', 'projects', 'nextNumber'));
    }

    public function store(Request $request)
    {
        $user = Auth::user();
        $team = $user->currentTeam;

        if (!$user->isOwnerOfCurrentTeam()) {
            abort(403);
        }

        $validated = $request->validate([
            'client_id' => 'required|exists:clients,id',
            'project_id' => 'nullable|exists:projects,id',
            'invoice_number' => 'required|string|unique:invoices,invoice_number',
            'issue_date' => 'required|date',
            'due_date' => 'required|date|after_or_equal:issue_date',
            'subtotal' => 'required|numeric|min:0',
            'tax' => 'nullable|numeric|min:0',
            'status' => 'required|in:draft,sent,paid,overdue,cancelled',
            'notes' => 'nullable|string',
        ]);

        $invoice = new Invoice($validated);
        $invoice->team_id = $team?->id;
        $invoice->tax = $request->tax ?? 0;
        $invoice->total = $invoice->subtotal + $invoice->tax;

        $invoice->save();

        return redirect()->route('invoices.index')->with('success', 'Invoice created successfully.');
    }

    public function show($id)
    {
        $user = Auth::user();
        $team = $user->currentTeam;

        $query = Invoice::with(['client', 'project']);

        if ($team) {
            $query->where('team_id', $team->id);
        }

        $invoice = $query->findOrFail($id);

        return view('invoices.show', compact('invoice'));
    }

    public function edit($id)
    {
        $user = Auth::user();
        $team = $user->currentTeam;

        if (!$user->isOwnerOfCurrentTeam()) {
            abort(403);
        }

        $query = Invoice::query();

        if ($team) {
            $query->where('team_id', $team->id);
        }

        $invoice = $query->findOrFail($id);

        $clients = $team ? Client::where('team_id', $team->id)->get() : collect();
        $projects = $team ? Project::where('team_id', $team->id)->get() : collect();

        return view('invoices.edit', compact('invoice', 'clients', 'projects'));
    }

    public function update(Request $request, $id)
    {
        $user = Auth::user();
        $team = $user->currentTeam;

        if (!$user->isOwnerOfCurrentTeam()) {
            abort(403);
        }

        $query = Invoice::query();
        if ($team) {
            $query->where('team_id', $team->id);
        }

        $invoice = $query->findOrFail($id);

        $validated = $request->validate([
            'client_id' => 'required|exists:clients,id',
            'project_id' => 'nullable|exists:projects,id',
            'invoice_number' => 'required|string|unique:invoices,invoice_number,' . $invoice->id,
            'issue_date' => 'required|date',
            'due_date' => 'required|date|after_or_equal:issue_date',
            'subtotal' => 'required|numeric|min:0',
            'tax' => 'nullable|numeric|min:0',
            'status' => 'required|in:draft,sent,paid,overdue,cancelled',
            'notes' => 'nullable|string',
        ]);

        $invoice->fill($validated);
        $invoice->tax = $request->tax ?? 0;
        $invoice->total = $invoice->subtotal + $invoice->tax;
        $invoice->save();

        return redirect()->route('invoices.show', $invoice->id)->with('success', 'Invoice updated successfully.');
    }

    public function destroy($id)
    {
        $user = Auth::user();
        $team = $user->currentTeam;

        if (!$user->isOwnerOfCurrentTeam()) {
            abort(403);
        }

        $query = Invoice::query();
        if ($team) {
            $query->where('team_id', $team->id);
        }

        $invoice = $query->findOrFail($id);
        $invoice->delete();

        return redirect()->route('invoices.index')->with('success', 'Invoice deleted successfully.');
    }
}
