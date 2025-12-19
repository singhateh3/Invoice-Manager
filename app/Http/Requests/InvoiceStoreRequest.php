<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class InvoiceStoreRequest extends FormRequest
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
<<<<<<< HEAD
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
    ];
=======
            'invoice_no' => 'required',
            'from' => 'required',
            'from_address' => 'nullable',
            'from_email' => 'nullable',
            'from_phone' => 'nullable',
            'company_id' => 'nullable',
            'to' => 'required',
            'to_address' => 'nullable',
            'to_email' => 'nullable',
            'to_phone' => 'nullable',
            'item' => 'required',
            'description' => 'nullable',
            'quantity' => 'required',
            'price' => 'required',
            'tax' => 'nullable',
            'discount' => 'nullable',
            'invoice_date' => 'required',
            'due_date' => ['date', 'nullable'],
            'note' => 'nullable',
            'terms' => ['string', 'nullable'],
            'ship_to' => ['string', 'nullable'],
        ];
>>>>>>> 74530e6d76c15b465949f28fddf9fb212adaf1bd
    }
}
