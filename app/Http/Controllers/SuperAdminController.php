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
use App\Models\Payroll;
use App\Models\Designation;

class SuperAdminController extends Controller
{
    /**
     * Display the super admin dashboard
     */
    public function dashboard(): View
    {
        // Get today's date
        $today = date('Y-m-d');
        
        // Get total employee count (excluding superadmin)
        $totalEmployees = User::where('role', '!=', 'superadmin')->count();
        
        // Get departments count
        $departmentsCount = Department::count();
        
        // Get today's attendance statistics
        $presentToday = DB::table('employee_attendances')
            ->where('date', $today)
            ->where('status', 'present')
            ->count();
            
        $absentToday = DB::table('employee_attendances')
            ->where('date', $today)
            ->where('status', 'absent')
            ->count();
            
        $lateToday = DB::table('employee_attendances')
            ->where('date', $today)
            ->where('status', 'late')
            ->count();
            
        $onLeaveToday = DB::table('employee_attendances')
            ->where('date', $today)
            ->where('status', 'on_leave')
            ->count();
        
        // Calculate attendance rate
        $totalAttendanceRecords = $presentToday + $absentToday + $lateToday + $onLeaveToday;
        $attendanceRate = $totalAttendanceRecords > 0 ? round(($presentToday + $lateToday) / $totalAttendanceRecords * 100, 1) : 0;
        
        // Get admin statistics (with table existence check)
        $totalAdmins = User::where('role', 'admin')->count();
        $adminPresentToday = 0;
        $adminAbsentToday = 0;
        
        if (DB::getSchemaBuilder()->hasTable('admin_attendances')) {
            try {
                $adminPresentToday = DB::table('admin_attendances')
                    ->where('date', $today)
                    ->where('status', 'present')
                    ->count();
                $adminAbsentToday = DB::table('admin_attendances')
                    ->where('date', $today)
                    ->where('status', 'absent')
                    ->count();
            } catch (\Exception $e) {
                $adminPresentToday = max(0, $totalAdmins - 2);
                $adminAbsentToday = min(2, $totalAdmins);
            }
        } else {
            $adminPresentToday = max(0, $totalAdmins - 2);
            $adminAbsentToday = min(2, $totalAdmins);
        }
        
        // Get manager statistics (with table existence check)
        $totalManagers = User::where('role', 'manager')->count();
        $managerPresentToday = 0;
        $managerAbsentToday = 0;
        
        if (DB::getSchemaBuilder()->hasTable('manager_attendances')) {
            try {
                $managerPresentToday = DB::table('manager_attendances')
                    ->where('date', $today)
                    ->where('status', 'present')
                    ->count();
                $managerAbsentToday = DB::table('manager_attendances')
                    ->where('date', $today)
                    ->where('status', 'absent')
                    ->count();
            } catch (\Exception $e) {
                $managerPresentToday = max(0, $totalManagers - 1);
                $managerAbsentToday = min(1, $totalManagers);
            }
        } else {
            $managerPresentToday = max(0, $totalManagers - 1);
            $managerAbsentToday = min(1, $totalManagers);
        }
        
        // Calculate attendance rates for each role
        $adminAttendanceRate = $totalAdmins > 0 ? round(($adminPresentToday / $totalAdmins) * 100, 1) : 0;
        $managerAttendanceRate = $totalManagers > 0 ? round(($managerPresentToday / $totalManagers) * 100, 1) : 0;
        
        // Get real system stats
        $stats = [
            'employees' => $totalEmployees,
            'departments' => $departmentsCount,
            'attendance_today' => $presentToday + $lateToday, // Present + Late = Active attendance
            'payroll_today' => '485K' // Mock total payroll for now
        ];
        
        // Attendance specific stats
        $attendanceStats = [
            'total_employees' => $totalEmployees,
            'present_today' => $presentToday,
            'absent_today' => $absentToday,
            'late_today' => $lateToday,
            'on_leave_today' => $onLeaveToday,
            'attendance_rate' => $attendanceRate,
            'total_attendance' => $presentToday + $lateToday,
            
            // Admin stats
            'total_admins' => $totalAdmins,
            'admin_present_today' => $adminPresentToday,
            'admin_absent_today' => $adminAbsentToday,
            'admin_attendance_rate' => $adminAttendanceRate,
            
            // Manager stats
            'total_managers' => $totalManagers,
            'manager_present_today' => $managerPresentToday,
            'manager_absent_today' => $managerAbsentToday,
            'manager_attendance_rate' => $managerAttendanceRate
        ];
        
        // Get recent system activities
        $recentActivities = [
            ['icon' => 'person-plus', 'color' => 'success', 'message' => 'New manager Alex Johnson added to IT Department', 'time' => '2 hours ago'],
            ['icon' => 'building', 'color' => 'info', 'message' => 'New department Digital Marketing created', 'time' => '4 hours ago'],
            ['icon' => 'cash-stack', 'color' => 'warning', 'message' => 'Monthly payroll processed: $485,000', 'time' => '6 hours ago'],
            ['icon' => 'shield-check', 'color' => 'primary', 'message' => 'System backup completed successfully', 'time' => 'Yesterday']
        ];

        return view('dashboards.Admin.superadmin', compact('stats', 'attendanceStats', 'recentActivities'));
    }

    /**
     * Show all employees
     */
    public function showEmployees(): View
    {
        $employees = User::with('department')
            ->where('role', '!=', 'superadmin')
            ->paginate(15);
        $departments = Department::all();
        return view('dashboards.Admin.employees', compact('employees', 'departments'));
    }

