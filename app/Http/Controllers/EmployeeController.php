<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\EmployeeProfile;

class EmployeeController extends Controller
{
    /**
     * Display the employee dashboard
     */
    public function dashboard(): View
    {
        $user = Auth::user();
        
        // Get employee profile data
        $profile = $user->employeeProfile;
        
        // Calculate leave balance
        $leaveBalance = $this->calculateLeaveBalance($user);
        
        // Get current month salary
        $currentSalary = $profile ? $profile->salary : 0;
        
        // Get attendance stats for this week
        $weeklyHours = $this->getWeeklyHours($user);
        
        // Get pending tasks (mock for now)
        $pendingTasks = 3;
        
        // Get employee stats
        $stats = [
            'leave_balance' => $leaveBalance,
            'salary_this_month' => number_format($currentSalary, 0),
            'pending_tasks' => $pendingTasks,
            'hours_this_week' => $weeklyHours
        ];
        
        // Get recent activities for the employee
        $recentActivities = $this->getRecentActivities($user);

        return view('dashboards.Employees.employee', compact('stats', 'recentActivities'));
    }

    /**
     * Calculate employee leave balance
     */
    private function calculateLeaveBalance($user)
    {
        // Check if leave balance exists
        $leaveBalance = DB::table('leave_balances')
            ->where('user_id', $user->id)
            ->where('year', date('Y'))
            ->first();
            
        if ($leaveBalance) {
            $totalLeaves = $leaveBalance->annual_leaves + $leaveBalance->sick_leaves;
            $usedLeaves = $leaveBalance->used_annual_leaves + $leaveBalance->used_sick_leaves;
            return max(0, $totalLeaves - $usedLeaves);
        }
        
        return 12; // Default leave balance
    }

    /**
     * Get weekly working hours
     */
    private function getWeeklyHours($user)
    {
        $startOfWeek = now()->startOfWeek();
        $endOfWeek = now()->endOfWeek();
        
        // Get attendance records for this week
        $attendances = DB::table('employee_attendances')
            ->where('user_id', $user->id)
            ->whereBetween('date', [$startOfWeek->format('Y-m-d'), $endOfWeek->format('Y-m-d')])
            ->where('status', 'present')
            ->whereNotNull('check_in')
            ->get();
        
        $totalHours = 0;
        
        foreach ($attendances as $attendance) {
            if ($attendance->total_hours) {
                // Use total_hours from database (convert from minutes to hours)
                $totalHours += $attendance->total_hours / 60;
            } elseif ($attendance->check_out) {
                // Calculate hours from check_in and check_out
                $checkIn = strtotime($attendance->check_in);
                $checkOut = strtotime($attendance->check_out);
                $hours = ($checkOut - $checkIn) / 3600;
                $totalHours += $hours;
            } else {
                // If only checked in, assume 8 hours for present days
                $totalHours += 8;
            }
        }
        
        return round($totalHours, 1) ?: 0; // Return calculated hours or 0 if no data
    }

    /**
     * Get recent activities
     */
    private function getRecentActivities($user)
    {
        $activities = [];
        
        // Get recent attendance
        $recentAttendance = DB::table('employee_attendances')
            ->where('user_id', $user->id)
            ->orderBy('date', 'desc')
            ->first();
            
        if ($recentAttendance && $recentAttendance->check_in) {
            $activities[] = [
                'icon' => 'clock',
                'color' => 'success',
                'message' => 'Checked in at ' . date('g:i A', strtotime($recentAttendance->check_in)),
                'time' => 'Today'
            ];
        }
        
        // Get recent leave requests
        $recentLeave = DB::table('employee_leaves')
            ->where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->first();
            
        if ($recentLeave) {
            $activities[] = [
                'icon' => 'calendar-event',
                'color' => 'info',
                'message' => 'Submitted ' . ucfirst($recentLeave->leave_type) . ' leave request',
                'time' => date('M d, Y', strtotime($recentLeave->created_at))
            ];
        }
        
        // Add default activities if no data
        if (empty($activities)) {
            $activities = [
                ['icon' => 'check-circle', 'color' => 'success', 'message' => 'Profile updated successfully', 'time' => '2 hours ago'],
                ['icon' => 'clock', 'color' => 'warning', 'message' => 'Clocked in at 9:00 AM', 'time' => 'Today'],
                ['icon' => 'file-earmark-text', 'color' => 'primary', 'message' => 'Payslip available for download', 'time' => 'Yesterday']
            ];
        }
        
        return $activities;
    }

