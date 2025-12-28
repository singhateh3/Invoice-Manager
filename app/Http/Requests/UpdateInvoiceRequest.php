<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateInvoiceRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
         return [
        'company_name' => 'required|string',
        'company_address' => 'nullable|string',
        'customer_name' => 'required|string',
        'customer_address' => 'nullable|string',
        'invoice_date' => 'required|date',
        'due_date' => 'nullable|date|after_or_equal:invoice_date',

        'items' => 'required|array|min:1',
        'items.*.item' => 'required|string',
        'items.*.description' => 'nullable|string',
        'items.*.quantity' => 'required|numeric|min:1',
        'items.*.price' => 'required|numeric|min:0',

        'discount_rate' => 'nullable|numeric|min:0|max:100',
        'tax_rate' => 'nullable|numeric|min:0|max:100',
    ];
    }
}
