<?php

namespace App\Http\Controllers\HRM;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TimeSheet;
use App\Models\User;

class TimeSheetController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $timesheets = TimeSheet::with('user')->get();
        return view('hrm.timesheets.index', compact('timesheets'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $employees = User::all();
        return view('hrm.timesheets.create', compact('employees'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'date' => 'required|date',
            'project' => 'required|string|max:255',
            'task' => 'required|string|max:255',
            'hours' => 'required|numeric|min:0',
            'description' => 'nullable|string',
            'status' => 'required|in:pending,approved,rejected'
        ]);

        TimeSheet::create($request->all());

        return redirect()->route('hrm.timesheets.index')
            ->with('success', 'Timesheet created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $timesheet = TimeSheet::with('user')->findOrFail($id);
        return view('hrm.timesheets.show', compact('timesheet'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $timesheet = TimeSheet::findOrFail($id);
        $employees = User::all();
        return view('hrm.timesheets.edit', compact('timesheet', 'employees'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'date' => 'required|date',
            'project' => 'required|string|max:255',
            'task' => 'required|string|max:255',
            'hours' => 'required|numeric|min:0',
            'description' => 'nullable|string',
            'status' => 'required|in:pending,approved,rejected'
        ]);

        $timesheet = TimeSheet::findOrFail($id);
        $timesheet->update($request->all());

        return redirect()->route('hrm.timesheets.index')
            ->with('success', 'Timesheet updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $timesheet = TimeSheet::findOrFail($id);
        $timesheet->delete();

        return redirect()->route('hrm.timesheets.index')
            ->with('success', 'Timesheet deleted successfully.');
    }
}