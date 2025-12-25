<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class InvoiceController extends Controller
{
    public function index()
    {
        $invoices = Invoice::where('user_id', Auth::id())
            ->with('client')
            ->orderByDesc('created_at')
            ->get();

        return view('invoices.index', compact('invoices'));
    }

    public function create() { return view('invoices.create'); }
}
