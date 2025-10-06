<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OfficeLoan extends Model
{
    protected $fillable = [
        'user_id',
        'amount',
        'application_date',
        'repayment_term',
        'interest_rate',
        'status',
        'purpose',
        'notes'
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'interest_rate' => 'decimal:2',
        'application_date' => 'date'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}