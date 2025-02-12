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

class InvoiceController extends Controller
{
    // All invoices with associated users and companies
    public function index()
    {
        $invoices = Invoice::with('user', 'company')->get();
        return response()->json(['message' => 'All Invoices', 'Invoices' => new InvoiceResourceCollection($invoices)]);
    }
    // create a new invoice
    public function store(InvoiceStoreRequest $request)
    {
        $validated = $request->validated();
        $validated['user_id'] = Auth::id();
        $invoice = Invoice::create($validated);
        return response()->json([
            'message' => 'invoice creation successful',
            'Invoice' =>  new InvoiceResource($invoice)
        ], 201);
    }


    // view invoice using route model binding
    public function show(Invoice $invoice)
    {
        return response()->json(['Message' => 'Your Invoice', 'Invoice' => new InvoiceResource($invoice)]);
    }

    // update invoice
    public function update(InvoiceStoreRequest $request, $id)
    {
        $invoice = Invoice::find($id);
        $validated = $request->validated();

        $invoice->update($validated);
        return response()->json(['message' => 'Invoice updated successfully', 'Invoice' => new InvoiceResource($invoice)], 201);
    }

    // delete invoice
    public function destroy($id)
    {
        $invoice = Invoice::find($id);
        $invoice->delete();

        return response()->json(['Message' => 'Invoice deleted successfully']);
    }

    // user fetch all his invices
    public function myInvoices()
    {
        $user = AuthSession::getUser();
        $invoices = Invoice::where('user_id', $user->id)->with('company', 'user')->get();
        return response()->json(['message' => 'Your Invoices', 'Invoices' =>
        new InvoiceResourceCollection($invoices)]);
    }


    // Create invoice in guest mode
    public function GuestInvoice(InvoiceStoreRequest $request)
    {
        $validated = $request->validated();
        Invoice::create($validated);
        return response()->json([
            'message' => 'invoice creation successful',
        ], 201);
    }

    // Invoices from the same company
    public function companyInvoices($id)
    {
        $company = Company::find($id);
        $invoice = Invoice::where('company_id', $company->id)->get();
        return response()->json(['message' => 'Invoice associated with this company', 'invoices' => new InvoiceResourceCollection($invoice)], 201);
    }
}
