<?php

namespace App\Http\Controllers\HRM;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Overtime;
use App\Models\User;

class OvertimeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $overtimes = Overtime::with('user')->get();
        return view('hrm.overtime.index', compact('overtimes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $employees = User::all();
        return view('hrm.overtime.create', compact('employees'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'date' => 'required|date',
            'hours' => 'required|numeric|min:0',
            'reason' => 'required|string',
            'status' => 'required|in:pending,approved,rejected',
            'approved_by' => 'nullable|exists:users,id'
        ]);

        Overtime::create($request->all());

        return redirect()->route('hrm.overtime.index')
            ->with('success', 'Overtime record created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $overtime = Overtime::with('user')->findOrFail($id);
        return view('hrm.overtime.show', compact('overtime'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $overtime = Overtime::findOrFail($id);
        $employees = User::all();
        return view('hrm.overtime.edit', compact('overtime', 'employees'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'date' => 'required|date',
            'hours' => 'required|numeric|min:0',
            'reason' => 'required|string',
            'status' => 'required|in:pending,approved,rejected',
            'approved_by' => 'nullable|exists:users,id'
        ]);

        $overtime = Overtime::findOrFail($id);
        $overtime->update($request->all());

        return redirect()->route('hrm.overtime.index')
            ->with('success', 'Overtime record updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $overtime = Overtime::findOrFail($id);
        $overtime->delete();

        return redirect()->route('hrm.overtime.index')
            ->with('success', 'Overtime record deleted successfully.');
    }
}