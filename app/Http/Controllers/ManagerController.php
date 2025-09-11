<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ManagerController extends Controller
{
    /**
     * Display the manager dashboard
     */
    public function dashboard(): View
    {
        $user = Auth::user();
        
        // Get manager stats
        $stats = [
            'employees' => 15, // Team members
            'departments' => 1,
            'attendance_today' => 12, // Present today
            'payroll_today' => '45K' // Team monthly payroll
        ];
        
        // Get recent team activities
        $recentActivities = [
            ['icon' => 'person-check', 'color' => 'success', 'message' => 'John Smith clocked in', 'time' => '2 hours ago'],
            ['icon' => 'calendar-event', 'color' => 'info', 'message' => 'Sarah Lee submitted leave request', 'time' => '4 hours ago'],
            ['icon' => 'check-circle', 'color' => 'warning', 'message' => 'Mike Davis completed project milestone', 'time' => '6 hours ago'],
            ['icon' => 'award', 'color' => 'primary', 'message' => 'Team performance review scheduled for Finance Team', 'time' => 'Yesterday']
        ];

        return view('dashboards.manager', compact('stats', 'recentActivities'));
    }

    /**
     * Show team members
     */
    public function showTeam(): View
    {
        // Mock team data
        $teamMembers = [
            ['id' => 1, 'name' => 'John Smith', 'email' => 'john@company.com', 'position' => 'Developer', 'status' => 'Active', 'join_date' => '2023-01-15'],
            ['id' => 2, 'name' => 'Sarah Lee', 'email' => 'sarah@company.com', 'position' => 'Designer', 'status' => 'Active', 'join_date' => '2023-03-10'],
            ['id' => 3, 'name' => 'Mike Davis', 'email' => 'mike@company.com', 'position' => 'Analyst', 'status' => 'Active', 'join_date' => '2023-06-01'],
        ];

        return view('manager.team', compact('teamMembers'));
    }

    /**
     * Show leave requests for approval
     */
    public function showLeaveRequests(): View
    {
        // Mock leave requests
        $leaveRequests = [
            ['id' => 1, 'employee' => 'John Smith', 'type' => 'Vacation', 'start_date' => '2024-12-25', 'end_date' => '2024-12-26', 'reason' => 'Christmas holiday', 'status' => 'Pending', 'submitted_at' => '2024-12-10'],
            ['id' => 2, 'employee' => 'Sarah Lee', 'type' => 'Sick', 'start_date' => '2024-12-15', 'end_date' => '2024-12-15', 'reason' => 'Medical appointment', 'status' => 'Pending', 'submitted_at' => '2024-12-09'],
        ];

        return view('manager.leave-requests', compact('leaveRequests'));
    }

    /**
     * Approve or reject leave request
     */
    public function handleLeaveRequest(Request $request): RedirectResponse
    {
        $request->validate([
            'request_id' => 'required|integer',
            'action' => 'required|in:approve,reject',
            'comments' => 'nullable|string|max:500'
        ]);

        $action = $request->input('action');
        $requestId = $request->input('request_id');
        
        // Here you would update the leave request in database
        
        $message = $action === 'approve' ? 
            'Leave request approved successfully!' : 
            'Leave request rejected.';
            
        return redirect()->route('manager.leave-requests')
            ->with('success', $message);
    }

    /**
     * Show team performance
     */
    public function showPerformance(): View
    {
        // Mock performance data
        $performanceData = [
            ['employee' => 'John Smith', 'score' => 85, 'completed_tasks' => 42, 'on_time_rate' => 95, 'rating' => 'Excellent'],
            ['employee' => 'Sarah Lee', 'score' => 92, 'completed_tasks' => 38, 'on_time_rate' => 98, 'rating' => 'Outstanding'],
            ['employee' => 'Mike Davis', 'score' => 78, 'completed_tasks' => 35, 'on_time_rate' => 89, 'rating' => 'Good'],
        ];

        return view('manager.performance', compact('performanceData'));
    }

    /**
     * Generate team reports
     */
    public function generateReports(Request $request): View
    {
        $reportType = $request->input('type', 'attendance');
        
        // Mock report data based on type
        $reportData = [];
        
        switch($reportType) {
            case 'attendance':
                $reportData = [
                    'title' => 'Team Attendance Report',
                    'period' => 'December 2024',
                    'data' => [
                        ['employee' => 'John Smith', 'present_days' => 20, 'absent_days' => 2, 'late_days' => 1],
                        ['employee' => 'Sarah Lee', 'present_days' => 22, 'absent_days' => 0, 'late_days' => 0],
                        ['employee' => 'Mike Davis', 'present_days' => 19, 'absent_days' => 3, 'late_days' => 2],
                    ]
                ];
                break;
            case 'productivity':
                $reportData = [
                    'title' => 'Team Productivity Report',
                    'period' => 'December 2024',
                    'data' => [
                        ['employee' => 'John Smith', 'tasks_completed' => 42, 'avg_completion_time' => '2.5 hours', 'efficiency' => '85%'],
                        ['employee' => 'Sarah Lee', 'tasks_completed' => 38, 'avg_completion_time' => '2.1 hours', 'efficiency' => '92%'],
                        ['employee' => 'Mike Davis', 'tasks_completed' => 35, 'avg_completion_time' => '3.2 hours', 'efficiency' => '78%'],
                    ]
                ];
                break;
        }

        return view('manager.reports', compact('reportData', 'reportType'));
    }

    /**
     * Show team attendance
     */
    public function showTeamAttendance(): View
    {
        // Mock attendance data
        $attendanceData = [
            ['employee' => 'John Smith', 'status' => 'Present', 'clock_in' => '09:00', 'clock_out' => '-', 'hours' => '3.5'],
            ['employee' => 'Sarah Lee', 'status' => 'Present', 'clock_in' => '08:45', 'clock_out' => '-', 'hours' => '3.8'],
            ['employee' => 'Mike Davis', 'status' => 'Absent', 'clock_in' => '-', 'clock_out' => '-', 'hours' => '0'],
        ];

        return view('manager.team-attendance', compact('attendanceData'));
    }

    /**
     * Send team message/announcement
     */
    public function sendTeamMessage(Request $request): RedirectResponse
    {
        $request->validate([
            'subject' => 'required|string|max:255',
            'message' => 'required|string|max:1000',
            'priority' => 'required|in:low,normal,high',
            'recipients' => 'required|array'
        ]);

        // Here you would save the message/announcement
        
        return redirect()->route('manager.dashboard')
            ->with('success', 'Message sent to team members successfully!');
    }
}