    /**
     * Handle clock in/out functionality
     */
    public function clockInOut(Request $request): RedirectResponse
    {
        $user = Auth::user();
        $action = $request->input('action', 'in');
        $today = now()->format('Y-m-d');
        $currentTime = now()->format('H:i:s');
        
        try {
            // Check if attendance record exists for today
            $attendance = DB::table('employee_attendances')
                ->where('user_id', $user->id)
                ->where('date', $today)
                ->first();
            
            if ($action === 'in') {
                if ($attendance && $attendance->check_in) {
                    return redirect()->route('employee.dashboard')
                        ->with('error', 'You have already checked in today at ' . date('g:i A', strtotime($attendance->check_in)));
                }
                
                // Create or update attendance record
                if ($attendance) {
                    DB::table('employee_attendances')
                        ->where('id', $attendance->id)
                        ->update([
                            'check_in' => $currentTime,
                            'status' => 'present',
                            'updated_at' => now()
                        ]);
                } else {
                    DB::table('employee_attendances')->insert([
                        'user_id' => $user->id,
                        'date' => $today,
                        'check_in' => $currentTime,
                        'status' => 'present',
                        'created_at' => now(),
                        'updated_at' => now()
                    ]);
                }
                
                $message = 'Successfully checked in at ' . now()->format('g:i A');
                
            } else { // check out
                if (!$attendance || !$attendance->check_in) {
                    return redirect()->route('employee.dashboard')
                        ->with('error', 'You need to check in first before checking out.');
                }
                
                if ($attendance->check_out) {
                    return redirect()->route('employee.dashboard')
                        ->with('error', 'You have already checked out today at ' . date('g:i A', strtotime($attendance->check_out)));
                }
                
                // Calculate hours worked
                $checkIn = strtotime($attendance->check_in);
                $checkOut = strtotime($currentTime);
                $hoursWorked = round(($checkOut - $checkIn) / 3600, 2);
                $totalMinutes = round(($checkOut - $checkIn) / 60);
                
                // Update attendance record
                DB::table('employee_attendances')
                    ->where('id', $attendance->id)
                    ->update([
                        'check_out' => $currentTime,
                        'total_hours' => $totalMinutes,
                        'updated_at' => now()
                    ]);
                
                $message = 'Successfully checked out at ' . now()->format('g:i A') . '. Total hours: ' . $hoursWorked;
            }
            
            return redirect()->route('employee.dashboard')
                ->with('success', $message);
                
        } catch (\Exception $e) {
            return redirect()->route('employee.dashboard')
                ->with('error', 'Failed to record attendance. Please try again.');
        }
    }

    /**
     * Show leave request form
     */
    public function showLeaveRequest(): View
    {
        return view('dashboards.Employees.leave-request');
    }

