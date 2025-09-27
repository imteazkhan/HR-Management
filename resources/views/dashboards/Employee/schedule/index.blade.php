<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>My Schedule - HR Management</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <style>
        body { 
            background: #f8f9fa; 
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .sidebar { 
            background: #2c3e50; 
            min-height: 100vh; 
            position: fixed; 
            top: 0; 
            left: 0; 
            width: 250px; 
            z-index: 1000;
            transition: all 0.3s ease;
        }
        .sidebar .nav-link { 
            color: #ecf0f1; 
            padding: 12px 20px; 
            transition: all 0.3s ease;
            border-radius: 8px;
            margin: 2px 8px;
        }
        .sidebar .nav-link:hover { 
            background: linear-gradient(135deg, #3498db, #2980b9);
            color: #fff;
            transform: translateX(5px);
        }
        .sidebar .nav-link.active { 
            background: linear-gradient(135deg, #e74c3c, #c0392b);
            color: #fff;
        }
        .sidebar .nav-link i { 
            width: 20px; 
            margin-right: 10px;
        }
        .main-content { 
            margin-left: 250px; 
            padding: 20px;
            transition: all 0.3s ease;
        }
        .mobile-header {
            display: none;
            background: #2c3e50;
            color: white;
            padding: 15px;
            position: sticky;
            top: 0;
            z-index: 999;
        }
        .mobile-toggle {
            background: none;
            border: none;
            color: white;
            font-size: 1.5rem;
        }
        .card { 
            border: none; 
            border-radius: 15px; 
            box-shadow: 0 4px 20px rgba(0,0,0,0.08); 
            transition: all 0.3s ease;
            margin-bottom: 20px;
            overflow: hidden;
        }
        .card:hover { 
           transform: translateY(-1px);
            box-shadow: 0 12px 40px rgba(0,0,0,0.15);
        }
        .stat-card { 
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); 
            color: white;
        }
        .stat-card-2 { 
            background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%); 
            color: white;
        }
        .stat-card-3 { 
            background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%); 
            color: white;
        }
        .stat-card-4 { 
            background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%); 
            color: white;
        }
        .navbar-brand { 
            font-weight: 700; 
            font-size: 1.5rem; 
            color: #fff !important;
        }
        .sidebar-overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0,0,0,0.5);
            z-index: 999;
        }
        .btn {
            transition: all 0.3s ease;
            border-radius: 8px;
        }
        .btn:hover {
            box-shadow: 0 4px 12px rgba(0,0,0,0.2);
        }
        .btn:active {
            transform: translateY(0);
        }
        .progress {
            height: 8px;
            border-radius: 4px;
            overflow: hidden;
        }
        .progress-bar {
            transition: width 1s ease-in-out;
        }
        .table-responsive {
            border-radius: 10px;
            overflow: hidden;
        }
        .table th {
            background: #2c3e50;
            color: white;
            font-weight: 500;
        }
        .status-badge {
            padding: 5px 10px;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 500;
        }
        .badge-scheduled {
            background: #17a2b8;
            color: white;
        }
        .badge-completed {
            background: #28a745;
            color: white;
        }
        .badge-cancelled {
            background: #dc3545;
            color: white;
        }
        .calendar-day {
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            background: #667eea;
            color: white;
            font-weight: bold;
        }
        .week-navigation {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border-radius: 10px;
        }
        .schedule-event {
            border-left: 4px solid #667eea;
            margin-bottom: 15px;
            padding: 15px;
            background: white;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.05);
        }
        .event-time {
            font-weight: bold;
            color: #667eea;
        }
        .calendar-view {
            display: grid;
            grid-template-columns: repeat(7, 1fr);
            gap: 10px;
        }
        .calendar-cell {
            min-height: 120px;
            border: 1px solid #dee2e6;
            border-radius: 8px;
            padding: 10px;
            background: white;
        }
        .calendar-cell-header {
            font-weight: bold;
            text-align: center;
            padding-bottom: 5px;
            border-bottom: 1px solid #dee2e6;
            margin-bottom: 5px;
        }
        .calendar-cell-date {
            font-size: 0.9rem;
            color: #6c757d;
        }
        .calendar-cell.today {
            background: #e3f2fd;
            border-color: #667eea;
        }
        @media (max-width: 991.98px) {
            .sidebar { 
                transform: translateX(-100%); 
                transition: transform 0.3s ease;
            }
            .sidebar.show { 
                transform: translateX(0);
            }
            .main-content { 
                margin-left: 0;
                padding: 15px;
            }
            .mobile-header {
                display: flex;
                justify-content: between;
                align-items: center;
            }
            .sidebar-overlay.show {
                display: block;
            }
            .calendar-view {
                grid-template-columns: repeat(1, 1fr);
            }
        }
        @media (max-width: 767.98px) {
            .stat-card h2 {
                font-size: 1.5rem;
            }
            .card-body {
                padding: 1rem;
            }
            .col-lg-3 {
                margin-bottom: 15px;
            }
            .table-responsive {
                font-size: 0.85rem;
            }
        }
        @media (max-width: 575.98px) {
            .main-content {
                padding: 10px;
            }
            .card {
                margin-bottom: 15px;
            }
            .stat-card h6 {
                font-size: 0.8rem;
            }
            .stat-card h2 {
                font-size: 1.2rem;
            }
            .btn {
                font-size: 0.8rem;
                padding: 0.4rem 0.8rem;
            }
        }
        @keyframes pulse {
            0% { transform: scale(1); }
            50% { transform: scale(1.05); }
            100% { transform: scale(1); }
        }
        .pulse-animation {
            animation: pulse 2s infinite;
        }
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        .fade-in-up {
            animation: fadeInUp 0.6s ease-out;
        }
    </style>
