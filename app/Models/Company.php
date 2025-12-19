<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Company extends Model
{
    use HasFactory;

<<<<<<< HEAD
    // protected $fillable = [
    //     'user_id',
    //     'name',
    //     'address',
    //     'email'
    // ];

    // public function invoices(): HasMany
    // {
    //     return $this->hasMany(Invoice::class);
    // }

    // public function user(): BelongsTo
    // {
    //     return $this->belongsTo(User::class);
    // }
=======
    protected $fillable = [
        'user_id',
        'name',
        'address',
        'email'
    ];

    public function invoices(): HasMany
    {
        return $this->hasMany(Invoice::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
>>>>>>> 74530e6d76c15b465949f28fddf9fb212adaf1bd
}
