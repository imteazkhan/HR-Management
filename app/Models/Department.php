<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Department extends Model
{
    protected $fillable = [
        'name',
        'description',
        'manager_id',
        'is_active',
        'max_employees',
        'location',
        'budget'
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    /**
     * Get the manager of the department
     */
    public function manager(): BelongsTo
    {
        return $this->belongsTo(User::class, 'manager_id');
    }

    /**
     * Get all employees in this department
     */
    public function employees(): HasMany
    {
        return $this->hasMany(User::class, 'department_id');
    }

    /**
     * Get the employee count for this department
     */
    public function getEmployeeCountAttribute(): int
    {
        return $this->employees()->count();
    }

    /**
     * Get active departments
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}