</head>
<body>
    <!-- Mobile Header -->
    <div class="mobile-header d-lg-none">
        <button class="mobile-toggle" id="sidebarToggle">
            <i class="bi bi-list"></i>
        </button>
        <div class="ms-2">
            <span class="fw-bold">Employee</span>
        </div>
        <div class="ms-auto">
            <button class="btn btn-sm btn-outline-light dropdown-toggle" type="button" data-bs-toggle="dropdown">
                <i class="bi bi-person-circle"></i>
            </button>
            <ul class="dropdown-menu dropdown-menu-end">
                <li><a class="dropdown-item" href="#"><i class="bi bi-person"></i> Profile</a></li>
                <li><a class="dropdown-item" href="#"><i class="bi bi-gear"></i> Settings</a></li>
                <li><hr class="dropdown-divider"></li>
                <li><a class="dropdown-item" href="{{ route('logout.confirm') }}"><i class="bi bi-box-arrow-right"></i> Logout</a></li>
            </ul>
        </div>
    </div>
    
    <!-- Sidebar Overlay -->
    <div class="sidebar-overlay" id="sidebarOverlay"></div>
    
    <!-- Sidebar -->
    <nav class="sidebar" id="sidebar">
        <div class="p-3">
            <a class="navbar-brand" href="{{ route('home') }}">
                <i class="bi bi-briefcase"></i> iK soft
            </a>
        </div>
        <ul class="nav flex-column">
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('employee.dashboard') ? 'active' : '' }}" href="{{ route('employee.dashboard') }}">
                    <i class="bi bi-speedometer2"></i> Dashboard
                </a>
            </li>
            
            <!-- Employee Management Dropdown -->
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                    <i class="bi bi-person"></i> Employee Management
                </a>
                <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="{{ route('employee.profile') }}">My Profile</a></li>
                </ul>
            </li>
            
            <!-- Attendance Dropdown -->
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                    <i class="bi bi-calendar-check"></i> Attendance
                </a>
                <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="{{ route('employee.attendance') }}">My Attendance</a></li>
                </ul>
            </li>
            
            <!-- Loans Dropdown -->
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                    <i class="bi bi-cash"></i> Loans
                </a>
                <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="{{ route('admin.loans.office') }}">Office Loans</a></li>
                    <li><a class="dropdown-item" href="{{ route('employee.loans.personal') }}">Personal Loans</a></li>
                </ul>
            </li>
            
            <!-- Leaves Dropdown -->
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                    <i class="bi bi-calendar-x"></i> Leaves
                </a>
                <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="{{ route('employee.leaves.index') }}">My Leaves</a></li>
                </ul>
            </li>
            
            <li class="nav-item"><a class="nav-link {{ request()->routeIs('employee.payslips') ? 'active' : '' }}" href="{{ route('employee.payslips') }}"><i class="bi bi-cash-stack"></i> Payslips</a></li>
            
            <!-- Time Management Dropdown -->
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                    <i class="bi bi-clock"></i> Time Management
                </a>
                <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="{{ route('employee.timesheet.index') }}">Time Sheet</a></li>
                    <li><a class="dropdown-item active" href="#">Schedule</a></li>
                    <li><a class="dropdown-item" href="{{ route('employee.overtime.index') }}">Overtime</a></li>
                </ul>
            </li>
        </ul>
    </nav>

    <!-- Main Content -->
    <div class="main-content">
        <!-- Header -->
        <div class="d-flex justify-content-between align-items-center mb-4 d-none d-lg-flex">
            <h2><i class="bi bi-calendar-week text-primary"></i> My Schedule</h2>
            <div class="d-flex align-items-center">
                <span class="me-3 d-none d-md-inline">Welcome, {{ Auth::user()->name }}!</span>
                <div class="dropdown">
                    <button class="btn btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                        <i class="bi bi-person-circle"></i>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li><a class="dropdown-item" href="#"><i class="bi bi-person"></i> Profile</a></li>
                        <li><a class="dropdown-item" href="#"><i class="bi bi-gear"></i> Settings</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item" href="{{ route('logout.confirm') }}"><i class="bi bi-box-arrow-right"></i> Logout</a></li>
                    </ul>
                </div>
            </div>
        </div>
        
        <!-- Mobile Welcome Message -->
        <div class="d-lg-none mb-3">
            <h4 class="mb-1">Welcome back, {{ Auth::user()->name }}!</h4>
            <p class="text-muted mb-0">Employee Dashboard</p>
        </div>

        <!-- Schedule Stats -->
        <div class="row g-3 g-md-4 mb-4">
            <div class="col-6 col-lg-3">
                <div class="card stat-card p-3 p-md-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-white-50 mb-1">Today's Events</h6>
                            <h2>3</h2>
                        </div>
                        <i class="bi bi-calendar-event fs-1 opacity-50 d-none d-md-block"></i>
                    </div>
                </div>
            </div>
            <div class="col-6 col-lg-3">
                <div class="card stat-card-2 p-3 p-md-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-white-50 mb-1">This Week</h6>
                            <h2>12</h2>
                        </div>
                        <i class="bi bi-calendar-week fs-1 opacity-50 d-none d-md-block"></i>
                    </div>
                </div>
            </div>
            <div class="col-6 col-lg-3">
                <div class="card stat-card-3 p-3 p-md-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-white-50 mb-1">Upcoming</h6>
                            <h2>8</h2>
                        </div>
                        <i class="bi bi-calendar-plus fs-1 opacity-50 d-none d-md-block"></i>
                    </div>
                </div>
            </div>
            <div class="col-6 col-lg-3">
                <div class="card stat-card-4 p-3 p-md-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-white-50 mb-1">Completed</h6>
                            <h2>24</h2>
                        </div>
                        <i class="bi bi-calendar-check fs-1 opacity-50 d-none d-md-block"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Week Navigation -->
        <div class="row g-3 g-md-4 mb-4">
            <div class="col-12">
                <div class="card week-navigation">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <button class="btn btn-light">
                                <i class="bi bi-chevron-left"></i> Previous Week
                            </button>
                            <h4 class="mb-0">Week of Dec 15 - Dec 21, 2024</h4>
                            <button class="btn btn-light">
                                Next Week <i class="bi bi-chevron-right"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Add Event Card -->
        <div class="row g-3 g-md-4 mb-4">
            <div class="col-12">
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        <h5><i class="bi bi-plus-circle"></i> Schedule New Event</h5>
                    </div>
                    <div class="card-body">
                        <form>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="eventTitle" class="form-label">Event Title</label>
                                    <input type="text" class="form-control" id="eventTitle" placeholder="e.g., Team Meeting" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="eventType" class="form-label">Event Type</label>
                                    <select class="form-select" id="eventType" required>
                                        <option value="">Select Type</option>
                                        <option value="meeting">Meeting</option>
                                        <option value="conference">Conference</option>
                                        <option value="training">Training</option>
                                        <option value="review">Performance Review</option>
                                        <option value="interview">Interview</option>
                                        <option value="other">Other</option>
                                    </select>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="eventDate" class="form-label">Date</label>
                                    <input type="date" class="form-control" id="eventDate" required>
                                </div>
                                <div class="col-md-3 mb-3">
                                    <label for="startTime" class="form-label">Start Time</label>
                                    <input type="time" class="form-control" id="startTime" required>
                                </div>
                                <div class="col-md-3 mb-3">
                                    <label for="endTime" class="form-label">End Time</label>
                                    <input type="time" class="form-control" id="endTime" required>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="location" class="form-label">Location</label>
                                    <input type="text" class="form-control" id="location" placeholder="e.g., Conference Room A">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="participants" class="form-label">Participants</label>
                                    <select class="form-select" id="participants" multiple>
                                        <option value="1">John Doe</option>
                                        <option value="2">Jane Smith</option>
                                        <option value="3">Robert Johnson</option>
                                        <option value="4">Emily Williams</option>
                                        <option value="5">Michael Brown</option>
                                    </select>
                                </div>
                            </div>
                            
                            <div class="mb-3">
                                <label for="eventDescription" class="form-label">Description</label>
                                <textarea class="form-control" id="eventDescription" rows="3" placeholder="Describe the event..."></textarea>
                            </div>
                            
                            <div class="form-check mb-3">
                                <input class="form-check-input" type="checkbox" id="reminder">
                                <label class="form-check-label" for="reminder">
                                    Set Reminder (15 minutes before)
                                </label>
                            </div>
                            
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-calendar-plus"></i> Schedule Event
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Schedule View -->
        <div class="row g-3 g-md-4">
            <div class="col-12">
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5><i class="bi bi-calendar-week"></i> Weekly Schedule</h5>
                            <div class="d-flex">
                                <select class="form-select form-select-sm me-2" style="width: auto;">
                                    <option>Weekly View</option>
                                    <option>Daily View</option>
                                    <option>Monthly View</option>
                                </select>
                                <select class="form-select form-select-sm" style="width: auto;">
                                    <option>This Week</option>
                                    <option>Last Week</option>
                                    <option>Next Week</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <!-- Calendar View -->
                        <div class="calendar-view">
                            <div class="calendar-cell today">
                                <div class="calendar-cell-header">Monday</div>
                                <div class="calendar-cell-date">Dec 15</div>
                                <div class="schedule-event">
                                    <div class="event-time">09:00 - 10:00</div>
                                    <div class="fw-bold">Team Standup</div>
                                    <div class="text-muted small">Conference Room A</div>
                                    <div class="mt-2">
                                        <span class="status-badge badge-scheduled">Scheduled</span>
                                    </div>
                                </div>
                                <div class="schedule-event">
                                    <div class="event-time">14:00 - 15:30</div>
                                    <div class="fw-bold">Project Review</div>
                                    <div class="text-muted small">Virtual Meeting</div>
                                    <div class="mt-2">
                                        <span class="status-badge badge-scheduled">Scheduled</span>
                                    </div>
                                </div>
                            </div>
                            <div class="calendar-cell">
                                <div class="calendar-cell-header">Tuesday</div>
                                <div class="calendar-cell-date">Dec 16</div>
                                <div class="schedule-event">
                                    <div class="event-time">10:00 - 12:00</div>
                                    <div class="fw-bold">Client Meeting</div>
                                    <div class="text-muted small">Board Room</div>
                                    <div class="mt-2">
                                        <span class="status-badge badge-scheduled">Scheduled</span>
                                    </div>
                                </div>
                            </div>
                            <div class="calendar-cell">
                                <div class="calendar-cell-header">Wednesday</div>
                                <div class="calendar-cell-date">Dec 17</div>
                                <div class="schedule-event">
                                    <div class="event-time">11:00 - 12:00</div>
                                    <div class="fw-bold">One-on-One</div>
                                    <div class="text-muted small">Manager's Office</div>
                                    <div class="mt-2">
                                        <span class="status-badge badge-scheduled">Scheduled</span>
                                    </div>
                                </div>
                                <div class="schedule-event">
                                    <div class="event-time">15:00 - 16:30</div>
                                    <div class="fw-bold">Training Session</div>
                                    <div class="text-muted small">Training Room</div>
                                    <div class="mt-2">
                                        <span class="status-badge badge-scheduled">Scheduled</span>
                                    </div>
                                </div>
                            </div>
                            <div class="calendar-cell">
                                <div class="calendar-cell-header">Thursday</div>
                                <div class="calendar-cell-date">Dec 18</div>
                                <div class="schedule-event">
                                    <div class="event-time">09:30 - 11:00</div>
                                    <div class="fw-bold">Department Meeting</div>
                                    <div class="text-muted small">Conference Room B</div>
                                    <div class="mt-2">
                                        <span class="status-badge badge-completed">Completed</span>
                                    </div>
                                </div>
                            </div>
                            <div class="calendar-cell">
                                <div class="calendar-cell-header">Friday</div>
                                <div class="calendar-cell-date">Dec 19</div>
                                <div class="schedule-event">
                                    <div class="event-time">13:00 - 14:00</div>
                                    <div class="fw-bold">Performance Review</div>
                                    <div class="text-muted small">HR Office</div>
                                    <div class="mt-2">
                                        <span class="status-badge badge-scheduled">Scheduled</span>
                                    </div>
                                </div>
                            </div>
                            <div class="calendar-cell">
                                <div class="calendar-cell-header">Saturday</div>
                                <div class="calendar-cell-date">Dec 20</div>
                                <div class="text-center text-muted py-5">
                                    No events scheduled
                                </div>
                            </div>
                            <div class="calendar-cell">
                                <div class="calendar-cell-header">Sunday</div>
                                <div class="calendar-cell-date">Dec 21</div>
                                <div class="text-center text-muted py-5">
                                    No events scheduled
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Ensure Bootstrap is loaded before executing
        document.addEventListener('DOMContentLoaded', function() {
            // Mobile sidebar toggle
            const sidebarToggle = document.getElementById('sidebarToggle');
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('sidebarOverlay');
            
            if (sidebarToggle) {
                sidebarToggle.addEventListener('click', function() {
                    sidebar.classList.toggle('show');
                    overlay.classList.toggle('show');
                });
            }
            
            // Close sidebar when overlay is clicked
            if (overlay) {
                overlay.addEventListener('click', function() {
                    sidebar.classList.remove('show');
                    overlay.classList.remove('show');
                });
            }
        });
    </script>
</body>
</html>