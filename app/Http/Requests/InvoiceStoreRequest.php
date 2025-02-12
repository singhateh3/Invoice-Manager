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
    }
}
