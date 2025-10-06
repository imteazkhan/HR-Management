<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\ManagerController;
use App\Http\Controllers\SuperAdminController;
use Illuminate\Support\Facades\Route;
// use App\Http\Controllers\DepartmentController;
// use App\Http\Controllers\LeaveController;

Route::get('/', function () {
    return view('home');
})->name('home');

// Route::middleware(['auth'])->group(function () {
//     Route::resource('employees', EmployeeController::class);
//     Route::resource('departments', DepartmentController::class);
//     Route::resource('leaves', LeaveController::class);
// });

Route::get('/dashboard', function () {
    // Provide dummy stats for now since controllers don't exist yet
    $stats = [
        'employees' => 0,
        'departments' => 0,
        'attendance_today' => 0,
        'payroll_today' => 0
    ];
    return view('dashboard', compact('stats'));
})->middleware(['auth', 'verified'])->name('dashboard');

// Role-specific dashboards
Route::middleware(['auth', 'verified'])->group(function () {
    // Super Admin routes
    Route::middleware('role:superadmin')->prefix('superadmin')->name('superadmin.')->group(function () {
        Route::get('/dashboard', [SuperAdminController::class, 'dashboard'])->name('dashboard');
        Route::get('/employees', [SuperAdminController::class, 'showEmployees'])->name('employees');
        Route::get('/employees/id-cards', [SuperAdminController::class, 'showEmployeeIdCards'])->name('employees.id-cards');
        Route::get('/employees/{employee}/edit', [SuperAdminController::class, 'editEmployee'])->name('employees.edit');
        Route::post('/employees/{employee}/documents', [SuperAdminController::class, 'uploadEmployeeDocument'])->name('employees.documents.upload');
        Route::post('/employees', [SuperAdminController::class, 'createEmployee'])->name('employees.create');
        Route::patch('/employees/{employee}', [SuperAdminController::class, 'updateEmployee'])->name('employees.update');
        Route::delete('/employees/{employee}', [SuperAdminController::class, 'deleteEmployee'])->name('employees.delete');
        Route::get('/users', [SuperAdminController::class, 'showUsers'])->name('users');
        Route::post('/users', [SuperAdminController::class, 'createUser'])->name('users.create');
        Route::patch('/users/role', [SuperAdminController::class, 'updateUserRole'])->name('users.role');
        Route::delete('/users', [SuperAdminController::class, 'deleteUser'])->name('users.delete');
        Route::get('/departments', [SuperAdminController::class, 'showDepartments'])->name('departments');
        Route::post('/departments', [SuperAdminController::class, 'createDepartment'])->name('departments.create');
        Route::get('/departments/{department}', [SuperAdminController::class, 'showDepartment'])->name('departments.show');
        Route::patch('/departments/{department}', [SuperAdminController::class, 'updateDepartment'])->name('departments.update');
        Route::delete('/departments/{department}', [SuperAdminController::class, 'deleteDepartment'])->name('departments.delete');
        Route::get('/user-roles', [SuperAdminController::class, 'showUserRoles'])->name('user-roles');
        Route::get('/settings', [SuperAdminController::class, 'showSettings'])->name('settings');
        Route::patch('/settings', [SuperAdminController::class, 'updateSettings'])->name('settings.update');
        Route::get('/payroll', [SuperAdminController::class, 'showPayroll'])->name('payroll');
        Route::post('/payroll/process', [SuperAdminController::class, 'processPayroll'])->name('payroll.process');
        Route::patch('/payroll/{payroll}', [SuperAdminController::class, 'updatePayroll'])->name('payroll.update');
        Route::get('/analytics', [SuperAdminController::class, 'showAnalytics'])->name('analytics');
        Route::get('/security', [SuperAdminController::class, 'showSecurity'])->name('security');
        Route::get('/database', [SuperAdminController::class, 'showDatabase'])->name('database');
        Route::post('/backup', [SuperAdminController::class, 'backupSystem'])->name('backup');
        
        // Designations Management Routes
        Route::get('/designations', [SuperAdminController::class, 'showDesignations'])->name('designations');
        Route::post('/designations', [SuperAdminController::class, 'createDesignation'])->name('designations.store');
        Route::get('/designations/{designation}', [SuperAdminController::class, 'showDesignation'])->name('designations.show');
        Route::patch('/designations/{designation}', [SuperAdminController::class, 'updateDesignation'])->name('designations.update');
        Route::delete('/designations/{designation}', [SuperAdminController::class, 'deleteDesignation'])->name('designations.delete');
        
        // Attendance Management Routes
        Route::prefix('attendance')->name('attendance.')->group(function () {
            Route::get('/', [SuperAdminController::class, 'showAttendance'])->name('index');
            Route::get('/admin', [SuperAdminController::class, 'showAdminAttendance'])->name('admin.index');
            Route::get('/employee', [SuperAdminController::class, 'showEmployeeAttendance'])->name('employee.index');
            Route::get('/leave-count', [SuperAdminController::class, 'showLeaveCount'])->name('leave-count');
            Route::post('/clock-in', [SuperAdminController::class, 'clockIn'])->name('clock-in');
            Route::post('/clock-out', [SuperAdminController::class, 'clockOut'])->name('clock-out');
            Route::post('/manual-entry', [SuperAdminController::class, 'manualEntry'])->name('manual-entry');
            Route::post('/update-leave-balance', [SuperAdminController::class, 'updateLeaveBalance'])->name('update-leave-balance');
            Route::put('/update-entry/{id}', [SuperAdminController::class, 'updateEntry'])->name('update-entry');
            Route::delete('/delete-entry/{id}', [SuperAdminController::class, 'deleteEntry'])->name('delete-entry');
        });
        
        // Manager Data Management Routes
        Route::prefix('manager-data')->name('manager-data.')->group(function () {
            // Messages Management
            Route::get('/messages', [SuperAdminController::class, 'manageMessages'])->name('messages');
            Route::post('/messages', [SuperAdminController::class, 'createMessage'])->name('messages.create');
            Route::delete('/messages/{message}', [SuperAdminController::class, 'deleteMessage'])->name('messages.delete');
            
            // Notifications Management
            Route::get('/notifications', [SuperAdminController::class, 'manageNotifications'])->name('notifications');
            Route::post('/notifications', [SuperAdminController::class, 'createNotification'])->name('notifications.create');
            Route::delete('/notifications/{notification}', [SuperAdminController::class, 'deleteNotification'])->name('notifications.delete');
            
            // Team Members Management
            Route::get('/team-members', [SuperAdminController::class, 'manageTeamMembers'])->name('team-members');
            Route::post('/team-members', [SuperAdminController::class, 'createTeamMember'])->name('team-members.create');
            Route::delete('/team-members/{teamMember}', [SuperAdminController::class, 'deleteTeamMember'])->name('team-members.delete');
            
            // Performance Reviews Management
            Route::get('/performance-reviews', [SuperAdminController::class, 'managePerformanceReviews'])->name('performance-reviews');
            Route::post('/performance-reviews', [SuperAdminController::class, 'createPerformanceReview'])->name('performance-reviews.create');
            Route::patch('/performance-reviews/{review}', [SuperAdminController::class, 'updatePerformanceReview'])->name('performance-reviews.update');
            Route::delete('/performance-reviews/{review}', [SuperAdminController::class, 'deletePerformanceReview'])->name('performance-reviews.delete');
            
            // Manager Settings Management
            Route::get('/manager-settings', [SuperAdminController::class, 'manageManagerSettings'])->name('manager-settings');
            Route::patch('/manager-settings/{setting}', [SuperAdminController::class, 'updateManagerSetting'])->name('manager-settings.update');
        });
    });
    
    // Manager routes
    Route::middleware('role:manager')->prefix('manager')->name('manager.')->group(function () {
        Route::get('/dashboard', [ManagerController::class, 'dashboard'])->name('dashboard');
        Route::get('/team', [ManagerController::class, 'showTeam'])->name('team');
        Route::get('/leave-requests', [ManagerController::class, 'showLeaveRequests'])->name('leave-requests');
        Route::post('/leave-requests/handle', [ManagerController::class, 'handleLeaveRequest'])->name('leave-requests.handle');
        Route::get('/performance', [ManagerController::class, 'showPerformance'])->name('performance');
        Route::get('/reports', [ManagerController::class, 'generateReports'])->name('reports');
        Route::get('/attendance', [ManagerController::class, 'showTeamAttendance'])->name('attendance');
        Route::post('/message', [ManagerController::class, 'sendTeamMessage'])->name('message');
        Route::get('/messages', [ManagerController::class, 'showMessages'])->name('messages');
        Route::get('/notifications', [ManagerController::class, 'showNotifications'])->name('notifications');
        Route::get('/settings', [ManagerController::class, 'showSettings'])->name('settings');
        Route::patch('/settings', [ManagerController::class, 'updateSettings'])->name('settings.update');
    });
    
    // Employee routes
    Route::middleware('role:employee')->prefix('employee')->name('employee.')->group(function () {
        Route::get('/dashboard', [EmployeeController::class, 'dashboard'])->name('dashboard');
        Route::post('/clock', [EmployeeController::class, 'clockInOut'])->name('clock');
        Route::get('/leave-request', [EmployeeController::class, 'showLeaveRequest'])->name('leave-request');
        Route::post('/leave-request', [EmployeeController::class, 'submitLeaveRequest'])->name('leave-request.submit');
        Route::get('/profile', [EmployeeController::class, 'showProfile'])->name('profile');
        Route::patch('/profile', [EmployeeController::class, 'updateProfile'])->name('profile.update');
        Route::get('/payslips', [EmployeeController::class, 'showPayslips'])->name('payslips');
        Route::post('/payslips/download', [EmployeeController::class, 'downloadPayslip'])->name('payslips.download');
        Route::get('/attendance', [EmployeeController::class, 'showAttendance'])->name('attendance');
    });
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


// HRM Routes
Route::middleware(['auth'])->prefix('hrm')->name('hrm.')->group(function () {
    // Employee Management
    Route::resource('employees', \App\Http\Controllers\HRM\EmployeeController::class);
    
    // Designations
    Route::resource('designations', \App\Http\Controllers\HRM\DesignationController::class);
    
    // Attendance Management
    Route::prefix('attendance')->name('attendance.')->group(function () {
        Route::get('/', [\App\Http\Controllers\HRM\AttendanceController::class, 'index'])->name('index');
        Route::get('/admin', [\App\Http\Controllers\HRM\AttendanceController::class, 'adminIndex'])->name('admin.index');
        Route::get('/employee', [\App\Http\Controllers\HRM\AttendanceController::class, 'employeeIndex'])->name('employee.index');
        Route::get('/biometric', [\App\Http\Controllers\HRM\AttendanceController::class, 'biometricIndex'])->name('biometric.index');
        Route::post('/clock-in', [\App\Http\Controllers\HRM\AttendanceController::class, 'clockIn'])->name('clock-in');
        Route::post('/clock-out', [\App\Http\Controllers\HRM\AttendanceController::class, 'clockOut'])->name('clock-out');
        Route::post('/manual-entry', [\App\Http\Controllers\HRM\AttendanceController::class, 'manualEntry'])->name('manual-entry');
        Route::put('/update-entry/{id}', [\App\Http\Controllers\HRM\AttendanceController::class, 'updateEntry'])->name('update-entry');
        Route::delete('/delete-entry/{id}', [\App\Http\Controllers\HRM\AttendanceController::class, 'deleteEntry'])->name('delete-entry');
    });
    
    // Leave Management
    Route::prefix('leaves')->name('leaves.')->group(function () {
        Route::get('/', [\App\Http\Controllers\HRM\LeaveController::class, 'index'])->name('index');
        Route::get('/employee', [\App\Http\Controllers\HRM\LeaveController::class, 'employeeIndex'])->name('employee.index');
        Route::get('/admin', [\App\Http\Controllers\HRM\LeaveController::class, 'adminIndex'])->name('admin.index');
        Route::get('/create', [\App\Http\Controllers\HRM\LeaveController::class, 'create'])->name('create');
        Route::post('/', [\App\Http\Controllers\HRM\LeaveController::class, 'store'])->name('store');
        Route::get('/{leave}', [\App\Http\Controllers\HRM\LeaveController::class, 'show'])->name('show');
        Route::patch('/{leave}/approve', [\App\Http\Controllers\HRM\LeaveController::class, 'approve'])->name('approve');
        Route::patch('/{leave}/reject', [\App\Http\Controllers\HRM\LeaveController::class, 'reject'])->name('reject');
        Route::get('/balance/{user}', [\App\Http\Controllers\HRM\LeaveController::class, 'balance'])->name('balance');
    });
    
    // Loan Management
    Route::prefix('loans')->name('loans.')->group(function () {
        Route::get('/', [\App\Http\Controllers\HRM\LoanController::class, 'index'])->name('index');
        Route::get('/office', [\App\Http\Controllers\HRM\LoanController::class, 'officeIndex'])->name('office.index');
        Route::get('/personal', [\App\Http\Controllers\HRM\LoanController::class, 'personalIndex'])->name('personal.index');
        Route::get('/create-office', [\App\Http\Controllers\HRM\LoanController::class, 'createOffice'])->name('office.create');
        Route::get('/create-personal', [\App\Http\Controllers\HRM\LoanController::class, 'createPersonal'])->name('personal.create');
        Route::post('/office', [\App\Http\Controllers\HRM\LoanController::class, 'storeOffice'])->name('office.store');
        Route::post('/personal', [\App\Http\Controllers\HRM\LoanController::class, 'storePersonal'])->name('personal.store');
        Route::get('/office/{loan}', [\App\Http\Controllers\HRM\LoanController::class, 'showOffice'])->name('office.show');
        Route::get('/personal/{loan}', [\App\Http\Controllers\HRM\LoanController::class, 'showPersonal'])->name('personal.show');
        Route::patch('/office/{loan}/approve', [\App\Http\Controllers\HRM\LoanController::class, 'approveOffice'])->name('office.approve');
        Route::patch('/personal/{loan}/approve', [\App\Http\Controllers\HRM\LoanController::class, 'approvePersonal'])->name('personal.approve');
    });
    
    // Holiday Management
    Route::resource('holidays', \App\Http\Controllers\HRM\HolidayController::class);
    
    // Time Sheet Management
    Route::resource('timesheets', \App\Http\Controllers\HRM\TimeSheetController::class);
    
    // Schedule Management
    Route::resource('schedules', \App\Http\Controllers\HRM\ScheduleController::class);
    
    // Overtime Management
    Route::resource('overtime', \App\Http\Controllers\HRM\OvertimeController::class);
    
    // Warning Management
    Route::resource('warnings', \App\Http\Controllers\HRM\WarningController::class);
    
    // Dashboard
    Route::get('/dashboard', [\App\Http\Controllers\HRM\DashboardController::class, 'index'])->name('dashboard');
});

require __DIR__.'/auth.php';