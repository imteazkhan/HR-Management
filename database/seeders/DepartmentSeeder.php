<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Department;
use App\Models\User;

class DepartmentSeeder extends Seeder
{
    public function run()
    {
        // Get some users who can be managers
        $managers = User::where('role', 'manager')->orWhere('role', 'employee')->limit(5)->get();
        
        // Create sample departments
        $departments = [
            [
                'name' => 'Human Resources',
                'description' => 'Manages employee relations, recruitment, and company policies.',
                'location' => 'Building A, Floor 2',
                'budget' => '$250,000',
                'max_employees' => 15,
                'is_active' => true,
                'manager_id' => $managers->count() > 0 ? $managers[0]->id : null,
            ],
            [
                'name' => 'Information Technology',
                'description' => 'Responsible for maintaining IT infrastructure and software development.',
                'location' => 'Building B, Floor 3',
                'budget' => '$500,000',
                'max_employees' => 25,
                'is_active' => true,
                'manager_id' => $managers->count() > 1 ? $managers[1]->id : null,
            ],
            [
                'name' => 'Finance & Accounting',
                'description' => 'Handles financial planning, budgeting, and accounting operations.',
                'location' => 'Building A, Floor 1',
                'budget' => '$200,000',
                'max_employees' => 12,
                'is_active' => true,
                'manager_id' => $managers->count() > 2 ? $managers[2]->id : null,
            ],
            [
                'name' => 'Marketing & Sales',
                'description' => 'Develops marketing strategies and manages sales operations.',
                'location' => 'Building C, Floor 1',
                'budget' => '$300,000',
                'max_employees' => 20,
                'is_active' => true,
                'manager_id' => $managers->count() > 3 ? $managers[3]->id : null,
            ],
            [
                'name' => 'Operations',
                'description' => 'Oversees daily operations and process improvements.',
                'location' => 'Building A, Floor 3',
                'budget' => '$180,000',
                'max_employees' => 18,
                'is_active' => true,
                'manager_id' => $managers->count() > 4 ? $managers[4]->id : null,
            ],
        ];

        foreach ($departments as $department) {
            Department::updateOrCreate(
                ['name' => $department['name']],
                $department
            );
        }

        $this->command->info('Sample departments created successfully!');
    }
}