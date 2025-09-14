<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Message;
use App\Models\Notification;
use App\Models\ManagerSetting;
use App\Models\TeamMember;
use App\Models\PerformanceReview;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class ManagerDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create some users if they don't exist
        $superadmin = User::firstOrCreate(
            ['email' => 'admin@example.com'],
            [
                'name' => 'Super Admin',
                'password' => Hash::make('password'),
                'role' => 'superadmin'
            ]
        );

        $manager1 = User::firstOrCreate(
            ['email' => 'manager1@example.com'],
            [
                'name' => 'John Manager',
                'password' => Hash::make('password'),
                'role' => 'manager'
            ]
        );

        $manager2 = User::firstOrCreate(
            ['email' => 'manager2@example.com'],
            [
                'name' => 'Sarah Wilson',
                'password' => Hash::make('password'),
                'role' => 'manager'
            ]
        );

        $employee1 = User::firstOrCreate(
            ['email' => 'employee1@example.com'],
            [
                'name' => 'John Smith',
                'password' => Hash::make('password'),
                'role' => 'employee'
            ]
        );

        $employee2 = User::firstOrCreate(
            ['email' => 'employee2@example.com'],
            [
                'name' => 'Mike Davis',
                'password' => Hash::make('password'),
                'role' => 'employee'
            ]
        );

        $employee3 = User::firstOrCreate(
            ['email' => 'employee3@example.com'],
            [
                'name' => 'Emily Johnson',
                'password' => Hash::make('password'),
                'role' => 'employee'
            ]
        );

        // Create Messages
        Message::create([
            'subject' => 'Team Meeting Tomorrow',
            'message' => 'We have a team meeting scheduled for tomorrow at 2 PM in the conference room.',
            'from_user_id' => $superadmin->id,
            'to_user_id' => $manager1->id,
            'type' => 'individual',
            'priority' => 'normal'
        ]);

        Message::create([
            'subject' => 'Project Update Required',
            'message' => 'Please provide updates on your current projects by end of week.',
            'from_user_id' => $manager1->id,
            'to_user_id' => null,
            'type' => 'team',
            'priority' => 'high'
        ]);

        // Create Notifications
        Notification::create([
            'user_id' => $manager1->id,
            'title' => 'New Leave Request',
            'message' => 'John Smith has submitted a new leave request for your review',
            'type' => 'leave_request'
        ]);

        Notification::create([
            'user_id' => $manager1->id,
            'title' => 'Attendance Alert',
            'message' => 'Mike Davis was marked absent today',
            'type' => 'attendance'
        ]);

        // Create Manager Settings
        ManagerSetting::create([
            'user_id' => $manager1->id,
            'email_notifications' => true,
            'push_notifications' => false,
            'weekly_reports' => true,
            'auto_approve_leaves' => false,
            'team_size_limit' => 15
        ]);

        ManagerSetting::create([
            'user_id' => $manager2->id,
            'email_notifications' => true,
            'push_notifications' => true,
            'weekly_reports' => false,
            'auto_approve_leaves' => true,
            'team_size_limit' => 10
        ]);

        // Create Team Members
        TeamMember::create([
            'manager_id' => $manager1->id,
            'employee_id' => $employee1->id,
            'position' => 'Senior Developer',
            'join_date' => now()->subDays(300),
            'status' => 'active'
        ]);

        TeamMember::create([
            'manager_id' => $manager1->id,
            'employee_id' => $employee2->id,
            'position' => 'Data Analyst',
            'join_date' => now()->subDays(150),
            'status' => 'active'
        ]);

        TeamMember::create([
            'manager_id' => $manager2->id,
            'employee_id' => $employee3->id,
            'position' => 'UI/UX Designer',
            'join_date' => now()->subDays(200),
            'status' => 'active'
        ]);

        // Create Performance Reviews
        PerformanceReview::create([
            'employee_id' => $employee1->id,
            'reviewer_id' => $manager1->id,
            'score' => 85,
            'completed_tasks' => 42,
            'on_time_rate' => 95.5,
            'rating' => 'excellent',
            'comments' => 'Great performance, consistently delivers high-quality work.',
            'review_period_start' => now()->subMonths(3),
            'review_period_end' => now()->subMonths(1),
            'status' => 'completed'
        ]);

        PerformanceReview::create([
            'employee_id' => $employee2->id,
            'reviewer_id' => $manager1->id,
            'score' => 78,
            'completed_tasks' => 35,
            'on_time_rate' => 88.2,
            'rating' => 'good',
            'comments' => 'Good overall performance, room for improvement in time management.',
            'review_period_start' => now()->subMonths(3),
            'review_period_end' => now()->subMonths(1),
            'status' => 'completed'
        ]);

        PerformanceReview::create([
            'employee_id' => $employee3->id,
            'reviewer_id' => $manager2->id,
            'score' => 92,
            'completed_tasks' => 38,
            'on_time_rate' => 98.1,
            'rating' => 'outstanding',
            'comments' => 'Exceptional work quality and creativity in design solutions.',
            'review_period_start' => now()->subMonths(3),
            'review_period_end' => now()->subMonths(1),
            'status' => 'completed'
        ]);
    }
}
