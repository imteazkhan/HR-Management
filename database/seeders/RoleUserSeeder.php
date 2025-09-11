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

        // Create manager user
        User::create([
            'name' => 'John Manager',
            'email' => 'manager@hrmanagement.com',
            'password' => Hash::make('password'),
            'role' => 'manager',
            'email_verified_at' => now(),
        ]);

        // Create employee user
        User::create([
            'name' => 'Jane Employee',
            'email' => 'employee@hrmanagement.com',
            'password' => Hash::make('password'),
            'role' => 'employee',
            'email_verified_at' => now(),
        ]);
    }
}