    /**
     * Submit leave request
     */
    public function submitLeaveRequest(Request $request): RedirectResponse
    {
        // Add debugging
        \Log::info('Leave request submission started', [
            'user_id' => Auth::id(),
            'request_data' => $request->all()
        ]);

        try {
            $request->validate([
                'start_date' => 'required|date',
                'end_date' => 'required|date|after_or_equal:start_date',
                'reason' => 'required|string|max:500',
                'leave_type' => 'required|in:annual,sick,maternity,paternity,emergency'
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            \Log::error('Validation failed', [
                'errors' => $e->errors(),
                'request_data' => $request->all()
            ]);
            throw $e;
        }

        $user = Auth::user();
        
        try {
            // Calculate total days
            $startDate = new \DateTime($request->start_date);
            $endDate = new \DateTime($request->end_date);
            $totalDays = $startDate->diff($endDate)->days + 1;
            
            // Check for overlapping leave requests
            $existingLeave = DB::table('employee_leaves')
                ->where('user_id', $user->id)
                ->where('status', '!=', 'rejected')
                ->where(function($query) use ($request) {
                    $query->whereBetween('start_date', [$request->start_date, $request->end_date])
                          ->orWhereBetween('end_date', [$request->start_date, $request->end_date])
                          ->orWhere(function($q) use ($request) {
                              $q->where('start_date', '<=', $request->start_date)
                                ->where('end_date', '>=', $request->end_date);
                          });
                })
                ->exists();
                
            if ($existingLeave) {
                return redirect()->back()
                    ->with('error', 'You already have a leave request for the selected dates.')
                    ->withInput();
            }
            
            // Create leave request
            DB::table('employee_leaves')->insert([
                'user_id' => $user->id,
                'leave_type' => $request->leave_type,
                'start_date' => $request->start_date,
                'end_date' => $request->end_date,
                'total_days' => $totalDays,
                'reason' => $request->reason,
                'status' => 'pending',
                'application_date' => now()->format('Y-m-d'),
                'created_at' => now(),
                'updated_at' => now()
            ]);
            
            \Log::info('Leave request submitted successfully', [
                'user_id' => $user->id,
                'total_days' => $totalDays
            ]);

            return redirect()->route('employee.dashboard')
                ->with('success', "Leave request submitted successfully! Total days: {$totalDays}. Your manager will review it shortly.");
                
        } catch (\Exception $e) {
            \Log::error('Leave request submission failed', [
                'user_id' => $user->id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            // Show detailed error for debugging
            return redirect()->back()
                ->with('error', 'Failed to submit leave request. Error: ' . $e->getMessage() . ' (Line: ' . $e->getLine() . ')')
                ->withInput();
        }
    }

    /**
     * Show employee profile
     */
    public function showProfile(): View
    {
        $user = Auth::user();
        return view('dashboards.Employees.profile', compact('user'));
    }

    /**
     * Update employee profile
     */
    public function updateProfile(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . Auth::id(),
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:500',
            'date_of_birth' => 'nullable|date',
            'emergency_contact' => 'nullable|string|max:100'
        ]);

        $user = Auth::user();
        
        try {
            // Update user table
            $user->update($request->only(['name', 'email']));
            
            // Update or create employee profile
            $profileData = [
                'phone' => $request->phone,
                'address' => $request->address,
                'date_of_birth' => $request->date_of_birth,
                'emergency_contact' => $request->emergency_contact,
                'updated_at' => now()
            ];
            
            if ($user->employeeProfile) {
                $user->employeeProfile->update($profileData);
            } else {
                $profileData['user_id'] = $user->id;
                $profileData['employee_id'] = 'EMP' . str_pad($user->id, 4, '0', STR_PAD_LEFT);
                $profileData['first_name'] = explode(' ', $user->name)[0] ?? '';
                $profileData['last_name'] = explode(' ', $user->name)[1] ?? '';
                $profileData['employment_type'] = 'full_time';
                $profileData['status'] = 'active';
                $profileData['created_at'] = now();
                
                \App\Models\EmployeeProfile::create($profileData);
            }
            
            return redirect()->route('employee.profile')
                ->with('success', 'Profile updated successfully!');
                
        } catch (\Exception $e) {
            return redirect()->route('employee.profile')
                ->with('error', 'Failed to update profile. Please try again.');
        }
    }

    /**
     * Show payslips
     */
    public function showPayslips(): View
    {
        // Mock payslip data
        $payslips = [
            ['month' => 'November 2024', 'amount' => '$3,200', 'status' => 'Paid', 'date' => '2024-11-30'],
            ['month' => 'October 2024', 'amount' => '$3,200', 'status' => 'Paid', 'date' => '2024-10-31'],
            ['month' => 'September 2024', 'amount' => '$3,200', 'status' => 'Paid', 'date' => '2024-09-30'],
        ];

        return view('dashboards.Employees.payslips', compact('payslips'));
    }

    /**
     * Download payslip
     */
    public function downloadPayslip(Request $request): RedirectResponse
    {
        $month = $request->input('month');
        
        // Here you would generate and return PDF
        // For now, just return with success message
        
        return redirect()->route('employee.payslips')
            ->with('success', "Payslip for {$month} downloaded successfully!");
    }

    /**
     * Show attendance history
     */
    public function showAttendance(): View
    {
        // Mock attendance data
        $attendance = [
            ['date' => '2024-12-11', 'clock_in' => '09:00', 'clock_out' => '18:00', 'hours' => '8.0', 'status' => 'Present'],
            ['date' => '2024-12-10', 'clock_in' => '09:15', 'clock_out' => '18:10', 'hours' => '7.9', 'status' => 'Present'],
            ['date' => '2024-12-09', 'clock_in' => '09:00', 'clock_out' => '17:30', 'hours' => '7.5', 'status' => 'Present'],
        ];

        return view('dashboards.Employees.attendance', compact('attendance'));
    }
}