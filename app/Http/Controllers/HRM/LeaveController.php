<?php

namespace App\Http\Controllers\HRM;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LeaveController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Display employee leave index.
     */
    public function employeeIndex()
    {
        // Dummy data for employee leave
        $leaveData = [
            ['date' => '2024-01-15', 'type' => 'Sick Leave', 'status' => 'Approved'],
            ['date' => '2024-01-20', 'type' => 'Annual Leave', 'status' => 'Pending'],
            ['date' => '2024-02-01', 'type' => 'Personal Leave', 'status' => 'Rejected'],
        ];
        
        return view('dashboards.Employee.leave.index', compact('leaveData'));
    }

    /**
     * Display admin leave index.
     */
    public function adminIndex()
    {
        // Dummy data for admin leave management
        $leaveRequests = [
            ['employee' => 'John Doe', 'type' => 'Sick Leave', 'start_date' => '2024-01-15', 'end_date' => '2024-01-16', 'status' => 'Pending'],
            ['employee' => 'Jane Smith', 'type' => 'Annual Leave', 'start_date' => '2024-01-20', 'end_date' => '2024-01-25', 'status' => 'Approved'],
            ['employee' => 'Robert Johnson', 'type' => 'Personal Leave', 'start_date' => '2024-02-01', 'end_date' => '2024-02-02', 'status' => 'Rejected'],
        ];
        
        return view('dashboards.Admin.leave.index', compact('leaveRequests'));
    }

    /**
     * Display leave balance.
     */
    public function balance($user)
    {
        // Dummy data for leave balance
        $leaveBalance = [
            'annual' => 15,
            'sick' => 10,
            'personal' => 5,
            'maternity' => 0,
            'paternity' => 0,
        ];
        
        return view('dashboards.leave.balance', compact('leaveBalance'));
    }

    /**
     * Approve a leave request.
     */
    public function approve($leave)
    {
        // Process leave approval logic here
        return redirect()->back()->with('success', 'Leave request approved successfully!');
    }

    /**
     * Reject a leave request.
     */
    public function reject($leave)
    {
        // Process leave rejection logic here
        return redirect()->back()->with('success', 'Leave request rejected successfully!');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}