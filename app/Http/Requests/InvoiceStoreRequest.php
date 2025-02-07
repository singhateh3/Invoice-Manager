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
            'company_id' => 'required',
            'name' => 'required',
            'address' => 'required',
            'email' => 'required',
            'phone' => 'required',
            'item' => 'required',
            'description' => 'required',
            'quantity' => 'required',
            'price' => 'required',
            'tax' => 'required',
            'discount' => 'required',
            'invoice_date' => 'required',
            'due_date' => 'date',
            'note' => 'string',
            'terms' => 'string',
            'ship_to' => 'string',
        ];
    }
}
