<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Invoice extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'invoice_date' => 'date',
        'due_date' => 'date',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function items()
    {
        return $this->hasMany(InvoiceItem::class);
    }

    public function getSubtotalAttribute()
    {
        return $this->items->sum(fn ($item) => $item->quantity * $item->price);
    }

    // Total after discount and tax
    public function getTotalAttribute()
    {
        $discountAmount = $this->discount ?? 0;
        $taxAmount = $this->tax ?? 0;
        return $this->subtotal - $discountAmount + $taxAmount;
    }


}
