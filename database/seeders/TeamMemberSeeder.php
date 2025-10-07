<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\TeamMember;

class TeamMemberSeeder extends Seeder
{
    public function run()
    {
        // Get all managers and employees
        $managers = User::where('role', 'manager')->get();
        $employees = User::where('role', 'employee')->get();

        if ($managers->isEmpty() || $employees->isEmpty()) {
            $this->command->info('No managers or employees found. Creating sample relationships...');
            return;
        }

        // Assign employees to managers
        foreach ($employees as $index => $employee) {
            $manager = $managers[$index % $managers->count()]; // Distribute employees among managers
            
            TeamMember::create([
                'manager_id' => $manager->id,
                'employee_id' => $employee->id,
                'position' => 'Team Member',
                'join_date' => now()->subDays(rand(30, 365)),
                'status' => 'active',
                'notes' => 'Auto-assigned team member'
            ]);
        }

        $this->command->info('Team member relationships created successfully!');
    }
}