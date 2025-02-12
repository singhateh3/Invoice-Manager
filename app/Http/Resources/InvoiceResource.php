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
            "user_id" => $this->user_id,
            'owner' => $this->whenLoaded('user'),
            "invoice_no" => $this->invoice_no,
            'company' => $this->whenLoaded('company'),
            'from' => $this->from,
            'from_address' => $this->from_address,
            'from_email' => $this->from_email,
            'from_phone' => $this->from_phone,
            'to' => $this->to,
            'to_address' => $this->to_address,
            'to_email' => $this->to_email,
            'to_phone' => $this->to_phone,
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
