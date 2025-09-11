<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class SuperAdminController extends Controller
{
    /**
     * Display the super admin dashboard
     */
    public function dashboard(): View
    {
        // Get real system stats
        $stats = [
            'employees' => User::count(),
            'departments' => 8, // You can create a departments table later
            'attendance_today' => User::where('role', '!=', 'superadmin')->count() - 5, // Mock active users
            'payroll_today' => '485K' // Mock total payroll
        ];
        
        // Get recent system activities
        $recentActivities = [
            ['icon' => 'person-plus', 'color' => 'success', 'message' => 'New manager Alex Johnson added to IT Department', 'time' => '2 hours ago'],
            ['icon' => 'building', 'color' => 'info', 'message' => 'New department Digital Marketing created', 'time' => '4 hours ago'],
            ['icon' => 'cash-stack', 'color' => 'warning', 'message' => 'Monthly payroll processed: $485,000', 'time' => '6 hours ago'],
            ['icon' => 'shield-check', 'color' => 'primary', 'message' => 'System backup completed successfully', 'time' => 'Yesterday']
        ];

        return view('dashboards.superadmin', compact('stats', 'recentActivities'));
    }

    /**
     * Show all users management
     */
    public function showUsers(): View
    {
        $users = User::orderBy('created_at', 'desc')->paginate(15);
        return view('superadmin.users', compact('users'));
    }

    /**
     * Create new user
     */
    public function createUser(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8',
            'role' => 'required|in:superadmin,manager,employee'
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
        ]);

        return redirect()->route('superadmin.users')
            ->with('success', 'User created successfully!');
    }

    /**
     * Update user role
     */
    public function updateUserRole(Request $request): RedirectResponse
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'role' => 'required|in:superadmin,manager,employee'
        ]);

        $user = User::findOrFail($request->user_id);
        $user->update(['role' => $request->role]);

        return redirect()->route('superadmin.users')
            ->with('success', "User role updated to {$request->role} successfully!");
    }

    /**
     * Delete user
     */
    public function deleteUser(Request $request): RedirectResponse
    {
        $request->validate([
            'user_id' => 'required|exists:users,id'
        ]);

        $user = User::findOrFail($request->user_id);
        
        // Prevent deleting self
        if ($user->id === Auth::id()) {
            return redirect()->route('superadmin.users')
                ->with('error', 'You cannot delete your own account!');
        }

        $user->delete();

        return redirect()->route('superadmin.users')
            ->with('success', 'User deleted successfully!');
    }

    /**
     * Show departments management
     */
    public function showDepartments(): View
    {
        // Mock departments data
        $departments = [
            ['id' => 1, 'name' => 'Human Resources', 'manager' => 'John Manager', 'employees' => 5, 'created_at' => '2024-01-15'],
            ['id' => 2, 'name' => 'Information Technology', 'manager' => 'Alex Johnson', 'employees' => 12, 'created_at' => '2024-02-01'],
            ['id' => 3, 'name' => 'Finance', 'manager' => 'Sarah Wilson', 'employees' => 8, 'created_at' => '2024-03-10'],
            ['id' => 4, 'name' => 'Marketing', 'manager' => 'Mike Brown', 'employees' => 6, 'created_at' => '2024-04-05'],
        ];

        return view('superadmin.departments', compact('departments'));
    }

    /**
     * Create new department
     */
    public function createDepartment(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'manager_id' => 'nullable|exists:users,id',
            'description' => 'nullable|string|max:500'
        ]);

        // Here you would save to departments table
        
        return redirect()->route('superadmin.departments')
            ->with('success', 'Department created successfully!');
    }

    /**
     * Show system settings
     */
    public function showSettings(): View
    {
        // Mock system settings
        $settings = [
            'site_name' => 'HR Management System',
            'company_name' => 'iK Soft',
            'timezone' => 'UTC',
            'date_format' => 'Y-m-d',
            'currency' => 'USD',
            'working_hours_start' => '09:00',
            'working_hours_end' => '17:00',
            'annual_leave_days' => 20,
        ];

        return view('superadmin.settings', compact('settings'));
    }

    /**
     * Update system settings
     */
    public function updateSettings(Request $request): RedirectResponse
    {
        $request->validate([
            'site_name' => 'required|string|max:255',
            'company_name' => 'required|string|max:255',
            'timezone' => 'required|string',
            'working_hours_start' => 'required|date_format:H:i',
            'working_hours_end' => 'required|date_format:H:i',
            'annual_leave_days' => 'required|integer|min:0|max:365'
        ]);

        // Here you would save settings to database or config
        
        return redirect()->route('superadmin.settings')
            ->with('success', 'Settings updated successfully!');
    }

    /**
     * Show payroll management
     */
    public function showPayroll(): View
    {
        // Mock payroll data
        $payrollData = [
            ['employee' => 'John Smith', 'position' => 'Developer', 'base_salary' => 3200, 'bonuses' => 500, 'deductions' => 200, 'net_salary' => 3500],
            ['employee' => 'Sarah Lee', 'position' => 'Designer', 'base_salary' => 2800, 'bonuses' => 300, 'deductions' => 150, 'net_salary' => 2950],
            ['employee' => 'Mike Davis', 'position' => 'Analyst', 'base_salary' => 3000, 'bonuses' => 400, 'deductions' => 180, 'net_salary' => 3220],
        ];

        return view('superadmin.payroll', compact('payrollData'));
    }

    /**
     * Process payroll
     */
    public function processPayroll(Request $request): RedirectResponse
    {
        $request->validate([
            'month' => 'required|date_format:Y-m',
            'employees' => 'required|array'
        ]);

        // Here you would process payroll calculations
        
        return redirect()->route('superadmin.payroll')
            ->with('success', 'Payroll processed successfully!');
    }

    /**
     * Show system analytics
     */
    public function showAnalytics(): View
    {
        // Mock analytics data
        $analytics = [
            'total_users' => User::count(),
            'new_users_this_month' => User::whereMonth('created_at', now()->month)->count(),
            'active_sessions' => rand(50, 150),
            'system_uptime' => '99.9%',
            'storage_used' => '2.4 GB',
            'backup_status' => 'Success',
            'last_backup' => now()->subDays(1)->format('Y-m-d H:i:s')
        ];

        return view('superadmin.analytics', compact('analytics'));
    }

    /**
     * Backup system
     */
    public function backupSystem(): RedirectResponse
    {
        // Here you would trigger system backup
        
        return redirect()->route('superadmin.analytics')
            ->with('success', 'System backup initiated successfully!');
    }
}