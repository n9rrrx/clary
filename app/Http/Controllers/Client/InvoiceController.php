<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Invoice;
use Illuminate\Support\Facades\Auth;

class InvoiceController extends Controller
{
    public function show(Invoice $invoice)
    {
        // 1. Get the Client profile linked to the logged-in User
        // This uses the 'public function client()' relationship you just added to User.php
        $userClient = Auth::user()->client;

        // 2. SECURITY: Check if the user is a client AND if they own this specific invoice
        // We cast to (int) to ensure a strict ID match
        if (!$userClient || (int)$invoice->client_id !== (int)$userClient->id) {
            abort(403, 'Unauthorized access to this invoice.');
        }

        // 3. Return the separate Client View
        // Double check your folder structure: if the file is at
        // resources/views/client/invoices/show.blade.php, use 'client.invoices.show'
        return view('client.invoices.show', compact('invoice'));
    }
}
