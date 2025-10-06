<?php

namespace App\Http\Controllers\HRM;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\OfficeLoan;
use App\Models\PersonalLoan;
use App\Models\User;

class LoanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('hrm.loans.index');
    }

    /**
     * Display office loan index.
     */
    public function officeIndex()
    {
        $loanData = OfficeLoan::with('user')->get();
        return view('hrm.loans.office.index', compact('loanData'));
    }

    /**
     * Display personal loan index.
     */
    public function personalIndex()
    {
        $loanData = PersonalLoan::with('user')->get();
        return view('hrm.loans.personal.index', compact('loanData'));
    }

    /**
     * Show the form for creating office loan.
     */
    public function createOffice()
    {
        $employees = User::all();
        return view('hrm.loans.office.create', compact('employees'));
    }

    /**
     * Show the form for creating personal loan.
     */
    public function createPersonal()
    {
        $employees = User::all();
        return view('hrm.loans.personal.create', compact('employees'));
    }

    /**
     * Store office loan.
     */
    public function storeOffice(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'amount' => 'required|numeric|min:0',
            'application_date' => 'required|date',
            'repayment_term' => 'required|integer|min:1',
            'interest_rate' => 'nullable|numeric|min:0',
            'purpose' => 'required|string',
            'notes' => 'nullable|string',
            'status' => 'required|in:pending,approved,rejected,completed'
        ]);

        OfficeLoan::create($request->all());

        return redirect()->route('hrm.loans.office.index')
            ->with('success', 'Office loan created successfully!');
    }

    /**
     * Store personal loan.
     */
    public function storePersonal(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'amount' => 'required|numeric|min:0',
            'application_date' => 'required|date',
            'repayment_term' => 'required|integer|min:1',
            'interest_rate' => 'nullable|numeric|min:0',
            'purpose' => 'required|string',
            'notes' => 'nullable|string',
            'status' => 'required|in:pending,approved,rejected,completed'
        ]);

        PersonalLoan::create($request->all());

        return redirect()->route('hrm.loans.personal.index')
            ->with('success', 'Personal loan created successfully!');
    }

    /**
     * Display office loan details.
     */
    public function showOffice($id)
    {
        $loanDetails = OfficeLoan::with('user')->findOrFail($id);
        return view('hrm.loans.office.show', compact('loanDetails'));
    }

    /**
     * Display personal loan details.
     */
    public function showPersonal($id)
    {
        $loanDetails = PersonalLoan::with('user')->findOrFail($id);
        return view('hrm.loans.personal.show', compact('loanDetails'));
    }

    /**
     * Approve office loan.
     */
    public function approveOffice($id)
    {
        $loan = OfficeLoan::findOrFail($id);
        $loan->update(['status' => 'approved']);

        return redirect()->back()->with('success', 'Office loan approved successfully!');
    }

    /**
     * Approve personal loan.
     */
    public function approvePersonal($id)
    {
        $loan = PersonalLoan::findOrFail($id);
        $loan->update(['status' => 'approved']);

        return redirect()->back()->with('success', 'Personal loan approved successfully!');
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
        $loan = OfficeLoan::findOrFail($id);
        $employees = User::all();
        return view('hrm.loans.office.edit', compact('loan', 'employees'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'amount' => 'required|numeric|min:0',
            'application_date' => 'required|date',
            'repayment_term' => 'required|integer|min:1',
            'interest_rate' => 'nullable|numeric|min:0',
            'purpose' => 'required|string',
            'notes' => 'nullable|string',
            'status' => 'required|in:pending,approved,rejected,completed'
        ]);

        $loan = OfficeLoan::findOrFail($id);
        $loan->update($request->all());

        return redirect()->route('hrm.loans.office.index')
            ->with('success', 'Office loan updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $loan = OfficeLoan::findOrFail($id);
        $loan->delete();

        return redirect()->route('hrm.loans.office.index')
            ->with('success', 'Office loan deleted successfully!');
    }
}