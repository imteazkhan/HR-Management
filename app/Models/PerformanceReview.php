<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PerformanceReview extends Model
{
    protected $fillable = [
        'employee_id',
        'reviewer_id',
        'score',
        'completed_tasks',
        'on_time_rate',
        'rating',
        'comments',
        'review_period_start',
        'review_period_end',
        'status'
    ];

    protected $casts = [
        'on_time_rate' => 'decimal:2',
        'review_period_start' => 'date',
        'review_period_end' => 'date'
    ];

    /**
     * Get the employee being reviewed
     */
    public function employee(): BelongsTo
    {
        return $this->belongsTo(User::class, 'employee_id');
    }

    /**
     * Get the reviewer
     */
    public function reviewer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'reviewer_id');
    }

    /**
     * Scope for completed reviews
     */
    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }

    /**
     * Scope for reviews by a specific reviewer
     */
    public function scopeByReviewer($query, $reviewerId)
    {
        return $query->where('reviewer_id', $reviewerId);
    }

    /**
     * Get the performance percentage
     */
    public function getPerformancePercentageAttribute()
    {
        return $this->score ?? 0;
    }

    /**
     * Get badge class for rating
     */
    public function getRatingBadgeClassAttribute()
    {
        return match($this->rating) {
            'outstanding' => 'bg-success',
            'excellent' => 'bg-primary',
            'good' => 'bg-info',
            'satisfactory' => 'bg-warning',
            'needs_improvement' => 'bg-danger',
            default => 'bg-secondary'
        };
    }
}
