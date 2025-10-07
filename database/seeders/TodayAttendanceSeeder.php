<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\EmployeeAttendance;
use App\Models\TeamMember;
use Carbon\Carbon;

class TodayAttendanceSeeder extends Seeder
{
    public function run()
    {
        $today = Carbon::today();
        $teamMembers = TeamMember::with('employee')->get();
        
        foreach ($teamMembers as $member) {
            // Check if attendance already exists for today
            $existing = EmployeeAttendance::where('user_id', $member->employee_id)
                ->whereDate('date', $today)
                ->first();
            
            if (!$existing) {
                $checkInTime = $today->copy()->addHours(8)->addMinutes(rand(-30, 60));
                $hasCheckedOut = rand(0, 1);
                $checkOutTime = $hasCheckedOut ? $checkInTime->copy()->addHours(rand(6, 9)) : null;
                $totalMinutes = $hasCheckedOut ? $checkInTime->diffInMinutes($checkOutTime) : rand(240, 480);
                
                EmployeeAttendance::create([
                    'user_id' => $member->employee_id,
                    'date' => $today,
                    'check_in' => $checkInTime,
                    'check_out' => $checkOutTime,
                    'total_hours' => $totalMinutes,
                    'status' => 'present',
                    'location' => 'Office',
                    'is_manual' => false
                ]);
            }
        }
        
        $this->command->info('Today attendance records created successfully!');
    }
}