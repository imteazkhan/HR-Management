<?php

namespace App\Http\Controllers\HRM;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LoanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Display office loan index.
     */
    public function officeIndex()
    {
        // Dummy data for office loans
        $loanData = [
            ['employee' => 'John Doe', 'amount' => '$5,000', 'date' => '2024-01-15', 'status' => 'Approved'],
            ['employee' => 'Jane Smith', 'amount' => '$3,000', 'date' => '2024-01-10', 'status' => 'Pending'],
            ['employee' => 'Robert Johnson', 'amount' => '$7,500', 'date' => '2024-01-05', 'status' => 'Rejected'],
        ];
        
        return view('dashboards.Admin.loan.office', compact('loanData'));
    }

    /**
     * Display personal loan index.
     */
    public function personalIndex()
    {
        // Dummy data for personal loans
        $loanData = [
            ['employee' => 'John Doe', 'amount' => '$2,000', 'date' => '2024-01-12', 'status' => 'Approved'],
            ['employee' => 'Jane Smith', 'amount' => '$1,500', 'date' => '2024-01-08', 'status' => 'Pending'],
            ['employee' => 'Robert Johnson', 'amount' => '$3,000', 'date' => '2024-01-03', 'status' => 'Rejected'],
        ];
        
        return view('dashboards.Admin.loan.personal', compact('loanData'));
    }

    /**
     * Show the form for creating office loan.
     */
    public function createOffice()
    {
        return view('dashboards.Admin.loan.create-office');
    }

    /**
     * Show the form for creating personal loan.
     */
    public function createPersonal()
    {
        return view('dashboards.Admin.loan.create-personal');
    }

    /**
     * Store office loan.
     */
    public function storeOffice(Request $request)
    {
        // Process office loan storage logic here
        return redirect()->back()->with('success', 'Office loan created successfully!');
    }

    /**
     * Store personal loan.
     */
    public function storePersonal(Request $request)
    {
        // Process personal loan storage logic here
        return redirect()->back()->with('success', 'Personal loan created successfully!');
    }

    /**
     * Display office loan details.
     */
    public function showOffice($loan)
    {
        // Dummy data for office loan details
        $loanDetails = [
            'employee' => 'John Doe',
            'amount' => '$5,000',
            'date' => '2024-01-15',
            'status' => 'Approved',
            'purpose' => 'Home renovation',
            'repayment_term' => '12 months',
        ];
        
        return view('dashboards.Admin.loan.show-office', compact('loanDetails'));
    }

    /**
     * Display personal loan details.
     */
    public function showPersonal($loan)
    {
        // Dummy data for personal loan details
        $loanDetails = [
            'employee' => 'John Doe',
            'amount' => '$2,000',
            'date' => '2024-01-12',
            'status' => 'Approved',
            'purpose' => 'Medical expenses',
            'repayment_term' => '6 months',
        ];
        
        return view('dashboards.Admin.loan.show-personal', compact('loanDetails'));
    }

    /**
     * Approve office loan.
     */
    public function approveOffice($loan)
    {
        // Process office loan approval logic here
        return redirect()->back()->with('success', 'Office loan approved successfully!');
    }

    /**
     * Approve personal loan.
     */
    public function approvePersonal($loan)
    {
        // Process personal loan approval logic here
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