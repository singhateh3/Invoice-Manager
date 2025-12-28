<?php

namespace App\Http\Controllers;

use App\Http\Requests\InvoiceStoreRequest;
use App\Http\Requests\UpdateInvoiceRequest;
use App\Models\Invoice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Request as FacadesRequest;

class InvoiceController extends Controller
{

    public function index(){
        $invoice = Invoice::with('items')->where(
            'user_id', auth()->id())->latest()->paginate(10);
            return response()->json(['invoices'=>$invoice]);
    }

    public function store(InvoiceStoreRequest $request)
{
    $validated = $request->validated();

    $items = $validated['items'];
    unset($validated['items']);

    $subtotal = collect($items)->sum(fn ($item) =>
        $item['quantity'] * $item['price']
    );

    $discountRate = $validated['discount_rate'] ?? 0;
    $taxRate = $validated['tax_rate'] ?? 0;

    $discount = $subtotal * ($discountRate / 100);
    $tax = $subtotal * ($taxRate / 100);
    $total = $subtotal - $discount + $tax;

    $validated = array_merge($validated, [
        'user_id' => auth()->id(),
        'invoice_no' => 'INV-' . now()->timestamp,
        'invoice_date' => now(),
        'discount_rate' => $discountRate,
        'tax_rate' => $taxRate,
        'discount' => $discount,
        'tax' => $tax,
        'total' => $total,
    ]);

    $invoice = DB::transaction(function () use ($validated, $items) {
        $invoice = Invoice::create($validated);

        foreach ($items as $item) {
            $invoice->items()->create($item);
        }

        return $invoice;
    });

    return response()->json([
        'invoice' => $invoice->load('items'),
        'subtotal' => number_format($subtotal, 2, '.', ''),
        'discount_rate' => $discountRate,
        'tax_rate' => $taxRate,
        'discount' => number_format($discount, 2, '.', ''),
        'tax' => number_format($tax, 2, '.', ''),
        'total' => number_format($total, 2, '.', ''),
    ], 201);
}


public function show(Invoice $invoice)
{
    $invoice->load('items');

    return response()->json([
        'invoice' => $invoice,
        'subtotal' => number_format($invoice->subtotal, 2, '.', ''),
        'discount_rate' => $invoice->discount_rate,
        'tax_rate' => $invoice->tax_rate,
        'discount' => number_format($invoice->discount, 2, '.', ''),
        'tax' => number_format($invoice->tax, 2, '.', ''),
        'total' => number_format($invoice->total, 2, '.', ''),
    ], 200);
}

public function update(UpdateInvoiceRequest $request, Invoice $invoice)
{
    $validated = $request->validated();

    $items = $validated['items'];
    unset($validated['items']);

    $subtotal = collect($items)->sum(fn ($item) =>
        $item['quantity'] * $item['price']
    );

    $discountRate = $validated['discount_rate'] ?? 0;
    $taxRate = $validated['tax_rate'] ?? 0;

    $discount = $subtotal * ($discountRate / 100);
    $tax = $subtotal * ($taxRate / 100);
    $total = $subtotal - $discount + $tax;

    $validated = array_merge($validated, [
        'discount_rate' => $discountRate,
        'tax_rate' => $taxRate,
        'discount' => $discount,
        'tax' => $tax,
        'total' => $total,
    ]);

    $invoice = DB::transaction(function () use ($invoice, $validated, $items) {
        $invoice->update($validated);

        $invoice->items()->delete();
        foreach ($items as $item) {
            $invoice->items()->create($item);
        }

        return $invoice;
    });

    return response()->json([
        'invoice' => $invoice->load('items'),
        'subtotal' => number_format($subtotal, 2, '.', ''),
        'discount_rate' => $invoice->discount_rate,
        'tax_rate' => $invoice->tax_rate,
        'discount' => number_format($discount, 2, '.', ''),
        'tax' => number_format($tax, 2, '.', ''),
        'total' => number_format($total, 2, '.', ''),
    ], 200);
}

public function destroy(Invoice $invoice){
    $invoice->delete();
    return response()->json(['message'=>'Invoice deleted successfully'], 200);
}
}
