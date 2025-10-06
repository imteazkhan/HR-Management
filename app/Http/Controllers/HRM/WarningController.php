<?php

namespace App\Http\Controllers\HRM;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Warning;
use App\Models\User;

class WarningController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $warnings = Warning::with('user', 'issuer')->get();
        return view('hrm.warnings.index', compact('warnings'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $employees = User::all();
        return view('hrm.warnings.create', compact('employees'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'issued_by' => 'required|exists:users,id',
            'date' => 'required|date',
            'reason' => 'required|string|max:255',
            'description' => 'required|string',
            'status' => 'required|in:active,resolved,dismissed'
        ]);

        Warning::create($request->all());

        return redirect()->route('hrm.warnings.index')
            ->with('success', 'Warning issued successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $warning = Warning::with('user', 'issuer')->findOrFail($id);
        return view('hrm.warnings.show', compact('warning'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $warning = Warning::findOrFail($id);
        $employees = User::all();
        return view('hrm.warnings.edit', compact('warning', 'employees'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'issued_by' => 'required|exists:users,id',
            'date' => 'required|date',
            'reason' => 'required|string|max:255',
            'description' => 'required|string',
            'status' => 'required|in:active,resolved,dismissed'
        ]);

        $warning = Warning::findOrFail($id);
        $warning->update($request->all());

        return redirect()->route('hrm.warnings.index')
            ->with('success', 'Warning updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $warning = Warning::findOrFail($id);
        $warning->delete();

        return redirect()->route('hrm.warnings.index')
            ->with('success', 'Warning deleted successfully.');
    }
}