<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class EmployeeController extends Controller
{
    /**
     * Display the employee dashboard
     */
    public function dashboard(): View
    {
        $user = Auth::user();
        
        // Get employee stats
        $stats = [
            'employees' => 15, // Team size
            'departments' => 1,
            'attendance_today' => 15, // Tasks completed
            'payroll_today' => '3,200' // Monthly salary
        ];
        
        // Get recent activities for the employee
        $recentActivities = [
            ['icon' => 'check-circle', 'color' => 'success', 'message' => 'Completed task: Monthly Report', 'time' => '2 hours ago'],
            ['icon' => 'calendar-event', 'color' => 'info', 'message' => 'Submitted leave request for Dec 25-26', 'time' => '4 hours ago'],
            ['icon' => 'clock', 'color' => 'warning', 'message' => 'Clocked in at 9:00 AM', 'time' => 'Today'],
            ['icon' => 'file-earmark-text', 'color' => 'primary', 'message' => 'Downloaded payslip for November 2024', 'time' => 'Yesterday']
        ];

        return view('dashboards.employee', compact('stats', 'recentActivities'));
    }

    /**
     * Handle clock in/out functionality
     */
    public function clockInOut(Request $request): RedirectResponse
    {
        $user = Auth::user();
        $action = $request->input('action', 'in');
        
        // Here you would typically save to attendance table
        // For now, we'll just return with a success message
        
        $message = $action === 'in' ? 
            'Successfully clocked in at ' . now()->format('H:i') : 
            'Successfully clocked out at ' . now()->format('H:i');
            
        return redirect()->route('employee.dashboard')
            ->with('success', $message);
    }

    /**
     * Show leave request form
     */
    public function showLeaveRequest(): View
    {
        return view('employee.leave-request');
    }

    /**
     * Submit leave request
     */
    public function submitLeaveRequest(Request $request): RedirectResponse
    {
        $request->validate([
            'start_date' => 'required|date|after_or_equal:today',
            'end_date' => 'required|date|after_or_equal:start_date',
            'reason' => 'required|string|max:500',
            'type' => 'required|in:sick,vacation,personal,emergency'
        ]);

        // Here you would save to leave_requests table
        // For now, we'll just return with success message
        
        return redirect()->route('employee.dashboard')
            ->with('success', 'Leave request submitted successfully! Your manager will review it shortly.');
    }

    /**
     * Show employee profile
     */
    public function showProfile(): View
    {
        $user = Auth::user();
        return view('employee.profile', compact('user'));
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
            'address' => 'nullable|string|max:500'
        ]);

        $user = Auth::user();
        $user->update($request->only(['name', 'email']));
        
        return redirect()->route('employee.profile')
            ->with('success', 'Profile updated successfully!');
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

        return view('employee.payslips', compact('payslips'));
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

        return view('employee.attendance', compact('attendance'));
    }
}