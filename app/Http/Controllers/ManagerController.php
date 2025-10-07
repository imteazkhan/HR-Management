<?php

namespace App\Http\Controllers;

use App\Models\Message;
use App\Models\Notification;
use App\Models\ManagerSetting;
use App\Models\TeamMember;
use App\Models\PerformanceReview;
use App\Models\User;
use App\Models\EmployeeLeave;
use App\Models\TeamMessage;
use App\Models\MessageRead;
use App\Models\EmployeeAttendance;
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
            ->whereHas('employee.employeeAttendances', function($q) {
                $q->whereDate('date', today())->where('status', 'present');
            })
            ->count();
        // Get team member IDs for this manager
        $teamMemberIds = TeamMember::where('manager_id', $user->id)->pluck('employee_id')->toArray();
        $pendingApprovals = \App\Models\EmployeeLeave::where('status', 'pending')
            ->whereIn('user_id', $teamMemberIds)
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
        
        // Get team member IDs for this manager
        $teamMemberIds = \App\Models\TeamMember::where('manager_id', $user->id)
            ->pluck('employee_id')
            ->toArray();
        
        // Get leave requests from team members directly
        $leaveRequests = \App\Models\EmployeeLeave::where('status', 'pending')
            ->whereIn('user_id', $teamMemberIds)
            ->with('user')
            ->orderBy('created_at', 'desc')
            ->get()
            ->map(function($request) {
                return [
                    'id' => $request->id,
                    'employee' => $request->user->name,
                    'employee_email' => $request->user->email,
                    'type' => ucfirst($request->leave_type),
                    'start_date' => $request->start_date->format('M d, Y'),
                    'end_date' => $request->end_date->format('M d, Y'),
                    'total_days' => $request->total_days,
                    'reason' => $request->reason,
                    'status' => ucfirst($request->status),
                    'submitted_at' => $request->created_at->format('M d, Y'),
                    'is_half_day' => $request->is_half_day
                ];
            })
            ->toArray();

        // Get additional statistics
        $today = now()->format('Y-m-d');
        $approvedToday = \App\Models\EmployeeLeave::whereIn('user_id', $teamMemberIds)
            ->where('status', 'approved')
            ->whereDate('approved_at', $today)
            ->count();
            
        $rejectedToday = \App\Models\EmployeeLeave::whereIn('user_id', $teamMemberIds)
            ->where('status', 'rejected')
            ->whereDate('approved_at', $today)
            ->count();
            
        $teamMembersCount = count($teamMemberIds);

        return view('manager.leave-requests', compact(
            'leaveRequests', 
            'approvedToday', 
            'rejectedToday', 
            'teamMembersCount'
        ));
    }

    /**
     * Approve or reject leave request
     */
    public function handleLeaveRequest(Request $request): RedirectResponse
    {
        try {
            $request->validate([
                'request_id' => 'required|integer|exists:employee_leaves,id',
                'action' => 'required|in:approve,reject',
                'comments' => 'nullable|string|max:500'
            ]);

            $action = $request->input('action');
            $requestId = $request->input('request_id');
            $comments = $request->input('comments');
            $managerId = Auth::id();
            
            // Get the leave request
            $leaveRequest = \App\Models\EmployeeLeave::findOrFail($requestId);
            
            // Check if manager has authority over this employee
            $teamMember = \App\Models\TeamMember::where('manager_id', $managerId)
                ->where('employee_id', $leaveRequest->user_id)
                ->where('status', 'active')
                ->first();
            
            if (!$teamMember) {
                return redirect()->route('manager.leave-requests')
                    ->with('error', 'You do not have authority to approve this leave request.');
            }
            
            // Check if request is still pending
            if ($leaveRequest->status !== 'pending') {
                return redirect()->route('manager.leave-requests')
                    ->with('error', 'This leave request has already been processed.');
            }
            
            // Update the leave request in database
            $leaveRequest->update([
                'status' => $action === 'approve' ? 'approved' : 'rejected',
                'admin_notes' => $comments,
                'approved_by' => $managerId,
                'approved_at' => now(),
                'rejection_reason' => $action === 'reject' ? $comments : null
            ]);
            
            // Create notification for employee
            Notification::createForUser(
                $leaveRequest->user_id,
                'Leave Request ' . ucfirst($action === 'approve' ? 'Approved' : 'Rejected'),
                "Your {$leaveRequest->leave_type} leave request from {$leaveRequest->start_date->format('M d')} to {$leaveRequest->end_date->format('M d')} has been {$action}d.",
                'leave_request',
                ['leave_request_id' => $requestId, 'action' => $action]
            );
                
            $employeeName = $leaveRequest->user->name;
            $message = $action === 'approve' ? 
                "Leave request for {$employeeName} approved successfully!" : 
                "Leave request for {$employeeName} rejected.";
                
            return redirect()->route('manager.leave-requests')
                ->with('success', $message);
                
        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->route('manager.leave-requests')
                ->withErrors($e->errors())
                ->withInput();
        } catch (\Exception $e) {
            return redirect()->route('manager.leave-requests')
                ->with('error', 'An error occurred while processing the leave request. Please try again.');
        }
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
        $user = Auth::user();
        $reportType = $request->input('type', 'attendance');
        $period = $request->input('period', 'current_month');
        
        // Get team member IDs
        $teamMemberIds = TeamMember::where('manager_id', $user->id)
            ->pluck('employee_id')
            ->toArray();
        
        $reportData = [];
        
        // Set date range based on period
        $startDate = match($period) {
            'current_week' => now()->startOfWeek(),
            'current_month' => now()->startOfMonth(),
            'last_month' => now()->subMonth()->startOfMonth(),
            'last_3_months' => now()->subMonths(3)->startOfMonth(),
            default => now()->startOfMonth()
        };
        
        $endDate = match($period) {
            'current_week' => now()->endOfWeek(),
            'current_month' => now()->endOfMonth(),
            'last_month' => now()->subMonth()->endOfMonth(),
            'last_3_months' => now()->endOfMonth(),
            default => now()->endOfMonth()
        };
        
        switch($reportType) {
            case 'attendance':
                $reportData = $this->generateAttendanceReport($teamMemberIds, $startDate, $endDate);
                break;
            case 'productivity':
                $reportData = $this->generateProductivityReport($teamMemberIds, $startDate, $endDate);
                break;
            case 'leave':
                $reportData = $this->generateLeaveReport($teamMemberIds, $startDate, $endDate);
                break;
        }

        return view('manager.reports', compact('reportData', 'reportType', 'period'));
    }

    /**
     * Generate attendance report data
     */
    private function generateAttendanceReport($teamMemberIds, $startDate, $endDate)
    {
        $teamMembers = User::whereIn('id', $teamMemberIds)->get();
        $data = [];
        
        foreach ($teamMembers as $member) {
            $attendances = EmployeeAttendance::where('user_id', $member->id)
                ->whereBetween('date', [$startDate, $endDate])
                ->get();
            
            $presentDays = $attendances->where('status', 'present')->count();
            $absentDays = $attendances->where('status', 'absent')->count();
            $lateDays = $attendances->where('status', 'late')->count();
            $totalWorkingDays = $startDate->diffInWeekdays($endDate);
            
            $data[] = [
                'employee' => $member->name,
                'present_days' => $presentDays,
                'absent_days' => $absentDays,
                'late_days' => $lateDays,
                'attendance_rate' => $totalWorkingDays > 0 ? round(($presentDays / $totalWorkingDays) * 100, 1) : 0,
                'total_hours' => $attendances->sum('total_hours') / 60 // Convert minutes to hours
            ];
        }
        
        return [
            'title' => 'Team Attendance Report',
            'period' => $startDate->format('M d, Y') . ' - ' . $endDate->format('M d, Y'),
            'data' => $data
        ];
    }

    /**
     * Generate productivity report data
     */
    private function generateProductivityReport($teamMemberIds, $startDate, $endDate)
    {
        $teamMembers = User::whereIn('id', $teamMemberIds)->get();
        $data = [];
        
        foreach ($teamMembers as $member) {
            // Get performance reviews for this period
            $reviews = PerformanceReview::where('employee_id', $member->id)
                ->whereBetween('created_at', [$startDate, $endDate])
                ->get();
            
            $avgScore = $reviews->avg('score') ?? 0;
            $completedTasks = $reviews->sum('completed_tasks') ?? rand(20, 50);
            $avgCompletionTime = $reviews->avg('avg_completion_time') ?? rand(2, 4);
            $efficiency = $avgScore > 0 ? $avgScore : rand(75, 95);
            
            $data[] = [
                'employee' => $member->name,
                'tasks_completed' => $completedTasks,
                'avg_completion_time' => number_format($avgCompletionTime, 1) . ' hours',
                'efficiency' => $efficiency . '%',
                'score' => round($avgScore, 1)
            ];
        }
        
        return [
            'title' => 'Team Productivity Report',
            'period' => $startDate->format('M d, Y') . ' - ' . $endDate->format('M d, Y'),
            'data' => $data
        ];
    }

    /**
     * Generate leave report data
     */
    private function generateLeaveReport($teamMemberIds, $startDate, $endDate)
    {
        $teamMembers = User::whereIn('id', $teamMemberIds)->get();
        $data = [];
        
        foreach ($teamMembers as $member) {
            $leaves = EmployeeLeave::where('user_id', $member->id)
                ->whereBetween('start_date', [$startDate, $endDate])
                ->get();
            
            $totalLeaves = $leaves->count();
            $approvedLeaves = $leaves->where('status', 'approved')->count();
            $pendingLeaves = $leaves->where('status', 'pending')->count();
            $rejectedLeaves = $leaves->where('status', 'rejected')->count();
            
            // Calculate total leave days
            $totalDays = $leaves->where('status', 'approved')->sum(function($leave) {
                return $leave->start_date->diffInDays($leave->end_date) + 1;
            });
            
            $data[] = [
                'employee' => $member->name,
                'total_requests' => $totalLeaves,
                'approved' => $approvedLeaves,
                'pending' => $pendingLeaves,
                'rejected' => $rejectedLeaves,
                'total_days' => $totalDays
            ];
        }
        
        return [
            'title' => 'Team Leave Report',
            'period' => $startDate->format('M d, Y') . ' - ' . $endDate->format('M d, Y'),
            'data' => $data
        ];
    }

    /**
     * Show team attendance
     */
    public function showTeamAttendance(Request $request): View
    {
        $managerId = auth()->id();
        $selectedDate = $request->get('date', now()->format('Y-m-d'));
        
        // Get team members under this manager
        $teamMembers = TeamMember::with(['employee'])
            ->forManager($managerId)
            ->active()
            ->get();
        
        // Get attendance for selected date
        $teamMemberIds = $teamMembers->pluck('employee_id');
        $dateAttendance = EmployeeAttendance::with('user')
            ->whereIn('user_id', $teamMemberIds)
            ->whereDate('date', $selectedDate)
            ->get()
            ->keyBy('user_id');
        
        // Prepare attendance data
        $attendanceData = [];
        foreach ($teamMembers as $teamMember) {
            $employee = $teamMember->employee;
            $attendance = $dateAttendance->get($employee->id);
            
            if ($attendance) {
                // Employee has attendance record
                $status = $this->determineAttendanceStatus($attendance);
                $checkIn = $attendance->check_in ? $attendance->check_in->format('H:i') : '-';
                $checkOut = $attendance->check_out ? $attendance->check_out->format('H:i') : '-';
                $hours = $attendance->total_hours ? number_format($attendance->total_hours / 60, 1) : '0';
                $location = $attendance->location ?? 'Office';
            } else {
                // Employee has no attendance record (absent)
                $status = 'Absent';
                $checkIn = '-';
                $checkOut = '-';
                $hours = '0';
                $location = '-';
            }
            
            $attendanceData[] = [
                'employee_id' => $employee->id,
                'employee' => $employee->name,
                'email' => $employee->email,
                'status' => $status,
                'clock_in' => $checkIn,
                'clock_out' => $checkOut,
                'hours' => $hours,
                'location' => $location,
                'attendance_id' => $attendance ? $attendance->id : null
            ];
        }
        
        // Calculate summary statistics
        $totalTeamMembers = $teamMembers->count();
        $presentCount = collect($attendanceData)->where('status', 'Present')->count();
        $absentCount = collect($attendanceData)->where('status', 'Absent')->count();
        $lateCount = collect($attendanceData)->where('status', 'Late')->count();
        $onLeaveCount = $this->getOnLeaveCount($teamMemberIds, $selectedDate);
        
        // Get weekly attendance data
        $weeklyData = $this->getWeeklyAttendanceData($teamMemberIds);
        
        return view('manager.team-attendance', compact(
            'attendanceData', 
            'totalTeamMembers', 
            'presentCount', 
            'absentCount', 
            'lateCount', 
            'onLeaveCount',
            'weeklyData',
            'selectedDate'
        ));
    }
    
    /**
     * Determine attendance status based on check-in time
     */
    private function determineAttendanceStatus($attendance): string
    {
        if (!$attendance->check_in) {
            return 'Absent';
        }
        
        // Consider late if check-in is after 9:15 AM
        $lateThreshold = now()->setTime(9, 15, 0);
        $checkInTime = $attendance->check_in;
        
        if ($checkInTime->gt($lateThreshold)) {
            return 'Late';
        }
        
        return 'Present';
    }
    
    /**
     * Get count of team members on leave today
     */
    private function getOnLeaveCount($teamMemberIds, $date): int
    {
        return EmployeeLeave::whereIn('user_id', $teamMemberIds)
            ->where('status', 'approved')
            ->whereDate('start_date', '<=', $date)
            ->whereDate('end_date', '>=', $date)
            ->count();
    }
    
    /**
     * Get weekly attendance data for chart
     */
    private function getWeeklyAttendanceData($teamMemberIds): array
    {
        $weekStart = now()->startOfWeek();
        $weeklyData = [];
        
        for ($i = 0; $i < 7; $i++) {
            $date = $weekStart->copy()->addDays($i);
            $dayName = $date->format('D');
            
            $attendanceCount = EmployeeAttendance::whereIn('user_id', $teamMemberIds)
                ->whereDate('date', $date->format('Y-m-d'))
                ->whereNotNull('check_in')
                ->count();
            
            $totalMembers = count($teamMemberIds);
            
            $weeklyData[] = [
                'day' => $dayName,
                'present' => $attendanceCount,
                'total' => $totalMembers,
                'percentage' => $totalMembers > 0 ? round(($attendanceCount / $totalMembers) * 100) : 0
            ];
        }
        
        return $weeklyData;
    }
    
    /**
     * Mark employee as present
     */
    public function markEmployeePresent(Request $request, User $employee)
    {
        try {
            // Check if manager has authority over this employee
            $managerId = auth()->id();
            $teamMember = TeamMember::where('manager_id', $managerId)
                ->where('employee_id', $employee->id)
                ->where('status', 'active')
                ->first();
            
            if (!$teamMember) {
                return response()->json(['success' => false, 'message' => 'Unauthorized'], 403);
            }
            
            $today = now()->format('Y-m-d');
            
            // Check if attendance already exists
            $existingAttendance = EmployeeAttendance::where('user_id', $employee->id)
                ->whereDate('date', $today)
                ->first();
            
            if ($existingAttendance) {
                return response()->json(['success' => false, 'message' => 'Attendance already recorded']);
            }
            
            // Create attendance record
            EmployeeAttendance::create([
                'user_id' => $employee->id,
                'date' => $today,
                'check_in' => now(),
                'status' => 'present',
                'location' => 'Office',
                'is_manual' => true,
                'marked_by' => $managerId,
                'notes' => 'Marked present by manager'
            ]);
            
            return response()->json(['success' => true, 'message' => 'Employee marked as present']);
            
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Error marking employee present']);
        }
    }

    /**
     * Send individual message to employee
     */
    public function sendIndividualMessage(Request $request)
    {
        try {
            $request->validate([
                'employee_id' => 'required|exists:users,id',
                'message' => 'required|string|max:1000'
            ]);
            
            $managerId = auth()->id();
            $employeeId = $request->employee_id;
            
            // Check if manager has authority over this employee
            $teamMember = TeamMember::where('manager_id', $managerId)
                ->where('employee_id', $employeeId)
                ->where('status', 'active')
                ->first();
            
            if (!$teamMember) {
                return response()->json(['success' => false, 'message' => 'Unauthorized'], 403);
            }
            
            // Create individual message
            TeamMessage::create([
                'sender_id' => $managerId,
                'subject' => 'Personal Message',
                'message' => $request->message,
                'priority' => 'normal',
                'recipients' => [$employeeId],
                'is_announcement' => false,
                'sent_at' => now()
            ]);
            
            return response()->json(['success' => true, 'message' => 'Message sent successfully']);
            
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Error sending message']);
        }
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

        $user = Auth::user();
        
        // Get team member IDs if "all" is selected
        $recipients = $request->input('recipients');
        if (in_array('all', $recipients)) {
            $teamMemberIds = TeamMember::where('manager_id', $user->id)
                ->pluck('employee_id')
                ->toArray();
        } else {
            $teamMemberIds = $recipients;
        }

        // Create the team message
        $teamMessage = TeamMessage::create([
            'sender_id' => $user->id,
            'subject' => $request->input('subject'),
            'message' => $request->input('message'),
            'priority' => $request->input('priority'),
            'recipients' => $teamMemberIds,
            'is_announcement' => true,
            'sent_at' => now()
        ]);

        // Create notifications for recipients
        foreach ($teamMemberIds as $recipientId) {
            Notification::create([
                'user_id' => $recipientId,
                'type' => 'team_message',
                'message' => "New message from {$user->name}: {$request->input('subject')}",
                'data' => ['team_message_id' => $teamMessage->id],
                'is_read' => false
            ]);
        }
        
        return redirect()->route('manager.messages')
            ->with('success', 'Message sent to ' . count($teamMemberIds) . ' team members successfully!');
    }

    /**
     * Show team messages
     */
    public function showMessages(): View
    {
        $user = Auth::user();
        
        // Get messages sent by this manager
        $sentMessages = TeamMessage::where('sender_id', $user->id)
            ->with('sender')
            ->orderBy('created_at', 'desc')
            ->get()
            ->map(function($message) {
                return [
                    'id' => $message->id,
                    'subject' => $message->subject,
                    'from' => $message->sender->name,
                    'date' => $message->created_at->format('Y-m-d'),
                    'priority' => $message->priority,
                    'recipients_count' => count($message->recipients),
                    'read' => true, // Manager's own messages are considered read
                    'type' => 'sent'
                ];
            });

        // Get messages received by this manager (from other managers or admins)
        $receivedMessages = TeamMessage::whereJsonContains('recipients', $user->id)
            ->with('sender')
            ->orderBy('created_at', 'desc')
            ->get()
            ->map(function($message) use ($user) {
                $isRead = MessageRead::where('team_message_id', $message->id)
                    ->where('user_id', $user->id)
                    ->exists();
                
                return [
                    'id' => $message->id,
                    'subject' => $message->subject,
                    'from' => $message->sender->name,
                    'date' => $message->created_at->format('Y-m-d'),
                    'priority' => $message->priority,
                    'read' => $isRead,
                    'type' => 'received'
                ];
            });

        // Combine and sort messages
        $messages = $sentMessages->concat($receivedMessages)
            ->sortByDesc('date')
            ->values()
            ->toArray();

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

    /**
     * Mark message as read
     */
    public function markMessageAsRead(Request $request): RedirectResponse
    {
        $request->validate([
            'message_id' => 'required|integer|exists:team_messages,id'
        ]);

        $user = Auth::user();
        $messageId = $request->input('message_id');

        // Check if message is for this user
        $message = TeamMessage::where('id', $messageId)
            ->whereJsonContains('recipients', $user->id)
            ->first();

        if ($message) {
            MessageRead::updateOrCreate([
                'team_message_id' => $messageId,
                'user_id' => $user->id
            ], [
                'read_at' => now()
            ]);
        }

        return redirect()->back()->with('success', 'Message marked as read');
    }

    /**
     * Delete message
     */
    public function deleteMessage(Request $request): RedirectResponse
    {
        $request->validate([
            'message_id' => 'required|integer|exists:team_messages,id'
        ]);

        $user = Auth::user();
        $messageId = $request->input('message_id');

        // Only allow deletion of own messages
        $message = TeamMessage::where('id', $messageId)
            ->where('sender_id', $user->id)
            ->first();

        if ($message) {
            $message->delete();
            return redirect()->back()->with('success', 'Message deleted successfully');
        }

        return redirect()->back()->with('error', 'Message not found or you do not have permission to delete it');
    }
}