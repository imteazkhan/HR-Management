<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'department_id',
        'designation_id',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Check if user has a specific role.
     */
    public function hasRole(string $role): bool
    {
        return $this->role === $role;
    }

    /**
     * Check if user is a superadmin.
     */
    public function isSuperAdmin(): bool
    {
        return $this->hasRole('superadmin');
    }

    /**
     * Check if user is a manager.
     */
    public function isManager(): bool
    {
        return $this->hasRole('manager');
    }

    /**
     * Check if user is an employee.
     */
    public function isEmployee(): bool
    {
        return $this->hasRole('employee');
    }

    /**
     * Get the dashboard route based on user role.
     */
    public function getDashboardRoute(): string
    {
        return match($this->role) {
            'superadmin' => 'superadmin.dashboard',
            'manager' => 'manager.dashboard',
            'employee' => 'employee.dashboard',
            default => 'home',
        };
    }

    /**
     * Messages sent by this user
     */
    public function sentMessages()
    {
        return $this->hasMany(Message::class, 'from_user_id');
    }

    /**
     * Messages received by this user
     */
    public function receivedMessages()
    {
        return $this->hasMany(Message::class, 'to_user_id');
    }

    /**
     * Notifications for this user
     */
    public function notifications()
    {
        return $this->hasMany(Notification::class);
    }

    /**
     * Manager settings for this user
     */
    public function managerSettings()
    {
        return $this->hasOne(ManagerSetting::class);
    }

    /**
     * Team members managed by this user (when user is a manager)
     */
    public function teamMembers()
    {
        return $this->hasMany(TeamMember::class, 'manager_id');
    }

    /**
     * Team memberships for this user (when user is an employee)
     */
    public function teamMemberships()
    {
        return $this->hasMany(TeamMember::class, 'employee_id');
    }

    /**
     * Performance reviews conducted by this user
     */
    public function conductedReviews()
    {
        return $this->hasMany(PerformanceReview::class, 'reviewer_id');
    }

    /**
     * Performance reviews for this user
     */
    public function performanceReviews()
    {
        return $this->hasMany(PerformanceReview::class, 'employee_id');
    }

    /**
     * Department relationship
     */
    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    /**
     * Departments managed by this user (when user is a manager)
     */
    public function managedDepartments()
    {
        return $this->hasMany(Department::class, 'manager_id');
    }

    /**
     * Employee profile relationship
     */
    public function employeeProfile()
    {
        return $this->hasOne(EmployeeProfile::class);
    }

    /**
     * Designation relationship
     */
    public function designation()
    {
        return $this->belongsTo(Designation::class);
    }

    /**
     * Employee attendance records
     */
    public function employeeAttendances()
    {
        return $this->hasMany(EmployeeAttendance::class);
    }

    /**
     * Admin attendance records
     */
    public function adminAttendances()
    {
        return $this->hasMany(AdminAttendance::class);
    }

    /**
     * Biometric attendance records
     */
    public function biometricAttendances()
    {
        return $this->hasMany(BiometricAttendance::class);
    }

    /**
     * Office loans
     */
    public function officeLoans()
    {
        return $this->hasMany(OfficeLoan::class);
    }

    /**
     * Personal loans
     */
    public function personalLoans()
    {
        return $this->hasMany(PersonalLoan::class);
    }

    /**
     * Employee leaves
     */
    public function employeeLeaves()
    {
        return $this->hasMany(EmployeeLeave::class);
    }

    /**
     * Admin leaves
     */
    public function adminLeaves()
    {
        return $this->hasMany(AdminLeave::class);
    }

    /**
     * Time sheets
     */
    public function timeSheets()
    {
        return $this->hasMany(TimeSheet::class);
    }

    /**
     * Schedules assigned to user
     */
    public function schedules()
    {
        return $this->hasMany(Schedule::class);
    }

    /**
     * Overtime records
     */
    public function overtimes()
    {
        return $this->hasMany(Overtime::class);
    }

    /**
     * Warnings issued to user
     */
    public function warnings()
    {
        return $this->hasMany(Warning::class);
    }

    /**
     * Leave balance for user
     */
    public function leaveBalances()
    {
        return $this->hasMany(LeaveBalance::class);
    }
}
