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
        Route::get('/users', [SuperAdminController::class, 'showUsers'])->name('users');
        Route::post('/users', [SuperAdminController::class, 'createUser'])->name('users.create');
        Route::patch('/users/role', [SuperAdminController::class, 'updateUserRole'])->name('users.role');
        Route::delete('/users', [SuperAdminController::class, 'deleteUser'])->name('users.delete');
        Route::get('/departments', [SuperAdminController::class, 'showDepartments'])->name('departments');
        Route::post('/departments', [SuperAdminController::class, 'createDepartment'])->name('departments.create');
        Route::get('/settings', [SuperAdminController::class, 'showSettings'])->name('settings');
        Route::patch('/settings', [SuperAdminController::class, 'updateSettings'])->name('settings.update');
        Route::get('/payroll', [SuperAdminController::class, 'showPayroll'])->name('payroll');
        Route::post('/payroll/process', [SuperAdminController::class, 'processPayroll'])->name('payroll.process');
        Route::get('/analytics', [SuperAdminController::class, 'showAnalytics'])->name('analytics');
        Route::post('/backup', [SuperAdminController::class, 'backupSystem'])->name('backup');
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


require __DIR__.'/auth.php';
