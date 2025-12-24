<?php

namespace App\Http\Controllers;

use App\Http\Requests\InvoiceStoreRequest;
use App\Models\Invoice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Request as FacadesRequest;

class InvoiceController extends Controller
{

    public function index(){
        $invoice = Invoice::with('items')->where(
            'user_id', auth()->id())->latest()->get();
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

    unset($validated['discount_rate'], $validated['tax_rate']);

    $discount = $subtotal * ($discountRate / 100);
    $tax = $subtotal * ($taxRate / 100);
    $total = $subtotal -$discount + $tax;

    $validated = array_merge($validated, [
        'user_id' => auth()->id(),
        'invoice_no' => 'INV-' . now()->timestamp,
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
        'subtotal' => $invoice->subtotal,
        'discount' => number_format($discount, 2, '.', ''),
        'tax' => number_format($tax, 2, '.', ''),
        'total' => number_format($total, 2, '.', ''),
    ], 201);
}

public function show(Invoice $invoice){

    $invoice->load('items');
    $subtotal = $invoice->items->sum(fn ($item)=>
    $item->quantity * $item->price
    );

    $discount = $invoice->discount ?? 0;
    $tax = $invoice->tax ?? 0;
    $total = $subtotal - $discount + $tax;

    return response()->json([
        'invoice' => $invoice->load('items'),
        'subtotal' => $invoice->subtotal,
        'discount' => $discount,
        'tax' => $tax,
        'total' => $invoice->total,
    ], 200);

}

}
