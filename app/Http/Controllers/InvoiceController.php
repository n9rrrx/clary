<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\Client;
use App\Models\Project;
use App\Mail\InvoiceMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Barryvdh\DomPDF\Facade\Pdf;

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
        $invoice->user_id = $user->id;
        $invoice->team_id = $team?->id;
        $invoice->reference_number = $validated['invoice_number']; // Required field from original migration
        $invoice->amount = $validated['subtotal']; // Required field from original migration
        $invoice->tax = $request->tax ?? 0;
        $invoice->total = $invoice->subtotal + $invoice->tax;

        $invoice->save();

        // Send email to client if status is 'sent'
        if ($invoice->status === 'sent') {
            $invoice->load(['client', 'project']);
            if ($invoice->client && $invoice->client->email) {
                try {
                    // Generate PDF
                    $pdf = Pdf::loadView('invoices.pdf', [
                        'invoice' => $invoice,
                        'sender' => $user,
                    ]);

                    // Send email with PDF attachment
                    Mail::to($invoice->client->email)->send(
                        (new InvoiceMail($invoice, $user))->attachData(
                            $pdf->output(),
                            "invoice-{$invoice->invoice_number}.pdf",
                            ['mime' => 'application/pdf']
                        )
                    );

                    return redirect()->route('invoices.index')->with('success', 'Invoice created and sent to ' . $invoice->client->email . ' with PDF attachment.');
                } catch (\Exception $e) {
                    \Log::error('Failed to send invoice email: ' . $e->getMessage());
                    return redirect()->route('invoices.index')->with('warning', 'Invoice created but email failed to send: ' . $e->getMessage());
                }
            }
        }

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
        $invoice->reference_number = $validated['invoice_number']; // Keep in sync
        $invoice->amount = $validated['subtotal']; // Keep in sync
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

    /**
     * Public invoice view (no login required, uses signed URL)
     */
    public function publicShow(Invoice $invoice)
    {
        $invoice->load(['client', 'project']);

        return view('invoices.public', compact('invoice'));
    }

    /**
     * Generate PDF for an invoice
     */
    public function generatePdf(Invoice $invoice)
    {
        $invoice->load(['client', 'project']);
        $sender = Auth::user();

        $pdf = Pdf::loadView('invoices.pdf', [
            'invoice' => $invoice,
            'sender' => $sender,
        ]);

        return $pdf;
    }

    /**
     * Download invoice as PDF
     */
    public function downloadPdf(Invoice $invoice)
    {
        $user = Auth::user();
        $team = $user->currentTeam;

        // Verify invoice belongs to this team
        if ($team && $invoice->team_id !== $team->id) {
            abort(404);
        }

        $pdf = $this->generatePdf($invoice);

        return $pdf->download("invoice-{$invoice->invoice_number}.pdf");
    }

    /**
     * Send/Resend invoice email to client
     */
    public function sendEmail(Invoice $invoice)
    {
        $user = Auth::user();
        $team = $user->currentTeam;

        if (!$user->isOwnerOfCurrentTeam()) {
            abort(403);
        }

        // Verify invoice belongs to this team
        if ($team && $invoice->team_id !== $team->id) {
            abort(404);
        }

        $invoice->load(['client', 'project']);

        if (!$invoice->client || !$invoice->client->email) {
            return redirect()->back()->with('error', 'Client email is missing.');
        }

        try {
            // Generate PDF
            $pdf = Pdf::loadView('invoices.pdf', [
                'invoice' => $invoice,
                'sender' => $user,
            ]);

            // Send email with PDF attachment
            Mail::to($invoice->client->email)->send(
                (new InvoiceMail($invoice, $user))->attachData(
                    $pdf->output(),
                    "invoice-{$invoice->invoice_number}.pdf",
                    ['mime' => 'application/pdf']
                )
            );

            // Update status to sent if it was draft
            if ($invoice->status === 'draft') {
                $invoice->status = 'sent';
                $invoice->save();
            }

            return redirect()->back()->with('success', 'Invoice sent to ' . $invoice->client->email . ' with PDF attachment.');
        } catch (\Exception $e) {
            \Log::error('Failed to send invoice email: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Failed to send email: ' . $e->getMessage());
        }
    }
}
