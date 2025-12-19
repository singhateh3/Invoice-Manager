<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InvoiceItem extends Model
{
    use HasFactory;
    protected $fillable = [
        'invoice_id', 'description', 'price', 'quantity', 'item'
    ];

    public function invoice(){
        return $this->belongsTo(Invoice::class);
    }

    public function getAmountAttribute(){
        return $this->quantity *$this->price;
    }
}
