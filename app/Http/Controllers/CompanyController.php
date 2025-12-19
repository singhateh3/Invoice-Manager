<?php

namespace App\Http\Controllers;

use App\Http\Requests\CompanyRequest;
use App\Http\Resources\CompanyResource;
use App\Http\Resources\CompanyResourceCollection;
use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CompanyController extends Controller
{
    public function index()
    {
        $invoices = Company::all();
        return response()->json(['message' => 'All Companies', 'Companies' => new CompanyResourceCollection($invoices)]);
    }

    public function store(CompanyRequest $request)
    {
        $validated = $request->validated();
        $company = Company::create($validated);
        return response()->json(['message' => 'Company created Successfully!', 'Company' => new CompanyResource($company)], 201);
    }



    public function show($id)
    {
        $company = Company::find($id);
        return response()->json(['Message' => 'Your Company', 'Company' => new CompanyResource($company)]);
    }

    public function update(CompanyRequest $request, $id)
    {
        $company = Company::find($id);
        $validated = $request->validated();

        $company->update($validated);
        return response()->json(['message' => 'Company updated successfully', 'Company' => new CompanyResource($company)], 201);
    }

    public function destroy($id)
    {
        $company = Company::find($id);
        $company->delete();

        return response()->json(['Message' => 'Company deleted successfully']);
    }
}
