<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use App\Models\Payroll;

class TestPayroll extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test:payroll';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Test payroll processing';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Testing payroll processing...');
        
        // Get all employees
        $employees = User::where('role', 'employee')->get();
        $this->info('Found ' . $employees->count() . ' employees');
        
        // Process payroll for current month
        $month = date('Y-m');
        $monthName = date('F Y');
        
        $this->info('Processing payroll for ' . $monthName);
        
        foreach ($employees as $employee) {
            // Skip if payroll already exists for this employee and month
            $existingPayroll = Payroll::where('user_id', $employee->id)
                ->where('month', $monthName)
                ->first();
                
            if ($existingPayroll) {
                $this->info('Payroll already exists for ' . $employee->name);
                continue;
            }
            
            // Calculate salary based on employee data (mock calculation)
            $baseSalary = rand(25000, 50000); // BDT
            $bonuses = rand(0, 5000); // BDT
            $deductions = rand(0, 3000); // BDT
            $netSalary = $baseSalary + $bonuses - $deductions;
            
            // Create payroll record
            Payroll::create([
                'user_id' => $employee->id,
                'employee_name' => $employee->name,
                'position' => 'Employee',
                'base_salary' => $baseSalary,
                'bonuses' => $bonuses,
                'deductions' => $deductions,
                'net_salary' => $netSalary,
                'month' => $monthName,
                'status' => 'processed'
            ]);
            
            $this->info('Processed payroll for ' . $employee->name);
        }
        
        $this->info('Payroll processing completed!');
    }
}