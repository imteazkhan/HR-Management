<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Payroll extends Model
{
    protected $fillable = [
        'user_id',
        'employee_name',
        'position',
        'base_salary',
        'bonuses',
        'deductions',
        'net_salary',
        'month',
        'status',
        'notes'
    ];

    protected $casts = [
        'base_salary' => 'decimal:2',
        'bonuses' => 'decimal:2',
        'deductions' => 'decimal:2',
        'net_salary' => 'decimal:2',
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];

    /**
     * Get the user that owns the payroll record.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}