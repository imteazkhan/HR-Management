<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Department;
use App\Models\Designation;
use App\Models\EmployeeProfile;
use App\Models\Holiday;
use App\Models\LeaveBalance;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class HRMSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create departments if they don't exist
        $departments = [
            ['name' => 'Human Resources', 'description' => 'HR Department', 'is_active' => true],
            ['name' => 'Information Technology', 'description' => 'IT Department', 'is_active' => true],
            ['name' => 'Finance', 'description' => 'Finance Department', 'is_active' => true],
            ['name' => 'Marketing', 'description' => 'Marketing Department', 'is_active' => true],
            ['name' => 'Operations', 'description' => 'Operations Department', 'is_active' => true],
        ];

        foreach ($departments as $dept) {
            Department::firstOrCreate(['name' => $dept['name']], $dept);
        }

        // Create designations
        $designations = [
            ['title' => 'Software Engineer', 'department_id' => 2, 'level' => 'mid', 'min_salary' => 50000, 'max_salary' => 80000],
            ['title' => 'Senior Software Engineer', 'department_id' => 2, 'level' => 'senior', 'min_salary' => 80000, 'max_salary' => 120000],
            ['title' => 'HR Manager', 'department_id' => 1, 'level' => 'manager', 'min_salary' => 60000, 'max_salary' => 90000],
            ['title' => 'Finance Analyst', 'department_id' => 3, 'level' => 'mid', 'min_salary' => 45000, 'max_salary' => 70000],
            ['title' => 'Marketing Specialist', 'department_id' => 4, 'level' => 'junior', 'min_salary' => 35000, 'max_salary' => 55000],
        ];

        foreach ($designations as $designation) {
            Designation::firstOrCreate(['title' => $designation['title']], $designation);
        }

        // Create sample employees
        $employees = [
            [
                'name' => 'John Doe',
                'email' => 'john.doe@company.com',
                'role' => 'employee',
                'department_id' => 2,
                'designation_id' => 1,
                'profile' => [
                    'first_name' => 'John',
                    'last_name' => 'Doe',
                    'phone' => '+1234567890',
                    'joining_date' => '2024-01-15',
                    'salary' => 65000,
                    'employment_type' => 'full_time',
                ]
            ],
            [
                'name' => 'Jane Smith',
                'email' => 'jane.smith@company.com',
                'role' => 'employee',
                'department_id' => 1,
                'designation_id' => 3,
                'profile' => [
                    'first_name' => 'Jane',
                    'last_name' => 'Smith',
                    'phone' => '+1234567891',
                    'joining_date' => '2023-06-01',
                    'salary' => 75000,
                    'employment_type' => 'full_time',
                ]
            ],
            [
                'name' => 'Mike Johnson',
                'email' => 'mike.johnson@company.com',
                'role' => 'employee',
                'department_id' => 3,
                'designation_id' => 4,
                'profile' => [
                    'first_name' => 'Mike',
                    'last_name' => 'Johnson',
                    'phone' => '+1234567892',
                    'joining_date' => '2024-03-10',
                    'salary' => 55000,
                    'employment_type' => 'full_time',
                ]
            ],
        ];

        foreach ($employees as $empData) {
            $user = User::firstOrCreate(
                ['email' => $empData['email']],
                [
                    'name' => $empData['name'],
                    'email' => $empData['email'],
                    'password' => Hash::make('password123'),
                    'role' => $empData['role'],
                    'department_id' => $empData['department_id'],
                    'designation_id' => $empData['designation_id'],
                ]
            );

            // Create employee profile
            $employeeId = 'EMP' . str_pad($user->id, 4, '0', STR_PAD_LEFT);
            EmployeeProfile::firstOrCreate(
                ['user_id' => $user->id],
                array_merge($empData['profile'], [
                    'user_id' => $user->id,
                    'employee_id' => $employeeId,
                ])
            );

            // Create leave balance for current year
            LeaveBalance::firstOrCreate(
                ['user_id' => $user->id, 'year' => date('Y')],
                ['user_id' => $user->id, 'year' => date('Y')]
            );
        }

        // Create sample holidays
        $currentYear = date('Y');
        $holidays = [
            ['name' => 'New Year\'s Day', 'date' => $currentYear . '-01-01', 'type' => 'national'],
            ['name' => 'Independence Day', 'date' => $currentYear . '-07-04', 'type' => 'national'],
            ['name' => 'Christmas Day', 'date' => $currentYear . '-12-25', 'type' => 'national'],
            ['name' => 'Company Foundation Day', 'date' => $currentYear . '-05-15', 'type' => 'company'],
            ['name' => 'Labor Day', 'date' => $currentYear . '-09-01', 'type' => 'national'],
        ];

        foreach ($holidays as $holiday) {
            Holiday::firstOrCreate(
                ['name' => $holiday['name'], 'date' => $holiday['date']],
                array_merge($holiday, ['year' => $currentYear])
            );
        }
    }
}
