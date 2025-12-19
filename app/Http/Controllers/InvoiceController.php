<?php

namespace App\Http\Controllers;

use App\Http\Requests\InvoiceStoreRequest;
use App\Http\Resources\InvoiceResource;
use App\Http\Resources\InvoiceResourceCollection;
use App\Models\Company;
use App\Models\Invoice;
use App\Models\User;
use AuthSession;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class InvoiceController extends Controller
{

public function store(Request $request)
{
    // dd($request->all());
  $validated =  $request->validate([
        'company_name' => 'required|string',
        'customer_name' => 'required|string',
        'invoice_date' => 'required|date',
        'due_date' => 'nullable|date|after_or_equal:invoice_date',
        'items' => 'required|array|min:1',
        'items.*.item' => 'required|string',
        'items.*.quantity' => 'required|numeric|min:1',
        'items.*.price' => 'required|numeric|min:0',
        'discount' => 'nullable|numeric|min:0',
        'tax' => 'nullable|numeric|min:0',
    ]);

    // Wrap in transaction
    DB::beginTransaction();
    try {
        $invoice = Invoice::create([
            'user_id' => auth()->id(),
            'invoice_no' => 'INV-' . now()->timestamp,
            'company_name' => $request->company_name,
            'company_address' => $request->company_address,
            'customer_name' => $request->customer_name,
            'customer_address' => $request->customer_address,
            'discount' => $request->discount ?? 0,
            'tax' => $request->tax ?? 0,
            'invoice_date' => $request->invoice_date,
            'due_date' => $request->due_date,
            'note' => $request->note,
            'terms' => $request->terms,
            'ship_to' => $request->ship_to,
        ]);

        echo print_r($request->all());
        Log::info($request->all());
        // dd(auth()->id());
        // Save invoice items
        foreach ($request->items as $item) {
            $invoice->items()->create([
                'item' => $item['item'],
                'description' => $item['description'] ?? null,
                'quantity' => $item['quantity'],
                'price' => $item['price'],
            ]);
        }


        DB::commit();

        // Return invoice with items and totals
        $invoice->load('items');
        return response()->json([
            'invoice' => $invoice,
            'subtotal' => $invoice->subtotal,
            'total' => $invoice->total,
        ], 201);

    } catch (\Exception $e) {
        DB::rollBack();
        return response()->json(['error' => $e->getMessage()], 500);
    }
}
}
