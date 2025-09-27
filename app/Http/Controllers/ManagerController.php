<?php

namespace App\Http\Controllers;

use App\Models\Message;
use App\Models\Notification;
use App\Models\ManagerSetting;
use App\Models\TeamMember;
use App\Models\PerformanceReview;
use App\Models\User;
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
        
        // Get real manager stats
        $teamMembersCount = TeamMember::forManager($user->id)->active()->count();
        $attendanceToday = TeamMember::forManager($user->id)
            ->whereHas('employee.attendance', function($q) {
                $q->whereDate('created_at', today())->where('status', 'present');
            })
            ->count();
        $pendingApprovals = \App\Models\LeaveRequest::where('status', 'pending')
            ->whereHas('user.teamMemberships', function($q) use ($user) {
                $q->where('manager_id', $user->id);
            })
            ->count();
        
        $stats = [
            'employees' => $teamMembersCount,
            'departments' => 1,
            'attendance_today' => $attendanceToday,
            'payroll_today' => $pendingApprovals // Using as pending approvals count
        ];
        
        // Get recent team activities from notifications
        $recentActivities = Notification::where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->take(4)
            ->get()
            ->map(function($notification) {
                return [
                    'icon' => $this->getIconForNotificationType($notification->type),
                    'color' => $this->getColorForNotificationType($notification->type),
                    'message' => $notification->message,
                    'time' => $notification->created_at->diffForHumans()
                ];
            })
            ->toArray();

        return view('dashboards.Manager.manager', compact('stats', 'recentActivities'));
    }

    /**
     * Get icon for notification type
     */
    private function getIconForNotificationType($type): string
    {
        return match($type) {
            'attendance' => 'person-check',
            'leave_request' => 'calendar-event',
            'task' => 'check-circle',
            default => 'award'
        };
    }

    /**
     * Get color for notification type
     */
    private function getColorForNotificationType($type): string
    {
        return match($type) {
            'attendance' => 'success',
            'leave_request' => 'info',
            'task' => 'warning',
            default => 'primary'
        };
    }

    /**
     * Show team members
     */
    public function showTeam(): View
    {
        $user = Auth::user();
        
        // Get real team members
        $teamMembers = TeamMember::forManager($user->id)
            ->with('employee')
            ->active()
            ->get()
            ->map(function($teamMember) {
                return [
                    'id' => $teamMember->id,
                    'name' => $teamMember->employee->name,
                    'email' => $teamMember->employee->email,
                    'position' => $teamMember->position ?? 'Not specified',
                    'status' => ucfirst($teamMember->status),
                    'join_date' => $teamMember->join_date->format('Y-m-d')
                ];
            })
            ->toArray();

        return view('manager.team', compact('teamMembers'));
    }

    /**
     * Show leave requests for approval
     */
    public function showLeaveRequests(): View
    {
        $user = Auth::user();
        
        // Get real leave requests from team members
        $leaveRequests = \App\Models\LeaveRequest::where('status', 'pending')
            ->whereHas('user.teamMemberships', function($q) use ($user) {
                $q->where('manager_id', $user->id);
            })
            ->with('user')
            ->orderBy('created_at', 'desc')
            ->get()
            ->map(function($request) {
                return [
                    'id' => $request->id,
                    'employee' => $request->user->name,
                    'type' => ucfirst($request->leave_type),
                    'start_date' => $request->start_date->format('Y-m-d'),
                    'end_date' => $request->end_date->format('Y-m-d'),
                    'reason' => $request->reason,
                    'status' => ucfirst($request->status),
                    'submitted_at' => $request->created_at->format('Y-m-d')
                ];
            })
            ->toArray();

        return view('manager.leave-requests', compact('leaveRequests'));
    }

    /**
     * Approve or reject leave request
     */
    public function handleLeaveRequest(Request $request): RedirectResponse
    {
        $request->validate([
            'request_id' => 'required|integer|exists:leave_requests,id',
            'action' => 'required|in:approve,reject',
            'comments' => 'nullable|string|max:500'
        ]);

        $action = $request->input('action');
        $requestId = $request->input('request_id');
        $comments = $request->input('comments');
        
        // Update the leave request in database
        $leaveRequest = \App\Models\LeaveRequest::findOrFail($requestId);
        $leaveRequest->update([
            'status' => $action === 'approve' ? 'approved' : 'rejected',
            'manager_comments' => $comments,
            'processed_by' => Auth::id(),
            'processed_at' => now()
        ]);
        
        // Create notification for employee
        Notification::createForUser(
            $leaveRequest->user_id,
            'Leave Request ' . ucfirst($action === 'approve' ? 'approved' : 'rejected'),
            "Your leave request from {$leaveRequest->start_date->format('M d')} to {$leaveRequest->end_date->format('M d')} has been {$action}d.",
            'leave_request',
            ['leave_request_id' => $requestId, 'action' => $action]
        );
            
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
        $user = Auth::user();
        
        // Get real performance data
        $performanceData = PerformanceReview::byReviewer($user->id)
            ->with('employee')
            ->completed()
            ->orderBy('updated_at', 'desc')
            ->get()
            ->map(function($review) {
                return [
                    'employee' => $review->employee->name,
                    'score' => $review->score ?? 0,
                    'completed_tasks' => $review->completed_tasks,
                    'on_time_rate' => $review->on_time_rate,
                    'rating' => ucfirst($review->rating)
                ];
            })
            ->toArray();

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

    /**
     * Show team messages
     */
    public function showMessages(): View
    {
        // Mock messages data
        $messages = [
            ['id' => 1, 'subject' => 'Team Meeting Tomorrow', 'from' => 'HR Department', 'date' => '2024-12-10', 'read' => false],
            ['id' => 2, 'subject' => 'Project Deadline Update', 'from' => 'Project Manager', 'date' => '2024-12-09', 'read' => true],
            ['id' => 3, 'subject' => 'Holiday Schedule', 'from' => 'Admin', 'date' => '2024-12-08', 'read' => true],
        ];

        return view('manager.messages', compact('messages'));
    }

    /**
     * Show notifications
     */
    public function showNotifications(): View
    {
        $user = Auth::user();
        
        // Get real notifications
        $notifications = Notification::where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->get()
            ->map(function($notification) {
                return [
                    'id' => $notification->id,
                    'type' => $notification->type,
                    'message' => $notification->message,
                    'time' => $notification->created_at->diffForHumans(),
                    'read' => $notification->is_read
                ];
            })
            ->toArray();

        return view('manager.notifications', compact('notifications'));
    }

    /**
     * Show manager settings
     */
    public function showSettings(): View
    {
        $user = Auth::user();
        
        // Get or create settings for the user
        $managerSettings = ManagerSetting::getOrCreateForUser($user->id);
        
        $settings = [
            'email_notifications' => $managerSettings->email_notifications,
            'push_notifications' => $managerSettings->push_notifications,
            'weekly_reports' => $managerSettings->weekly_reports,
            'auto_approve_leaves' => $managerSettings->auto_approve_leaves,
            'team_size_limit' => $managerSettings->team_size_limit,
        ];

        return view('manager.settings', compact('settings', 'user'));
    }

    /**
     * Update manager settings
     */
    public function updateSettings(Request $request): RedirectResponse
    {
        $request->validate([
            'email_notifications' => 'boolean',
            'push_notifications' => 'boolean',
            'weekly_reports' => 'boolean',
            'auto_approve_leaves' => 'boolean',
            'team_size_limit' => 'integer|min:1|max:100'
        ]);

        $user = Auth::user();
        $settings = ManagerSetting::getOrCreateForUser($user->id);
        
        $settings->update([
            'email_notifications' => $request->boolean('email_notifications'),
            'push_notifications' => $request->boolean('push_notifications'),
            'weekly_reports' => $request->boolean('weekly_reports'),
            'auto_approve_leaves' => $request->boolean('auto_approve_leaves'),
            'team_size_limit' => $request->input('team_size_limit', 20)
        ]);

        return redirect()->route('manager.settings')
            ->with('success', 'Settings updated successfully!');
    }
}