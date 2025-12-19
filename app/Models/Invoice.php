<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Invoice extends Model
{
    use HasFactory;

    protected  $fillable = [
        'user_id',
        'invoice_no',
        'company_name',
        'company_address',
        'invoice_date',
        'due_date',
        'customer_name',
        'customer_address',
        'discount',
        'tax',
        'terms',
        'ship_to',
        'items',
        'total'
    ];

    // public function company(): BelongsTo
    // {
    //     return $this->belongsTo(Company::class);
    // }
    protected $casts = [
        'invoice_date'=> 'date',
        'due_date'=>'date',
    ];
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function items(){
        return $this-> hasMany(InvoiceItem::class);
    }

    public function getSubTotalAttribute (){
        return $this->items->sum(fn($item)=>$item->quantity * $item->price);
    }

    public function getTotalAttribute(){
        return $this->subtotal - $this->discount + $this->tax;
    }
}
