<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class EmployeeAttendance extends Model
{
    protected $fillable = [
        'user_id',
        'date',
        'check_in',
        'check_out',
        'total_hours',
        'break_time',
        'status',
        'notes',
        'location',
        'ip_address',
        'is_manual',
        'marked_by'
    ];

    protected $casts = [
        'date' => 'date',
        'check_in' => 'datetime',
        'check_out' => 'datetime',
        'is_manual' => 'boolean'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function markedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'marked_by');
    }

    public function getTotalHoursFormattedAttribute(): string
    {
        $hours = floor($this->total_hours / 60);
        $minutes = $this->total_hours % 60;
        return sprintf('%02d:%02d', $hours, $minutes);
    }
}
