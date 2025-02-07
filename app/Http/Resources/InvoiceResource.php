<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class InvoiceResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'company' => $this->company()->latest()->first(),
            'name' => $this->name,
            'address' => $this->address,
            'email' => $this->email,
            'phone' => $this->phone,
            'item' => $this->item,
            'description' => $this->description,
            'quantity' => $this->quantity,
            'price' => $this->price,
            'discount' => $this->discount,
            'tax' => $this->tax,
            'invoice_date' => $this->invoice_date,
            'due_date' => $this->due_date,
            'note' => $this->note,
            'terms' => $this->terms,
        ];
    }
}
