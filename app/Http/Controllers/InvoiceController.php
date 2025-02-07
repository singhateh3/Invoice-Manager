<?php

namespace App\Http\Controllers;

use App\Http\Requests\InvoiceStoreRequest;
use App\Http\Resources\InvoiceResource;
use App\Http\Resources\InvoiceResourceCollection;
use App\Models\Company;
use App\Models\Invoice;
use Illuminate\Http\Request;

class InvoiceController extends Controller
{
    public function store(InvoiceStoreRequest $request)
    {
        $validated = $request->validated();
        $invoice = Invoice::create($validated);
        return response()->json([
            'message' => 'invoice creation successful',
            'Invoice' =>  new InvoiceResource($invoice)
        ], 201);
    }

    public function index()
    {
        $invoices = Invoice::all();
        return response()->json(['message' => 'All Invoices', 'Invoices' => new InvoiceResourceCollection($invoices)]);
    }

    public function show($id)
    {
        $invoice = Invoice::find($id);
        return response()->json(['Message' => 'Your Invoice', 'Invoice' => new InvoiceResource($invoice)]);
    }

    public function update(InvoiceStoreRequest $request, $id)
    {
        $invoice = Invoice::find($id);
        $validated = $request->validated();

        $invoice->update($validated);
        return response()->json(['message' => 'Invoice updated successfully', 'Invoice' => new InvoiceResource($invoice)], 201);
    }

    public function destroy($id)
    {
        $invoice = Invoice::find($id);
        $invoice->delete();

        return response()->json(['Message' => 'Invoice deleted successfully']);
    }

    public function GuestInvoice(InvoiceStoreRequest $request)
    {
        $validated = $request->validated();
        Invoice::create($validated);
        return response()->json([
            'message' => 'invoice creation successful',
        ], 201);
    }
}
