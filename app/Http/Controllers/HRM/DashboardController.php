<?php

namespace App\Http\Controllers\HRM;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\EmployeeAttendance;
use App\Models\EmployeeLeave;
use App\Models\PersonalLoan;
use App\Models\OfficeLoan;
use App\Models\Holiday;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $today = Carbon::today();
        
        // Employee statistics
        $totalEmployees = User::where('role', '!=', 'admin')->count();
        $activeEmployees = User::whereHas('employeeProfile', function($query) {
            $query->where('status', 'active');
        })->count();
        
        // Attendance statistics
        $todayAttendance = EmployeeAttendance::where('date', $today)->count();
        $presentToday = EmployeeAttendance::where('date', $today)
            ->where('status', 'present')->count();
        
        // Leave statistics
        $pendingLeaves = EmployeeLeave::where('status', 'pending')->count();
        $onLeaveToday = EmployeeLeave::where('start_date', '<=', $today)
            ->where('end_date', '>=', $today)
            ->where('status', 'approved')->count();
        
        // Loan statistics
        $pendingPersonalLoans = PersonalLoan::where('status', 'pending')->count();
        $pendingOfficeLoans = OfficeLoan::where('status', 'pending')->count();
        
        // Upcoming holidays
        $upcomingHolidays = Holiday::where('date', '>', $today)
            ->where('is_active', true)
            ->orderBy('date')
            ->limit(5)
            ->get();
        
        // Recent activities (last 10 activities)
        $recentActivities = collect();
        
        // Add recent leaves
        $recentLeaves = EmployeeLeave::with('user')
            ->latest()
            ->limit(5)
            ->get()
            ->map(function($leave) {
                return [
                    'type' => 'leave',
                    'message' => $leave->user->name . ' applied for ' . $leave->leave_type . ' leave',
                    'date' => $leave->created_at,
                    'status' => $leave->status
                ];
            });
        
        $recentActivities = $recentActivities->merge($recentLeaves);
        
        // Add recent loans
        $recentLoans = PersonalLoan::with('user')
            ->latest()
            ->limit(3)
            ->get()
            ->map(function($loan) {
                return [
                    'type' => 'loan',
                    'message' => $loan->user->name . ' applied for personal loan of $' . number_format($loan->amount, 2),
                    'date' => $loan->created_at,
                    'status' => $loan->status
                ];
            });
        
        $recentActivities = $recentActivities->merge($recentLoans);
        
        // Sort by date and take latest 10
        $recentActivities = $recentActivities->sortByDesc('date')->take(10);
        
        return view('hrm.dashboard', compact(
            'totalEmployees',
            'activeEmployees',
            'todayAttendance',
            'presentToday',
            'pendingLeaves',
            'onLeaveToday',
            'pendingPersonalLoans',
            'pendingOfficeLoans',
            'upcomingHolidays',
            'recentActivities'
        ));
    }
}
