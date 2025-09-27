<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class RoleUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create superadmin user
        User::create([
            'name' => 'Super Administrator',
            'email' => 'superadmin@hrmanagement.com',
            'password' => Hash::make('password'),
            'role' => 'superadmin',
            'email_verified_at' => now(),
        ]);

        // Create manager users
        User::create([
            'name' => 'John Manager',
            'email' => 'manager@hrmanagement.com',
            'password' => Hash::make('password'),
            'role' => 'manager',
            'email_verified_at' => now(),
        ]);

        User::create([
            'name' => 'Sarah Johnson',
            'email' => 'sarah.johnson@hrmanagement.com',
            'password' => Hash::make('password'),
            'role' => 'manager',
            'email_verified_at' => now(),
        ]);

        User::create([
            'name' => 'Mike Wilson',
            'email' => 'mike.wilson@hrmanagement.com',
            'password' => Hash::make('password'),
            'role' => 'manager',
            'email_verified_at' => now(),
        ]);

        // Create employee users
        $employees = [
            ['name' => 'Jane Employee', 'email' => 'employee@hrmanagement.com'],
            ['name' => 'Alex Rodriguez', 'email' => 'alex.rodriguez@hrmanagement.com'],
            ['name' => 'Emily Davis', 'email' => 'emily.davis@hrmanagement.com'],
            ['name' => 'David Brown', 'email' => 'david.brown@hrmanagement.com'],
            ['name' => 'Lisa Anderson', 'email' => 'lisa.anderson@hrmanagement.com'],
            ['name' => 'Robert Taylor', 'email' => 'robert.taylor@hrmanagement.com'],
            ['name' => 'Jennifer White', 'email' => 'jennifer.white@hrmanagement.com'],
            ['name' => 'Christopher Lee', 'email' => 'christopher.lee@hrmanagement.com'],
            ['name' => 'Amanda Garcia', 'email' => 'amanda.garcia@hrmanagement.com'],
            ['name' => 'Kevin Martinez', 'email' => 'kevin.martinez@hrmanagement.com'],
            ['name' => 'Michelle Thompson', 'email' => 'michelle.thompson@hrmanagement.com'],
            ['name' => 'Brian Clark', 'email' => 'brian.clark@hrmanagement.com'],
            ['name' => 'Ashley Lewis', 'email' => 'ashley.lewis@hrmanagement.com'],
            ['name' => 'Daniel Walker', 'email' => 'daniel.walker@hrmanagement.com'],
            ['name' => 'Nicole Hall', 'email' => 'nicole.hall@hrmanagement.com'],
        ];

        foreach ($employees as $employee) {
            User::create([
                'name' => $employee['name'],
                'email' => $employee['email'],
                'password' => Hash::make('password'),
                'role' => 'employee',
                'email_verified_at' => now(),
                'created_at' => now()->subDays(rand(1, 365)),
            ]);
        }
    }
}