    /**
     * Show employee edit form
     */
    public function editEmployee(User $employee): View
    {
        $employee->load([
            'employeeProfile',
            'department',
            'designation',
            'employeeAttendances' => function ($query) {
                $query->orderBy('date', 'desc')->limit(10);
            },
            'employeeLeaves' => function ($query) {
                $query->orderBy('created_at', 'desc')->limit(10);
            },
            'leaveBalances',
            'payrolls' => function ($query) {
                $query->orderBy('created_at', 'desc')->limit(10);
            },
            'performanceReviews' => function ($query) {
                $query->orderBy('created_at', 'desc')->limit(10);
            },
            'performanceReviews.reviewer'
        ]);
        
        $departments = Department::all();
        $designations = Designation::all();
        
        return view('dashboards.Admin.edit-employee', compact('employee', 'departments', 'designations'));
    }

    /**
     * Show employee ID cards with QR codes
     */
    public function showEmployeeIdCards(): View
    {
        $employees = User::with('department')
            ->where('role', '!=', 'superadmin')
            ->get();
        return view('dashboards.Admin.employee-id-cards', compact('employees'));
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
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $employee->id,
            'phone' => 'nullable|string|max:20',
            'department_id' => 'nullable|exists:departments,id',
            'designation_id' => 'nullable|exists:designations,id',
            'role' => 'required|in:manager,employee',
            'date_of_birth' => 'nullable|date',
            'gender' => 'nullable|in:male,female,other',
            'marital_status' => 'nullable|in:single,married,divorced,widowed',
            'nationality' => 'nullable|string|max:100',
            'joining_date' => 'nullable|date',
            'employment_type' => 'nullable|in:full_time,part_time,contract,intern',
            'salary' => 'nullable|numeric|min:0',
            'bank_account' => 'nullable|string|max:100',
            'tax_id' => 'nullable|string|max:50',
            'status' => 'nullable|in:active,inactive,terminated',
            'password' => 'nullable|string|min:8|confirmed'
        ]);

        // Update user
        $userData = [
            'name' => $request->first_name . ' ' . $request->last_name,
            'email' => $request->email,
            'role' => $request->role,
            'department_id' => $request->department_id,
            'designation_id' => $request->designation_id,
        ];

        // Only update password if provided
        if ($request->filled('password')) {
            $userData['password'] = Hash::make($request->password);
        }

        $employee->update($userData);

        // Update or create employee profile
        $profileData = [
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'phone' => $request->phone,
            'emergency_contact' => $request->emergency_contact,
            'address' => $request->address,
            'date_of_birth' => $request->date_of_birth,
            'gender' => $request->gender,
            'marital_status' => $request->marital_status,
            'nationality' => $request->nationality,
            'joining_date' => $request->joining_date,
            'employment_type' => $request->employment_type,
            'salary' => $request->salary,
            'bank_account' => $request->bank_account,
            'tax_id' => $request->tax_id,
            'status' => $request->status,
        ];

        if ($employee->employeeProfile) {
            $employee->employeeProfile->update($profileData);
        } else {
            $profileData['user_id'] = $employee->id;
            EmployeeProfile::create($profileData);
        }

        return redirect()->route('superadmin.employees')
            ->with('success', 'Employee updated successfully!');
    }

    /**
     * Upload employee document
     */
    public function uploadEmployeeDocument(Request $request, User $employee): RedirectResponse
    {
        $request->validate([
            'document' => 'required|file|max:2048|mimes:pdf,doc,docx,jpg,png,jpeg'
        ]);

        // Create employee profile if it doesn't exist
        if (!$employee->employeeProfile) {
            $employee->employeeProfile()->create([
                'first_name' => explode(' ', $employee->name)[0] ?? '',
                'last_name' => explode(' ', $employee->name)[1] ?? '',
                'joining_date' => now(),
                'user_id' => $employee->id,
                'employee_id' => 'EMP' . str_pad($employee->id, 4, '0', STR_PAD_LEFT),
            ]);
        }

        // Handle document upload
        if ($request->hasFile('document')) {
            $documentPath = $request->file('document')->store('employee_documents', 'public');
            
            // Get existing documents
            $existingDocuments = $employee->employeeProfile->documents ? json_decode($employee->employeeProfile->documents, true) : [];
            
            // Add new document to the array
            $existingDocuments[] = $documentPath;
            
            // Update the profile with the new documents array
            $employee->employeeProfile->update([
                'documents' => json_encode($existingDocuments)
            ]);
        }

        return redirect()->back()->with('success', 'Document uploaded successfully!');
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
     * Show all users for user management
     */
    public function showUsers(): View
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
        // Get payroll data from database
        $payrolls = Payroll::orderBy('created_at', 'desc')->paginate(15);
        
        // Format data for the view (keeping the same structure as before)
        $payrollData = $payrolls->map(function ($payroll) {
            // Get attendance data for this employee and month
            $attendanceData = $this->getEmployeeAttendanceSummary($payroll->user_id, $payroll->month);
            
            // Get leave data for this employee
            $year = date('Y');
            $leaveData = $this->getEmployeeLeaveData($payroll->user_id, $year);
            
            return [
                'id' => $payroll->id,
                'employee' => $payroll->employee_name,
                'position' => $payroll->position,
                'base_salary' => $payroll->base_salary,
                'bonuses' => $payroll->bonuses,
                'deductions' => $payroll->deductions,
                'net_salary' => $payroll->net_salary,
                'attendance_rate' => $attendanceData['attendance_rate'] ?? 'N/A',
                'leave_balance' => $leaveData['remaining_annual_leaves'] . '/' . $leaveData['annual_leaves']
            ];
        })->toArray();

        return view('dashboards.Admin.payroll', compact('payrollData', 'payrolls'));
    }
    
    /**
     * Get employee attendance summary for payroll display
     */
    private function getEmployeeAttendanceSummary($employeeId, $month)
    {
        // Extract year and month from the month string (e.g., "October 2025")
        $dateParts = explode(' ', $month);
        if (count($dateParts) != 2) {
            return ['attendance_rate' => 'N/A'];
        }
        
        $monthName = $dateParts[0];
        $year = $dateParts[1];
        
        // Convert month name to number
        $monthNumber = date('m', strtotime($monthName));
        
        // Get attendance records for the employee in the specified month
        $attendanceRecords = DB::table('employee_attendances')
            ->where('user_id', $employeeId)
            ->whereYear('date', $year)
            ->whereMonth('date', $monthNumber)
            ->get();
            
        // Count different types of attendance
        $presentDays = $attendanceRecords->where('status', 'present')->count();
        $halfDays = $attendanceRecords->where('status', 'half_day')->count();
        $totalDays = $attendanceRecords->count();
        
        // Calculate attendance rate
        $totalWorkingDays = date('t', strtotime($year . '-' . $monthNumber . '-01'));
        $attendanceRate = $totalWorkingDays > 0 ? round((($presentDays + ($halfDays * 0.5)) / $totalWorkingDays) * 100, 1) : 0;
        
        return [
            'attendance_rate' => $attendanceRate . '%',
            'present_days' => $presentDays,
            'half_days' => $halfDays,
            'total_days' => $totalDays
        ];
    }
    
    /**
     * Process payroll
     */
    public function processPayroll(Request $request): RedirectResponse
    {
        $request->validate([
            'month' => 'required|date_format:Y-m',
        ]);

        // Get all employees
        $employees = User::where('role', 'employee')->get();
        
        // Format month for display
        $monthName = date('F Y', strtotime($request->month));
        $year = date('Y', strtotime($request->month));
        $month = date('m', strtotime($request->month));
        
        // Process payroll for each employee
        foreach ($employees as $employee) {
            // Skip if payroll already exists for this employee and month
            $existingPayroll = Payroll::where('user_id', $employee->id)
                ->where('month', $monthName)
                ->first();
                
            if ($existingPayroll) {
                continue;
            }
            
            // Get attendance data for the month
            $attendanceData = $this->getEmployeeAttendanceData($employee->id, $year, $month);
            
            // Get leave data for the employee
            $leaveData = $this->getEmployeeLeaveData($employee->id, $year);
            
            // Calculate base salary (could be from employee profile or position)
            $baseSalary = $this->calculateBaseSalary($employee, $attendanceData);
            
            // Calculate bonuses based on attendance and performance
            $bonuses = $this->calculateBonuses($employee, $attendanceData, $leaveData);
            
            // Calculate deductions based on absences and leaves
            $deductions = $this->calculateDeductions($employee, $attendanceData, $leaveData);
            
            // Calculate net salary
            $netSalary = $baseSalary + $bonuses - $deductions;
            
            // Create payroll record
            Payroll::create([
                'user_id' => $employee->id,
                'employee_name' => $employee->name,
                'position' => 'Employee',
                'base_salary' => $baseSalary,
                'bonuses' => $bonuses,
                'deductions' => $deductions,
                'net_salary' => $netSalary,
                'month' => $monthName,
                'status' => 'processed'
            ]);
        }
        
        return redirect()->route('superadmin.payroll')
            ->with('success', 'Payroll processed successfully for ' . $monthName . '!');
    }
    
    /**
     * Get employee attendance data for a specific month
     */
    private function getEmployeeAttendanceData($employeeId, $year, $month)
    {
        // Get attendance records for the employee in the specified month
        $attendanceRecords = DB::table('employee_attendances')
            ->where('user_id', $employeeId)
            ->whereYear('date', $year)
            ->whereMonth('date', $month)
            ->get();
            
        // Count different types of attendance
        $presentDays = $attendanceRecords->where('status', 'present')->count();
        $lateDays = $attendanceRecords->where('status', 'late')->count();
        $absentDays = $attendanceRecords->where('status', 'absent')->count();
        $halfDays = $attendanceRecords->where('status', 'half_day')->count();
        $onLeaveDays = $attendanceRecords->where('status', 'on_leave')->count();
        
        // Calculate total working hours
        $totalHours = $attendanceRecords->sum('total_hours');
        
        return [
            'total_days' => $attendanceRecords->count(),
            'present_days' => $presentDays,
            'late_days' => $lateDays,
            'absent_days' => $absentDays,
            'half_days' => $halfDays,
            'on_leave_days' => $onLeaveDays,
            'total_hours' => $totalHours
        ];
    }
    
    /**
     * Get employee leave data for a specific year
     */
    private function getEmployeeLeaveData($employeeId, $year)
    {
        // Get leave balance for the employee
        $leaveBalance = DB::table('leave_balances')
            ->where('user_id', $employeeId)
            ->where('year', $year)
            ->first();
            
        if (!$leaveBalance) {
            // Return default values if no leave balance found
            return [
                'annual_leaves' => 21,
                'sick_leaves' => 10,
                'used_annual_leaves' => 0,
                'used_sick_leaves' => 0,
                'remaining_annual_leaves' => 21,
                'remaining_sick_leaves' => 10
            ];
        }
        
        return [
            'annual_leaves' => $leaveBalance->annual_leaves ?? 21,
            'sick_leaves' => $leaveBalance->sick_leaves ?? 10,
            'used_annual_leaves' => $leaveBalance->used_annual_leaves ?? 0,
            'used_sick_leaves' => $leaveBalance->used_sick_leaves ?? 0,
            'remaining_annual_leaves' => ($leaveBalance->annual_leaves ?? 21) - ($leaveBalance->used_annual_leaves ?? 0),
            'remaining_sick_leaves' => ($leaveBalance->sick_leaves ?? 10) - ($leaveBalance->used_sick_leaves ?? 0)
        ];
    }
    
    /**
     * Calculate base salary based on attendance
     */
    private function calculateBaseSalary($employee, $attendanceData)
    {
        // Base salary could come from employee profile or be a fixed amount
        // For now, we'll use a mock calculation based on attendance
        $baseAmount = rand(25000, 50000); // BDT
        
        // Adjust base salary based on attendance (full attendance bonus)
        $totalWorkingDays = date('t'); // Days in the month
        $attendanceRate = $totalWorkingDays > 0 ? ($attendanceData['present_days'] + $attendanceData['half_days'] * 0.5) / $totalWorkingDays : 0;
        
        // If attendance is 100%, give full base salary
        // If attendance is below 80%, reduce base salary proportionally
        if ($attendanceRate < 0.8) {
            $baseAmount *= $attendanceRate;
        }
        
        return round($baseAmount, 2);
    }
    
    /**
     * Calculate bonuses based on attendance and leave data
     */
    private function calculateBonuses($employee, $attendanceData, $leaveData)
    {
        $bonuses = 0;
        
        // Perfect attendance bonus (no absences or late arrivals)
        if ($attendanceData['absent_days'] == 0 && $attendanceData['late_days'] == 0) {
            $bonuses += 2000; // BDT
        }
        
        // Good attendance bonus (less than 2 absences)
        if ($attendanceData['absent_days'] < 2) {
            $bonuses += 1000; // BDT
        }
        
        // Minimal leave usage bonus
        if ($leaveData['used_annual_leaves'] <= 5) {
            $bonuses += 500; // BDT
        }
        
        // Random performance bonus
        $bonuses += rand(0, 3000); // BDT
        
        return round($bonuses, 2);
    }
    
    /**
     * Calculate deductions based on absences and leave data
     */
    private function calculateDeductions($employee, $attendanceData, $leaveData)
    {
        $deductions = 0;
        
        // Deduct for absences (assume 1% of base salary per absence)
        $absenceDeduction = $attendanceData['absent_days'] * 500; // BDT per absence
        $deductions += $absenceDeduction;
        
        // Deduct for late arrivals (assume 0.5% of base salary per 3 late arrivals)
        $lateDeduction = floor($attendanceData['late_days'] / 3) * 250; // BDT per 3 late arrivals
        $deductions += $lateDeduction;
        
        // Deduct for unauthorized leaves (leaves taken beyond allocated)
        $unauthorizedLeaveDeduction = max(0, $attendanceData['on_leave_days'] - ($leaveData['annual_leaves'] + $leaveData['sick_leaves'])) * 1000;
        $deductions += $unauthorizedLeaveDeduction;
        
        // Random other deductions
        $deductions += rand(0, 2000); // BDT
        
        return round($deductions, 2);
    }

    /**
     * Update payroll
     */
    public function updatePayroll(Request $request, $payroll): RedirectResponse
    {
        $request->validate([
            'base_salary' => 'required|numeric|min:0',
            'bonuses' => 'required|numeric|min:0',
            'deductions' => 'required|numeric|min:0'
        ]);

        // Find the payroll record
        $payrollRecord = Payroll::findOrFail($payroll);
        
        // Update the payroll data
        $payrollRecord->update([
            'base_salary' => $request->base_salary,
            'bonuses' => $request->bonuses,
            'deductions' => $request->deductions,
            'net_salary' => $request->base_salary + $request->bonuses - $request->deductions
        ]);

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

    /**
     * Show attendance dashboard
     */
    public function showAttendance(Request $request): View
    {
        // Build query for attendance records with filters
        $query = DB::table('employee_attendances')
            ->join('users', 'employee_attendances.user_id', '=', 'users.id')
            ->select('employee_attendances.*', 'users.name as employee_name');
        
        // Apply filters if provided
        if ($request->has('date') && $request->date) {
            $query->where('employee_attendances.date', $request->date);
        }
        
        if ($request->has('status') && $request->status) {
            $query->where('employee_attendances.status', $request->status);
        }
        
        if ($request->has('employee_name') && $request->employee_name) {
            $query->where('users.name', 'like', '%' . $request->employee_name . '%');
        }
        
        // Get filtered records with pagination
        $attendanceRecords = $query->orderBy('employee_attendances.date', 'desc')
            ->orderBy('employee_attendances.check_in', 'desc')
            ->paginate(10)
            ->appends($request->except('page'));
        
        // Get employees for the dropdown
        $employees = DB::table('users')
            ->where('role', 'employee')
            ->select('id', 'name')
            ->get();
        
        // Get departments for filters
        $departments = DB::table('departments')->get();
        
        // Get leave count data
        $leaveData = DB::table('users')
            ->leftJoin('leave_balances', function($join) {
                $join->on('users.id', '=', 'leave_balances.user_id')
                     ->where('leave_balances.year', '=', date('Y'));
            })
            ->where('users.role', 'employee')
            ->select(
                'users.id',
                'users.name',
                'leave_balances.annual_leaves',
                'leave_balances.sick_leaves',
                'leave_balances.used_annual_leaves',
                'leave_balances.used_sick_leaves'
            )
            ->get()
            ->map(function($employee) {
                return [
                    'id' => $employee->id,
                    'name' => $employee->name,
                    'annual_leaves' => $employee->annual_leaves ?? 21,
                    'sick_leaves' => $employee->sick_leaves ?? 10,
                    'used_annual_leaves' => $employee->used_annual_leaves ?? 0,
                    'used_sick_leaves' => $employee->used_sick_leaves ?? 0,
                    'remaining_annual_leaves' => ($employee->annual_leaves ?? 21) - ($employee->used_annual_leaves ?? 0),
                    'remaining_sick_leaves' => ($employee->sick_leaves ?? 10) - ($employee->used_sick_leaves ?? 0),
                ];
            });
        
        // Calculate attendance statistics for the dashboard
        $today = date('Y-m-d');
        
        // Employee statistics
        $totalEmployees = User::where('role', 'employee')->count();
        $employeePresentToday = DB::table('employee_attendances')
            ->where('date', $today)
            ->where('status', 'present')
            ->count();
        $employeeAbsentToday = DB::table('employee_attendances')
            ->where('date', $today)
            ->where('status', 'absent')
            ->count();
        $employeeLateToday = DB::table('employee_attendances')
            ->where('date', $today)
            ->where('status', 'late')
            ->count();
        $employeeAttendanceRate = $totalEmployees > 0 ? round((($employeePresentToday + $employeeLateToday) / $totalEmployees) * 100, 1) : 0;
        
        // Admin statistics (with table existence check)
        $totalAdmins = User::where('role', 'admin')->count();
        $adminPresentToday = 0;
        $adminAbsentToday = 0;
        
        // Check if admin_attendances table exists
        if (DB::getSchemaBuilder()->hasTable('admin_attendances')) {
            try {
                $adminPresentToday = DB::table('admin_attendances')
                    ->where('date', $today)
                    ->where('status', 'present')
                    ->count();
                $adminAbsentToday = DB::table('admin_attendances')
                    ->where('date', $today)
                    ->where('status', 'absent')
                    ->count();
            } catch (\Exception $e) {
                // Query failed, use fallback
                $adminPresentToday = max(0, $totalAdmins - 2);
                $adminAbsentToday = min(2, $totalAdmins);
            }
        } else {
            // Table doesn't exist, use fallback data
            $adminPresentToday = max(0, $totalAdmins - 2);
            $adminAbsentToday = min(2, $totalAdmins);
        }
        
        $adminAttendanceRate = $totalAdmins > 0 ? round(($adminPresentToday / $totalAdmins) * 100, 1) : 0;
        
        // Manager statistics (with table existence check)
        $totalManagers = User::where('role', 'manager')->count();
        $managerPresentToday = 0;
        $managerAbsentToday = 0;
        
        // Check if manager_attendances table exists
        if (DB::getSchemaBuilder()->hasTable('manager_attendances')) {
            try {
                $managerPresentToday = DB::table('manager_attendances')
                    ->where('date', $today)
                    ->where('status', 'present')
                    ->count();
                $managerAbsentToday = DB::table('manager_attendances')
                    ->where('date', $today)
                    ->where('status', 'absent')
                    ->count();
            } catch (\Exception $e) {
                // Query failed, use fallback
                $managerPresentToday = max(0, $totalManagers - 1);
                $managerAbsentToday = min(1, $totalManagers);
            }
        } else {
            // Table doesn't exist, use fallback data
            $managerPresentToday = max(0, $totalManagers - 1);
            $managerAbsentToday = min(1, $totalManagers);
        }
        
        $managerAttendanceRate = $totalManagers > 0 ? round(($managerPresentToday / $totalManagers) * 100, 1) : 0;
        
        // Compile attendance statistics
        $attendanceStats = [
            // Employee stats
            'total_employees' => $totalEmployees,
            'employee_present_today' => $employeePresentToday,
            'employee_absent_today' => $employeeAbsentToday,
            'employee_late_today' => $employeeLateToday,
            'employee_attendance_rate' => $employeeAttendanceRate,
            
            // Admin stats
            'total_admins' => $totalAdmins,
            'admin_present_today' => $adminPresentToday,
            'admin_absent_today' => $adminAbsentToday,
            'admin_attendance_rate' => $adminAttendanceRate,
            
            // Manager stats
            'total_managers' => $totalManagers,
            'manager_present_today' => $managerPresentToday,
            'manager_absent_today' => $managerAbsentToday,
            'manager_attendance_rate' => $managerAttendanceRate
        ];

        return view('dashboards.Admin.attendance.index', compact('attendanceRecords', 'employees', 'departments', 'leaveData', 'attendanceStats'));
    }

    /**
     * Show admin attendance records
     */
    public function showAdminAttendance(Request $request): View
    {
        // Build query for admin attendance records with filters
        $query = DB::table('admin_attendances')
            ->join('users', 'admin_attendances.user_id', '=', 'users.id')
            ->select('admin_attendances.*', 'users.name as admin_name');
        
        // Apply filters if provided
        if ($request->has('date') && $request->date) {
            $query->where('admin_attendances.date', $request->date);
        }
        
        if ($request->has('status') && $request->status) {
            $query->where('admin_attendances.status', $request->status);
        }
        
        // Get filtered records with pagination
        $attendanceRecords = $query->orderBy('admin_attendances.date', 'desc')
            ->paginate(10)
            ->appends($request->except('page'));
        
        // Get admins for the dropdown
        $admins = DB::table('users')
            ->where('role', 'admin')
            ->select('id', 'name')
            ->get();
        
        return view('dashboards.Admin.attendance.admin', compact('attendanceRecords', 'admins'));
    }

    /**
     * Show employee attendance records
     */
    public function showEmployeeAttendance(Request $request): View
    {
        // Build query for employee attendance records with filters
        $query = DB::table('employee_attendances')
            ->join('users', 'employee_attendances.user_id', '=', 'users.id')
            ->select('employee_attendances.*', 'users.name as employee_name');
        
        // Apply filters if provided
        if ($request->has('date') && $request->date) {
            $query->where('employee_attendances.date', $request->date);
        }
        
        if ($request->has('status') && $request->status) {
            $query->where('employee_attendances.status', $request->status);
        }
        
        // Get filtered records with pagination
        $attendanceRecords = $query->orderBy('employee_attendances.date', 'desc')
            ->paginate(10)
            ->appends($request->except('page'));
        
        // Get employees for the dropdown
        $employees = DB::table('users')
            ->where('role', 'employee')
            ->select('id', 'name')
            ->get();
        
        return view('dashboards.Admin.attendance.employee', compact('attendanceRecords', 'employees'));
    }

    /**
     * Handle clock in request
     */
    public function clockIn(Request $request): RedirectResponse
    {
        try {
            $userId = Auth::id();
            $today = date('Y-m-d');
            
            // Check if already clocked in today
            $existingRecord = DB::table('employee_attendances')
                ->where('user_id', $userId)
                ->where('date', $today)
                ->first();
            
            if ($existingRecord && $existingRecord->check_in) {
                return redirect()->back()->with('error', 'You have already clocked in today!');
            }
            
            if ($existingRecord) {
                // Update existing record
                DB::table('employee_attendances')
                    ->where('id', $existingRecord->id)
                    ->update([
                        'check_in' => date('H:i:s'),
                        'updated_at' => now()
                    ]);
            } else {
                // Create new record
                DB::table('employee_attendances')->insert([
                    'user_id' => $userId,
                    'date' => $today,
                    'check_in' => date('H:i:s'),
                    'status' => 'present',
                    'created_at' => now(),
                    'updated_at' => now()
                ]);
            }
            
            return redirect()->back()->with('success', 'Successfully clocked in!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to clock in. Please try again.');
        }
    }

    /**
     * Handle clock out request
     */
    public function clockOut(Request $request): RedirectResponse
    {
        try {
            $userId = Auth::id();
            $today = date('Y-m-d');
            
            // Get today's attendance record
            $attendanceRecord = DB::table('employee_attendances')
                ->where('user_id', $userId)
                ->where('date', $today)
                ->first();
            
            if (!$attendanceRecord) {
                return redirect()->back()->with('error', 'You have not clocked in today!');
            }
            
            if ($attendanceRecord->check_out) {
                return redirect()->back()->with('error', 'You have already clocked out today!');
            }
            
            // Calculate total hours
            $checkInTime = strtotime($today . ' ' . $attendanceRecord->check_in);
            $checkOutTime = strtotime($today . ' ' . date('H:i:s'));
            $totalMinutes = ($checkOutTime - $checkInTime) / 60;
            
            // Update record
            DB::table('employee_attendances')
                ->where('id', $attendanceRecord->id)
                ->update([
                    'check_out' => date('H:i:s'),
                    'total_hours' => $totalMinutes,
                    'updated_at' => now()
                ]);
            
            return redirect()->back()->with('success', 'Successfully clocked out!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to clock out. Please try again.');
        }
    }

    /**
     * Handle manual entry request
     */
    public function manualEntry(Request $request): RedirectResponse
    {
        try {
            // Validate request
            $request->validate([
                'employee_id' => 'required|exists:users,id',
                'date' => 'required|date',
                'status' => 'required|in:present,absent,late,half_day,on_leave',
                'check_in' => 'nullable|date_format:H:i',
                'check_out' => 'nullable|date_format:H:i',
                'notes' => 'nullable|string|max:500'
            ]);
            
            $data = $request->all();
            
            // Check if record already exists for this employee and date
            $existingRecord = DB::table('employee_attendances')
                ->where('user_id', $data['employee_id'])
                ->where('date', $data['date'])
                ->first();
            
            // Calculate total hours if both check in and check out are provided
            $totalMinutes = null;
            if ($data['check_in'] && $data['check_out']) {
                $checkInTime = strtotime($data['date'] . ' ' . $data['check_in']);
                $checkOutTime = strtotime($data['date'] . ' ' . $data['check_out']);
                $totalMinutes = ($checkOutTime - $checkInTime) / 60;
                
                // Validate that check out time is after check in time
                if ($checkOutTime <= $checkInTime) {
                    return redirect()->back()->with('error', 'Check out time must be after check in time.')->withInput();
                }
            }
            
            // Additional validation for status
            if (in_array($data['status'], ['absent', 'on_leave']) && ($data['check_in'] || $data['check_out'])) {
                return redirect()->back()->with('error', 'Cannot set check in/out times for absent or on leave status.')->withInput();
            }
            
            if ($existingRecord) {
                // Update existing record
                DB::table('employee_attendances')
                    ->where('id', $existingRecord->id)
                    ->update([
                        'check_in' => $data['check_in'],
                        'check_out' => $data['check_out'],
                        'total_hours' => $totalMinutes,
                        'status' => $data['status'],
                        'notes' => $data['notes'] ?? null,
                        'is_manual' => true,
                        'marked_by' => Auth::id(),
                        'updated_at' => now()
                    ]);
                    
                return redirect()->back()->with('success', 'Attendance record updated successfully!');
            } else {
                // Create new record
                DB::table('employee_attendances')->insert([
                    'user_id' => $data['employee_id'],
                    'date' => $data['date'],
                    'check_in' => $data['check_in'],
                    'check_out' => $data['check_out'],
                    'total_hours' => $totalMinutes,
                    'status' => $data['status'],
                    'notes' => $data['notes'] ?? null,
                    'is_manual' => true,
                    'marked_by' => Auth::id(),
                    'created_at' => now(),
                    'updated_at' => now()
                ]);
                
                return redirect()->back()->with('success', 'Attendance entry added successfully!');
            }
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to save attendance entry. Please try again.')->withInput();
        }
    }

    /**
     * Update an existing attendance record.
     */
    public function updateEntry(Request $request, $id): RedirectResponse
    {
        try {
            // Validate request
            $request->validate([
                'employee_id' => 'required|exists:users,id',
                'date' => 'required|date',
                'status' => 'required|in:present,absent,late,half_day,on_leave',
                'check_in' => 'nullable|date_format:H:i',
                'check_out' => 'nullable|date_format:H:i',
                'notes' => 'nullable|string|max:500'
            ]);
            
            $data = $request->all();
            
            // Calculate total hours if both check in and check out are provided
            $totalMinutes = null;
            if ($data['check_in'] && $data['check_out']) {
                $checkInTime = strtotime($data['date'] . ' ' . $data['check_in']);
                $checkOutTime = strtotime($data['date'] . ' ' . $data['check_out']);
                $totalMinutes = ($checkOutTime - $checkInTime) / 60;
                
                // Validate that check out time is after check in time
                if ($checkOutTime <= $checkInTime) {
                    return redirect()->back()->with('error', 'Check out time must be after check in time.')->withInput();
                }
            }
            
            // Additional validation for status
            if (in_array($data['status'], ['absent', 'on_leave']) && ($data['check_in'] || $data['check_out'])) {
                return redirect()->back()->with('error', 'Cannot set check in/out times for absent or on leave status.')->withInput();
            }
            
            // Update record
            DB::table('employee_attendances')
                ->where('id', $id)
                ->update([
                    'user_id' => $data['employee_id'],
                    'date' => $data['date'],
                    'check_in' => $data['check_in'],
                    'check_out' => $data['check_out'],
                    'total_hours' => $totalMinutes,
                    'status' => $data['status'],
                    'notes' => $data['notes'] ?? null,
                    'is_manual' => true,
                    'marked_by' => Auth::id(),
                    'updated_at' => now()
                ]);
                
            return redirect()->back()->with('success', 'Attendance record updated successfully!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to update attendance record. Please try again.')->withInput();
        }
    }

    /**
     * Delete an attendance record.
     */
    public function deleteEntry($id): RedirectResponse
    {
        try {
            // Check if record exists
            $record = DB::table('employee_attendances')->where('id', $id)->first();
            
            if (!$record) {
                return redirect()->back()->with('error', 'Attendance record not found.');
            }
            
            // Delete record
            DB::table('employee_attendances')
                ->where('id', $id)
                ->delete();
                
            return redirect()->back()->with('success', 'Attendance record deleted successfully!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to delete attendance record. Please try again.');
        }
    }

    /**
     * Show leave count dashboard
     */
    public function showLeaveCount(Request $request): View
    {
        // Get all employees with their leave balances
        $employees = DB::table('users')
            ->leftJoin('leave_balances', function($join) {
                $join->on('users.id', '=', 'leave_balances.user_id')
                     ->where('leave_balances.year', '=', date('Y'));
            })
            ->where('users.role', 'employee')
            ->select(
                'users.id',
                'users.name',
                'users.email',
                'leave_balances.annual_leaves',
                'leave_balances.sick_leaves',
                'leave_balances.maternity_leaves',
                'leave_balances.paternity_leaves',
                'leave_balances.emergency_leaves',
                'leave_balances.compensatory_leaves',
                'leave_balances.used_annual_leaves',
                'leave_balances.used_sick_leaves',
                'leave_balances.used_maternity_leaves',
                'leave_balances.used_paternity_leaves',
                'leave_balances.used_emergency_leaves',
                'leave_balances.used_compensatory_leaves'
            )
            ->get();
        
        // Calculate remaining leaves for each employee
        $leaveData = $employees->map(function($employee) {
            return [
                'id' => $employee->id,
                'name' => $employee->name,
                'email' => $employee->email,
                'annual_leaves' => $employee->annual_leaves ?? 21,
                'sick_leaves' => $employee->sick_leaves ?? 10,
                'maternity_leaves' => $employee->maternity_leaves ?? 90,
                'paternity_leaves' => $employee->paternity_leaves ?? 15,
                'emergency_leaves' => $employee->emergency_leaves ?? 5,
                'compensatory_leaves' => $employee->compensatory_leaves ?? 0,
                'used_annual_leaves' => $employee->used_annual_leaves ?? 0,
                'used_sick_leaves' => $employee->used_sick_leaves ?? 0,
                'used_maternity_leaves' => $employee->used_maternity_leaves ?? 0,
                'used_paternity_leaves' => $employee->used_paternity_leaves ?? 0,
                'used_emergency_leaves' => $employee->used_emergency_leaves ?? 0,
                'used_compensatory_leaves' => $employee->used_compensatory_leaves ?? 0,
                'remaining_annual_leaves' => ($employee->annual_leaves ?? 21) - ($employee->used_annual_leaves ?? 0),
                'remaining_sick_leaves' => ($employee->sick_leaves ?? 10) - ($employee->used_sick_leaves ?? 0),
                'remaining_maternity_leaves' => ($employee->maternity_leaves ?? 90) - ($employee->used_maternity_leaves ?? 0),
                'remaining_paternity_leaves' => ($employee->paternity_leaves ?? 15) - ($employee->used_paternity_leaves ?? 0),
                'remaining_emergency_leaves' => ($employee->emergency_leaves ?? 5) - ($employee->used_emergency_leaves ?? 0),
                'remaining_compensatory_leaves' => ($employee->compensatory_leaves ?? 0) - ($employee->used_compensatory_leaves ?? 0),
            ];
        });
        
        return view('dashboards.Admin.attendance.leave-count', compact('leaveData'));
    }

    /**
     * Update employee leave balance
     */
    public function updateLeaveBalance(Request $request): RedirectResponse
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'annual_leaves' => 'required|integer|min:0',
            'sick_leaves' => 'required|integer|min:0',
            'maternity_leaves' => 'required|integer|min:0',
            'paternity_leaves' => 'required|integer|min:0',
            'emergency_leaves' => 'required|integer|min:0',
            'compensatory_leaves' => 'required|integer|min:0',
            'used_annual_leaves' => 'required|integer|min:0',
            'used_sick_leaves' => 'required|integer|min:0',
            'used_maternity_leaves' => 'required|integer|min:0',
            'used_paternity_leaves' => 'required|integer|min:0',
            'used_emergency_leaves' => 'required|integer|min:0',
            'used_compensatory_leaves' => 'required|integer|min:0',
        ]);
        
        // Check if leave balance record exists for this user and year
        $leaveBalance = DB::table('leave_balances')
            ->where('user_id', $request->user_id)
            ->where('year', date('Y'))
            ->first();
        
        $data = [
            'user_id' => $request->user_id,
            'year' => date('Y'),
            'annual_leaves' => $request->annual_leaves,
            'sick_leaves' => $request->sick_leaves,
            'maternity_leaves' => $request->maternity_leaves,
            'paternity_leaves' => $request->paternity_leaves,
            'emergency_leaves' => $request->emergency_leaves,
            'compensatory_leaves' => $request->compensatory_leaves,
            'used_annual_leaves' => $request->used_annual_leaves,
            'used_sick_leaves' => $request->used_sick_leaves,
            'used_maternity_leaves' => $request->used_maternity_leaves,
            'used_paternity_leaves' => $request->used_paternity_leaves,
            'used_emergency_leaves' => $request->used_emergency_leaves,
            'used_compensatory_leaves' => $request->used_compensatory_leaves,
            'updated_at' => now()
        ];
        
        if ($leaveBalance) {
            // Update existing record
            DB::table('leave_balances')
                ->where('id', $leaveBalance->id)
                ->update($data);
        } else {
            // Create new record
            $data['created_at'] = now();
            DB::table('leave_balances')->insert($data);
        }
        
        return redirect()->back()->with('success', 'Leave balance updated successfully!');
    }

    /**
     * Show all designations
     */
    public function showDesignations(): View
    {
        // Get all designations with department relationships and employee counts
        $designations = Designation::with('department')
            ->withCount('users as employees_count')
            ->get();

        // Get departments for the dropdown
        $departments = Department::all();

        return view('dashboards.Admin.designations', compact('designations', 'departments'));
    }

    /**
     * Create a new designation
     */
    public function createDesignation(Request $request): RedirectResponse
    {
        try {
            $request->validate([
                'title' => 'required|string|max:255',
                'description' => 'nullable|string',
                'department_id' => 'nullable|exists:departments,id',
                'min_salary' => 'nullable|numeric|min:0',
                'max_salary' => 'nullable|numeric|min:0',
                'requirements' => 'nullable|string',
                'is_active' => 'boolean'
            ]);

            // Additional validation for salary range
            if ($request->min_salary && $request->max_salary && $request->min_salary >= $request->max_salary) {
                return redirect()->back()->with('error', 'Maximum salary must be greater than minimum salary.')->withInput();
            }

            // Create the designation
            Designation::create([
                'title' => $request->title,
                'description' => $request->description,
                'department_id' => $request->department_id,
                'min_salary' => $request->min_salary,
                'max_salary' => $request->max_salary,
                'requirements' => $request->requirements ? [$request->requirements] : null,
                'is_active' => $request->has('is_active') ? true : false
            ]);

            return redirect()->back()->with('success', 'Designation created successfully!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to create designation. Please try again.')->withInput();
        }
    }

    /**
     * Show a specific designation
     */
    public function showDesignation($id): View
    {
        $designation = Designation::with('department')
            ->withCount('users as employees_count')
            ->findOrFail($id);

        return view('dashboards.Admin.designation-details', compact('designation'));
    }

    /**
     * Update a designation
     */
    public function updateDesignation(Request $request, $id): RedirectResponse
    {
        try {
            $request->validate([
                'title' => 'required|string|max:255',
                'description' => 'nullable|string',
                'department_id' => 'nullable|exists:departments,id',
                'min_salary' => 'nullable|numeric|min:0',
                'max_salary' => 'nullable|numeric|min:0',
                'requirements' => 'nullable|string',
                'is_active' => 'boolean'
            ]);

            // Additional validation for salary range
            if ($request->min_salary && $request->max_salary && $request->min_salary >= $request->max_salary) {
                return redirect()->back()->with('error', 'Maximum salary must be greater than minimum salary.')->withInput();
            }

            $designation = Designation::findOrFail($id);
            $designation->update([
                'title' => $request->title,
                'description' => $request->description,
                'department_id' => $request->department_id,
                'min_salary' => $request->min_salary,
                'max_salary' => $request->max_salary,
                'requirements' => $request->requirements ? [$request->requirements] : null,
                'is_active' => $request->has('is_active') ? true : false
            ]);

            return redirect()->back()->with('success', 'Designation updated successfully!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to update designation. Please try again.')->withInput();
        }
    }

    /**
     * Delete a designation
     */
    public function deleteDesignation($id): RedirectResponse
    {
        try {
            $designation = Designation::findOrFail($id);
            
            // Check if any employees are assigned to this designation
            $employeeCount = $designation->users()->count();
            if ($employeeCount > 0) {
                return redirect()->back()->with('error', "Cannot delete designation. {$employeeCount} employee(s) are currently assigned to this designation. Please reassign them first.");
            }
            
            $designation->delete();
            
            return redirect()->back()->with('success', 'Designation deleted successfully!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to delete designation. Please try again.');
        }
    }
}