<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\EmployeeLeave;
use App\Models\TeamMember;
use Carbon\Carbon;

class SampleLeaveRequestsSeeder extends Seeder
{
    public function run()
    {
        // Get team members
        $teamMembers = TeamMember::with('employee')->get();
        
        $leaveTypes = ['annual', 'sick', 'emergency', 'unpaid'];
        $reasons = [
            'Family vacation trip',
            'Medical appointment',
            'Personal matters',
            'Emergency family situation',
            'Wedding ceremony',
            'Medical treatment',
            'Rest and recovery'
        ];
        
        foreach ($teamMembers->take(3) as $member) {
            // Create 1-2 leave requests per team member
            for ($i = 0; $i < rand(1, 2); $i++) {
                $startDate = Carbon::now()->addDays(rand(1, 30));
                $endDate = $startDate->copy()->addDays(rand(1, 5));
                
                EmployeeLeave::create([
                    'user_id' => $member->employee_id,
                    'leave_type' => $leaveTypes[array_rand($leaveTypes)],
                    'start_date' => $startDate,
                    'end_date' => $endDate,
                    'reason' => $reasons[array_rand($reasons)],
                    'status' => 'pending',
                    'total_days' => $startDate->diffInDays($endDate) + 1,
                    'application_date' => now()
                ]);
            }
        }
        
        $this->command->info('Sample leave requests created successfully!');
    }
}