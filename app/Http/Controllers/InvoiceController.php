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
        $invoices = Invoice::where('user_id', Auth::id())
            ->with(['client', 'project'])
            ->latest()
            ->get();

        return view('invoices.index', compact('invoices'));
    }

    public function create()
    {
        $user = Auth::user();

        // FIX: If Super Admin, show ALL clients. Otherwise, show only MY clients.
        if ($user->role === 'super_admin') {
            $clients = Client::all();
            $projects = Project::all();
        } else {
            $clients = Client::where('user_id', $user->id)->get();
            $projects = Project::where('user_id', $user->id)->get();
        }

        // Generate Invoice Number
        $nextNumber = 'INV-' . strtoupper(Str::random(5));

        return view('invoices.create', compact('clients', 'projects', 'nextNumber'));
    }

    public function store(Request $request)
    {
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
        $invoice->user_id = Auth::id();
        $invoice->tax = $request->tax ?? 0;

        // Auto-calculate Total
        $invoice->total = $invoice->subtotal + $invoice->tax;

        $invoice->save();

        return redirect()->route('invoices.index')->with('success', 'Invoice created successfully.');
    }

    public function show($id)
    {
        $invoice = Invoice::where('user_id', Auth::id())
            ->with(['client', 'project'])
            ->findOrFail($id);

        return view('invoices.show', compact('invoice'));
    }
    public function edit($id)
    {
        $invoice = Invoice::where('user_id', Auth::id())->findOrFail($id);

        $user = Auth::user();
        if ($user->role === 'super_admin') {
            $clients = Client::all();
            $projects = Project::all();
        } else {
            $clients = Client::where('user_id', $user->id)->get();
            $projects = Project::where('user_id', $user->id)->get();
        }

        return view('invoices.edit', compact('invoice', 'clients', 'projects'));
    }

    public function update(Request $request, $id)
    {
        $invoice = Invoice::where('user_id', Auth::id())->findOrFail($id);

        $validated = $request->validate([
            'client_id' => 'required|exists:clients,id',
            'project_id' => 'nullable|exists:projects,id',
            // Ignore current invoice ID in unique check
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
}
