<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class EmployeeLeave extends Model
{
    protected $fillable = [
        'user_id',
        'leave_type',
        'start_date',
        'end_date',
        'total_days',
        'reason',
        'status',
        'application_date',
        'approved_by',
        'approved_at',
        'rejection_reason',
        'admin_notes',
        'attachments',
        'is_half_day',
        'half_day_period',
        'emergency_contact'
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'application_date' => 'date',
        'approved_at' => 'datetime',
        'attachments' => 'array',
        'is_half_day' => 'boolean',
    ];

    /**
     * Get the user that owns the leave
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the user who approved the leave
     */
    public function approvedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    /**
     * Get the employee profile
     */
    public function employee(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
