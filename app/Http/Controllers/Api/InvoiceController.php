<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Invoice;
use Illuminate\Http\Request;

class InvoiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $invoices = Invoice::with(['client', 'project'])->paginate(15);
        return response()->json($invoices);
    }

    /**
     * Store a newly created resource in storage.
     */
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
            'total' => 'required|numeric|min:0',
            'notes' => 'nullable|string',
            'status' => 'nullable|in:draft,sent,paid,overdue,cancelled',
        ]);

        $invoice = Invoice::create($validated);
        return response()->json($invoice->load(['client', 'project']), 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Invoice $invoice)
    {
        return response()->json($invoice->load(['client', 'project']));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Invoice $invoice)
    {
        $validated = $request->validate([
            'client_id' => 'sometimes|required|exists:clients,id',
            'project_id' => 'nullable|exists:projects,id',
            'invoice_number' => 'sometimes|required|string|unique:invoices,invoice_number,' . $invoice->id,
            'issue_date' => 'sometimes|required|date',
            'due_date' => 'sometimes|required|date|after_or_equal:issue_date',
            'subtotal' => 'sometimes|required|numeric|min:0',
            'tax' => 'nullable|numeric|min:0',
            'total' => 'sometimes|required|numeric|min:0',
            'notes' => 'nullable|string',
            'status' => 'nullable|in:draft,sent,paid,overdue,cancelled',
        ]);

        $invoice->update($validated);
        return response()->json($invoice->load(['client', 'project']));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Invoice $invoice)
    {
        $invoice->delete();
        return response()->json(null, 204);
    }
}
