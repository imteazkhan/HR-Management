<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Message;
use App\Models\Notification;
use App\Models\ManagerSetting;
use App\Models\TeamMember;
use App\Models\PerformanceReview;
use App\Models\Department;

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

        return view('dashboards.Admin.superadmin', compact('stats', 'recentActivities'));
    }

    /**
     * Show all employees
     */
    public function showEmployees(): View
    {
        $employees = User::where('role', '!=', 'superadmin')->paginate(15);
        $departments = Department::all();
        return view('dashboards.Admin.employees', compact('employees', 'departments'));
    }

    /**
     * Create new employee
     */
    public function createEmployee(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8',
            'role' => 'required|in:manager,employee',
            'department_id' => 'nullable|exists:departments,id'
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
            'department_id' => $request->department_id,
        ]);

        return redirect()->route('superadmin.employees')
            ->with('success', 'Employee created successfully!');
    }

    /**
     * Update employee
     */
    public function updateEmployee(Request $request, User $employee): RedirectResponse
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $employee->id,
            'role' => 'required|in:manager,employee',
            'department_id' => 'nullable|exists:departments,id',
            'password' => 'nullable|string|min:8'
        ]);

        $updateData = [
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role,
            'department_id' => $request->department_id,
        ];

        // Only update password if provided
        if ($request->filled('password')) {
            $updateData['password'] = Hash::make($request->password);
        }

        $employee->update($updateData);

        return redirect()->route('superadmin.employees')
            ->with('success', 'Employee updated successfully!');
    }

    /**
     * Delete employee
     */
    public function deleteEmployee(User $employee): RedirectResponse
    {
        // Prevent deleting self
        if ($employee->id === Auth::id()) {
            return redirect()->route('superadmin.employees')
                ->with('error', 'You cannot delete your own account!');
        }

        // Prevent deleting superadmin
        if ($employee->role === 'superadmin') {
            return redirect()->route('superadmin.employees')
                ->with('error', 'You cannot delete a superadmin account!');
        }

        $employee->delete();

        return redirect()->route('superadmin.employees')
            ->with('success', 'Employee deleted successfully!');
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
        $departments = Department::with(['manager', 'employees'])
            ->withCount('employees')
            ->get();
        
        $managers = User::where('role', 'manager')->get();
        
        return view('dashboards.Admin.departments', compact('departments', 'managers'));
    }

    /**
     * Create new department
     */
    public function createDepartment(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:departments,name',
            'manager_id' => 'nullable|exists:users,id',
            'description' => 'nullable|string|max:1000',
            'location' => 'nullable|string|max:255',
            'budget' => 'nullable|string|max:255',
            'max_employees' => 'nullable|integer|min:1|max:500'
        ]);

        Department::create([
            'name' => $request->name,
            'description' => $request->description,
            'manager_id' => $request->manager_id,
            'location' => $request->location,
            'budget' => $request->budget,
            'max_employees' => $request->max_employees ?? 50,
            'is_active' => true
        ]);
        
        return redirect()->route('superadmin.departments')
            ->with('success', 'Department created successfully!');
    }

    /**
     * Update department
     */
    public function updateDepartment(Request $request, Department $department): RedirectResponse
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:departments,name,' . $department->id,
            'manager_id' => 'nullable|exists:users,id',
            'description' => 'nullable|string|max:1000',
            'location' => 'nullable|string|max:255',
            'budget' => 'nullable|string|max:255',
            'max_employees' => 'nullable|integer|min:1|max:500',
            'is_active' => 'boolean'
        ]);

        $department->update([
            'name' => $request->name,
            'description' => $request->description,
            'manager_id' => $request->manager_id,
            'location' => $request->location,
            'budget' => $request->budget,
            'max_employees' => $request->max_employees ?? 50,
            'is_active' => $request->boolean('is_active', true)
        ]);
        
        return redirect()->route('superadmin.departments')
            ->with('success', 'Department updated successfully!');
    }

    /**
     * Delete department
     */
    public function deleteDepartment(Department $department): RedirectResponse
    {
        // Check if department has employees
        if ($department->employees()->count() > 0) {
            return redirect()->route('superadmin.departments')
                ->with('error', 'Cannot delete department with existing employees. Please reassign employees first.');
        }

        $department->delete();
        
        return redirect()->route('superadmin.departments')
            ->with('success', 'Department deleted successfully!');
    }

    /**
     * Show department details
     */
    public function showDepartment(Department $department): View
    {
        $department->load(['manager', 'employees']);
        
        // Get available managers for the edit modal
        $managers = User::where('role', 'manager')->orWhere('role', 'employee')->get();
        
        return view('dashboards.Admin.show-department', compact('department', 'managers'));
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
            'records_per_page' => 15,
            'session_timeout' => 60,
        ];

        return view('dashboards.Admin.settings', compact('settings'));
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

        return view('dashboards.Admin.payroll', compact('payrollData'));
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
     * Update payroll
     */
    public function updatePayroll(Request $request, $payrollId): RedirectResponse
    {
        $request->validate([
            'base_salary' => 'required|numeric|min:0',
            'bonuses' => 'required|numeric|min:0',
            'deductions' => 'required|numeric|min:0'
        ]);

        // Here you would update the payroll data
        // For now, this is a mock implementation since payroll data is currently hardcoded
        // In a real application, you would update the payroll record in the database
        
        return redirect()->route('superadmin.payroll')
            ->with('success', 'Payroll updated successfully!');
    }

    /**
     * Show user roles management
     */
    public function showUserRoles(): View
    {
        $users = User::orderBy('role', 'asc')->paginate(15);
        $roleCounts = [
            'superadmin' => User::where('role', 'superadmin')->count(),
            'manager' => User::where('role', 'manager')->count(),
            'employee' => User::where('role', 'employee')->count()
        ];
        return view('dashboards.Admin.user-roles', compact('users', 'roleCounts'));
    }

    /**
     * Show system security
     */
    public function showSecurity(): View
    {
        $securityStats = [
            'failed_logins_today' => rand(5, 25),
            'active_sessions' => User::count() + rand(10, 50),
            'last_security_scan' => now()->subHours(6)->format('Y-m-d H:i:s'),
            'ssl_status' => 'Active',
            'firewall_status' => 'Enabled',
            'backup_encryption' => 'AES-256'
        ];
        
        return view('dashboards.Admin.security', compact('securityStats'));
    }

    /**
     * Show database management
     */
    public function showDatabase(): View
    {
        $databaseStats = [
            'total_tables' => 8,
            'total_records' => User::count() + 150, // Mock additional records
            'database_size' => '2.4 MB',
            'last_backup' => now()->subDay()->format('Y-m-d H:i:s'),
            'backup_size' => '1.8 MB',
            'connection_status' => 'Connected'
        ];
        
        return view('dashboards.Admin.database', compact('databaseStats'));
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

        return view('dashboards.Admin.analytics', compact('analytics'));
    }

    /**
     * System backup
     */
    public function backupSystem(Request $request): RedirectResponse
    {
        // Here you would implement system backup logic
        
        return redirect()->route('superadmin.dashboard')
            ->with('success', 'System backup completed successfully!');
    }

    // ==================== MANAGER DATA MANAGEMENT METHODS ====================

    /**
     * Manage Messages
     */
    public function manageMessages(): View
    {
        $messages = Message::with(['fromUser', 'toUser'])
            ->orderBy('created_at', 'desc')
            ->paginate(15);
        
        $users = User::where('role', '!=', 'superadmin')->get();
        
        return view('dashboards.Admin.manager-data.messages', compact('messages', 'users'));
    }

    /**
     * Create Message
     */
    public function createMessage(Request $request): RedirectResponse
    {
        $request->validate([
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
            'to_user_id' => 'nullable|exists:users,id',
            'type' => 'required|in:individual,team,announcement',
            'priority' => 'required|in:low,normal,high'
        ]);

        Message::create([
            'subject' => $request->subject,
            'message' => $request->message,
            'from_user_id' => Auth::id(),
            'to_user_id' => $request->to_user_id,
            'type' => $request->type,
            'priority' => $request->priority
        ]);

        return redirect()->route('superadmin.manager-data.messages')
            ->with('success', 'Message created successfully!');
    }

    /**
     * Delete Message
     */
    public function deleteMessage(Message $message): RedirectResponse
    {
        $message->delete();
        
        return redirect()->route('superadmin.manager-data.messages')
            ->with('success', 'Message deleted successfully!');
    }

    /**
     * Manage Notifications
     */
    public function manageNotifications(): View
    {
        $notifications = Notification::with('user')
            ->orderBy('created_at', 'desc')
            ->paginate(15);
        
        $users = User::where('role', '!=', 'superadmin')->get();
        
        return view('dashboards.Admin.manager-data.notifications', compact('notifications', 'users'));
    }

    /**
     * Create Notification
     */
    public function createNotification(Request $request): RedirectResponse
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'title' => 'required|string|max:255',
            'message' => 'required|string',
            'type' => 'required|in:leave_request,attendance,task,system,announcement'
        ]);

        Notification::create([
            'user_id' => $request->user_id,
            'title' => $request->title,
            'message' => $request->message,
            'type' => $request->type
        ]);

        return redirect()->route('superadmin.manager-data.notifications')
            ->with('success', 'Notification created successfully!');
    }

    /**
     * Delete Notification
     */
    public function deleteNotification(Notification $notification): RedirectResponse
    {
        $notification->delete();
        
        return redirect()->route('superadmin.manager-data.notifications')
            ->with('success', 'Notification deleted successfully!');
    }

    /**
     * Manage Team Members
     */
    public function manageTeamMembers(): View
    {
        $teamMembers = TeamMember::with(['manager', 'employee'])
            ->orderBy('created_at', 'desc')
            ->paginate(15);
        
        $managers = User::where('role', 'manager')->get();
        $employees = User::where('role', 'employee')->get();
        
        return view('dashboards.Admin.manager-data.team-members', compact('teamMembers', 'managers', 'employees'));
    }

    /**
     * Create Team Member
     */
    public function createTeamMember(Request $request): RedirectResponse
    {
        $request->validate([
            'manager_id' => 'required|exists:users,id',
            'employee_id' => 'required|exists:users,id',
            'position' => 'nullable|string|max:255',
            'join_date' => 'required|date',
            'status' => 'required|in:active,inactive,on_leave',
            'notes' => 'nullable|string'
        ]);

        TeamMember::create($request->all());

        return redirect()->route('superadmin.manager-data.team-members')
            ->with('success', 'Team member assigned successfully!');
    }

    /**
     * Delete Team Member
     */
    public function deleteTeamMember(TeamMember $teamMember): RedirectResponse
    {
        $teamMember->delete();
        
        return redirect()->route('superadmin.manager-data.team-members')
            ->with('success', 'Team member removed successfully!');
    }

    /**
     * Manage Performance Reviews
     */
    public function managePerformanceReviews(): View
    {
        $reviews = PerformanceReview::with(['employee', 'reviewer'])
            ->orderBy('created_at', 'desc')
            ->paginate(15);
        
        $managers = User::where('role', 'manager')->get();
        $employees = User::where('role', 'employee')->get();
        
        return view('dashboards.Admin.manager-data.performance-reviews', compact('reviews', 'managers', 'employees'));
    }

    /**
     * Create Performance Review
     */
    public function createPerformanceReview(Request $request): RedirectResponse
    {
        $request->validate([
            'employee_id' => 'required|exists:users,id',
            'reviewer_id' => 'required|exists:users,id',
            'score' => 'nullable|integer|min:0|max:100',
            'completed_tasks' => 'integer|min:0',
            'on_time_rate' => 'numeric|min:0|max:100',
            'rating' => 'required|in:outstanding,excellent,good,satisfactory,needs_improvement',
            'comments' => 'nullable|string',
            'review_period_start' => 'required|date',
            'review_period_end' => 'required|date|after:review_period_start',
            'status' => 'required|in:draft,completed,approved'
        ]);

        PerformanceReview::create($request->all());

        return redirect()->route('superadmin.manager-data.performance-reviews')
            ->with('success', 'Performance review created successfully!');
    }

    /**
     * Update Performance Review
     */
    public function updatePerformanceReview(Request $request, PerformanceReview $review): RedirectResponse
    {
        $request->validate([
            'score' => 'nullable|integer|min:0|max:100',
            'completed_tasks' => 'integer|min:0',
            'on_time_rate' => 'numeric|min:0|max:100',
            'rating' => 'required|in:outstanding,excellent,good,satisfactory,needs_improvement',
            'comments' => 'nullable|string',
            'status' => 'required|in:draft,completed,approved'
        ]);

        $review->update($request->all());

        return redirect()->route('superadmin.manager-data.performance-reviews')
            ->with('success', 'Performance review updated successfully!');
    }

    /**
     * Delete Performance Review
     */
    public function deletePerformanceReview(PerformanceReview $review): RedirectResponse
    {
        $review->delete();
        
        return redirect()->route('superadmin.manager-data.performance-reviews')
            ->with('success', 'Performance review deleted successfully!');
    }

    /**
     * Manage Manager Settings
     */
    public function manageManagerSettings(): View
    {
        $settings = ManagerSetting::with('user')
            ->orderBy('user_id')
            ->paginate(15);
        
        return view('dashboards.Admin.manager-data.manager-settings', compact('settings'));
    }

    /**
     * Update Manager Setting
     */
    public function updateManagerSetting(Request $request, ManagerSetting $setting): RedirectResponse
    {
        $request->validate([
            'email_notifications' => 'boolean',
            'push_notifications' => 'boolean',
            'weekly_reports' => 'boolean',
            'auto_approve_leaves' => 'boolean',
            'team_size_limit' => 'integer|min:1|max:100'
        ]);

        $setting->update([
            'email_notifications' => $request->boolean('email_notifications'),
            'push_notifications' => $request->boolean('push_notifications'),
            'weekly_reports' => $request->boolean('weekly_reports'),
            'auto_approve_leaves' => $request->boolean('auto_approve_leaves'),
            'team_size_limit' => $request->input('team_size_limit')
        ]);

        return redirect()->route('superadmin.manager-data.manager-settings')
            ->with('success', 'Manager settings updated successfully!');
    }
}