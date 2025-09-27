<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class EmployeeProfile extends Model
{
    protected $fillable = [
        'user_id',
        'employee_id',
        'first_name',
        'last_name',
        'phone',
        'emergency_contact',
        'address',
        'date_of_birth',
        'gender',
        'marital_status',
        'nationality',
        'joining_date',
        'salary',
        'bank_account',
        'tax_id',
        'profile_picture',
        'documents',
        'employment_type',
        'status'
    ];

    protected $casts = [
        'date_of_birth' => 'date',
        'joining_date' => 'date',
        'salary' => 'decimal:2',
        'documents' => 'array'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function getFullNameAttribute(): string
    {
        return $this->first_name . ' ' . $this->last_name;
    }
}
