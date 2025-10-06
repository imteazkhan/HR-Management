<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class AttendanceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $today = Carbon::today()->format('Y-m-d');
        
        // Clear existing attendance for today
        DB::table('employee_attendances')->where('date', $today)->delete();
        DB::table('admin_attendances')->where('date', $today)->delete();
        DB::table('manager_attendances')->where('date', $today)->delete();
        
        // Get user IDs by role
        $employees = DB::table('users')->where('role', 'employee')->pluck('id')->toArray();
        $admins = DB::table('users')->where('role', 'admin')->pluck('id')->toArray();
        $managers = DB::table('users')->where('role', 'manager')->pluck('id')->toArray();
        
        // Add sample employee attendance
        foreach (array_slice($employees, 0, 5) as $index => $userId) {
            DB::table('employee_attendances')->insert([
                'user_id' => $userId,
                'date' => $today,
                'status' => $index < 4 ? 'present' : 'absent',
                'check_in' => $index < 4 ? '09:' . str_pad($index * 15, 2, '0', STR_PAD_LEFT) . ':00' : null,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
        
        // Add sample admin attendance
        foreach (array_slice($admins, 0, 3) as $index => $userId) {
            DB::table('admin_attendances')->insert([
                'user_id' => $userId,
                'date' => $today,
                'status' => $index < 2 ? 'present' : 'absent',
                'check_in' => $index < 2 ? '08:' . str_pad(30 + $index * 15, 2, '0', STR_PAD_LEFT) . ':00' : null,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
        
        // Add sample manager attendance
        foreach (array_slice($managers, 0, 4) as $index => $userId) {
            $minutes = 45 + $index * 5; // 45, 50, 55, 00
            if ($minutes >= 60) {
                $hour = 9;
                $minutes = $minutes - 60;
            } else {
                $hour = 8;
            }
            
            DB::table('manager_attendances')->insert([
                'user_id' => $userId,
                'date' => $today,
                'status' => $index < 3 ? 'present' : 'absent',
                'check_in' => $index < 3 ? str_pad($hour, 2, '0', STR_PAD_LEFT) . ':' . str_pad($minutes, 2, '0', STR_PAD_LEFT) . ':00' : null,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
        
        $this->command->info('Sample attendance data created successfully!');
    }
}