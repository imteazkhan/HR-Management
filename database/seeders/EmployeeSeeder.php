<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Department;
use Illuminate\Support\Facades\Hash;

class EmployeeSeeder extends Seeder
{
    public function run()
    {
        // Get available departments
        $departments = Department::all();
        
        // Create sample employees
        $employees = [
            [
                'name' => 'John Smith',
                'email' => 'john.smith@company.com',
                'password' => Hash::make('password123'),
                'role' => 'employee',
                'department_id' => $departments->count() > 0 ? $departments[0]->id : null,
            ],
            [
                'name' => 'Sarah Johnson',
                'email' => 'sarah.johnson@company.com',
                'password' => Hash::make('password123'),
                'role' => 'manager',
                'department_id' => $departments->count() > 1 ? $departments[1]->id : null,
            ],
            [
                'name' => 'Mike Davis',
                'email' => 'mike.davis@company.com',
                'password' => Hash::make('password123'),
                'role' => 'employee',
                'department_id' => $departments->count() > 2 ? $departments[2]->id : null,
            ],
            [
                'name' => 'Emily Wilson',
                'email' => 'emily.wilson@company.com',
                'password' => Hash::make('password123'),
                'role' => 'manager',
                'department_id' => $departments->count() > 3 ? $departments[3]->id : null,
            ],
            [
                'name' => 'David Brown',
                'email' => 'david.brown@company.com',
                'password' => Hash::make('password123'),
                'role' => 'employee',
                'department_id' => $departments->count() > 0 ? $departments[0]->id : null,
            ],
        ];

        foreach ($employees as $employee) {
            User::updateOrCreate(
                ['email' => $employee['email']],
                $employee
            );
        }

        $this->command->info('Sample employees created successfully!');
    }
}