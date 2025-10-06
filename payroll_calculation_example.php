<?php

class PayrollCalculator {
    private $basicSalary;
    private $workingDays;
    
    public function __construct($basicSalary, $workingDays = 30) {
        $this->basicSalary = $basicSalary;
        $this->workingDays = $workingDays;
    }
    
    /**
     * Calculate payroll based on attendance records
     */
    public function calculatePayroll($attendanceRecords) {
        $totalDeductions = 0;
        $presentDays = 0;
        $absentDays = 0;
        $lateDays = 0;
        $halfDays = 0;
        $leaveDays = 0;
        
        foreach ($attendanceRecords as $record) {
            switch ($record->status) {
                case 'present':
                    $presentDays++;
                    break;
                    
                case 'absent':
                    $absentDays++;
                    $totalDeductions += $this->calculateDailyWage();
                    break;
                    
                case 'late':
                    $lateDays++;
                    // Example: 10% deduction for being late
                    $totalDeductions += $this->calculateDailyWage() * 0.10;
                    break;
                    
                case 'half_day':
                    $halfDays++;
                    // Half day means half pay
                    $totalDeductions += $this->calculateDailyWage() * 0.50;
                    break;
                    
                case 'on_leave':
                    $leaveDays++;
                    // Assuming paid leave, no deduction
                    // If unpaid leave, uncomment the next line:
                    // $totalDeductions += $this->calculateDailyWage();
                    break;
            }
        }
        
        $netSalary = $this->basicSalary - $totalDeductions;
        
        return [
            'basic_salary' => $this->basicSalary,
            'total_deductions' => $totalDeductions,
            'net_salary' => $netSalary,
            'attendance_summary' => [
                'present' => $presentDays,
                'absent' => $absentDays,
                'late' => $lateDays,
                'half_day' => $halfDays,
                'leave' => $leaveDays
            ]
        ];
    }
    
    /**
     * Calculate daily wage based on basic salary and working days
     */
    private function calculateDailyWage() {
        return $this->basicSalary / $this->workingDays;
    }
}

// Example usage:
// $calculator = new PayrollCalculator(30000); // Basic salary of 30,000 for 30 working days
// $payroll = $calculator->calculatePayroll($attendanceRecords);
// echo "Net Salary: " . $payroll['net_salary'];

?>