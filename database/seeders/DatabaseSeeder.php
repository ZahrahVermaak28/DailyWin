<?php

namespace Database\Seeders;

use App\Models\UserAZU;
use App\Models\TaskAZU;
use App\Models\CategoryAZU;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create Admin User (Uyathandwa - Group Leader)
        $uyathandwa = UserAZU::factory()->admin()->create([
            'name' => 'Uyathandwa Ngomana',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
        ]);

        // Create Team Members (Amanda and Zahrah)
        $amanda = UserAZU::factory()->teamMember()->create([
            'name' => 'Amanda Msuthu',
            'email' => 'amanda@example.com',
            'password' => Hash::make('password'),
        ]);

        $zahrah = UserAZU::factory()->teamMember()->create([
            'name' => 'Zahrah Martin',
            'email' => 'zahrah@example.com',
            'password' => Hash::make('password'),
        ]);

        // Create Guest Users
        collect([
            ['name' => 'Guest Reviewer', 'email' => 'guest.reviewer@example.com'],
            ['name' => 'External Auditor', 'email' => 'external.auditor@example.com'],
        ])->each(fn (array $user) => UserAZU::factory()->guest()->create([
            ...$user,
            'password' => Hash::make('password'),
        ]));

        // Create Categories
        $categories = collect([
            ['name' => 'Database', 'slug' => 'database'],
            ['name' => 'Frontend', 'slug' => 'frontend'],
            ['name' => 'Backend', 'slug' => 'backend'],
            ['name' => 'Testing', 'slug' => 'testing'],
            ['name' => 'Deployment', 'slug' => 'deployment'],
            ['name' => 'Documentation', 'slug' => 'documentation'],
        ])->map(fn (array $category) => CategoryAZU::create($category));

        // YOUR 8 TASKS with YOUR GROUP MEMBERS
        $tasks = [
            [
                'title' => 'Design Database Schema',
                'description' => 'Create ERD diagram and design tables for users, tasks, categories, and relationships with proper foreign keys.',
                'priority' => 'high',
                'status' => 'completed',
                'due_date' => now()->subDays(5)->toDateString(),
                'assigned_to' => $amanda->id,
                'categories' => ['Database'],
            ],
            [
                'title' => 'Create Login & Registration',
                'description' => 'Implement authentication using Laravel Breeze with custom role-based login for admin, team members, and guests.',
                'priority' => 'high',
                'status' => 'in_progress',
                'due_date' => now()->addDays(2)->toDateString(),
                'assigned_to' => $zahrah->id,
                'categories' => ['Frontend', 'Backend'],
            ],
            [
                'title' => 'Develop User Dashboard',
                'description' => 'Create dashboard showing task statistics, charts, and recent activity for each user role.',
                'priority' => 'high',
                'status' => 'in_progress',
                'due_date' => now()->addDays(3)->toDateString(),
                'assigned_to' => $uyathandwa->id,
                'categories' => ['Frontend'],
            ],
            [
                'title' => 'Implement Task Assignment',
                'description' => 'Allow admins to assign tasks to team members and guests with email notifications.',
                'priority' => 'medium',
                'status' => 'pending',
                'due_date' => now()->addDays(5)->toDateString(),
                'assigned_to' => $amanda->id,
                'categories' => ['Backend'],
            ],
            [
                'title' => 'Implement Task Status Tracking',
                'description' => 'Add status options: Pending, In Progress, Completed with visual badges and filtering.',
                'priority' => 'medium',
                'status' => 'pending',
                'due_date' => now()->addDays(6)->toDateString(),
                'assigned_to' => $zahrah->id,
                'categories' => ['Backend', 'Frontend'],
            ],
            [
                'title' => 'Create Notification System',
                'description' => 'Send email reminders for tasks due in 24 hours using Laravel Mail and scheduler.',
                'priority' => 'medium',
                'status' => 'pending',
                'due_date' => now()->addDays(7)->toDateString(),
                'assigned_to' => $uyathandwa->id,
                'categories' => ['Backend'],
            ],
            [
                'title' => 'Test Application Features',
                'description' => 'Write unit tests and perform manual testing of all CRUD operations for tasks, categories, and user roles.',
                'priority' => 'low',
                'status' => 'pending',
                'due_date' => now()->addDays(10)->toDateString(),
                'assigned_to' => $amanda->id,
                'categories' => ['Testing'],
            ],
            [
                'title' => 'Deploy Application',
                'description' => 'Push to GitHub, write documentation, and prepare final submission with demo video.',
                'priority' => 'low',
                'status' => 'pending',
                'due_date' => now()->addDays(14)->toDateString(),
                'assigned_to' => $uyathandwa->id,
                'categories' => ['Deployment', 'Documentation'],
            ],
        ];

        // Create all tasks
        foreach ($tasks as $taskData) {
            $taskCategories = $taskData['categories'];
            unset($taskData['categories']);
            unset($taskData['assigned_to']);

            $task = TaskAZU::create([
                ...$taskData,
                'created_by' => $uyathandwa->id,
                'assigned_to' => $taskData['assigned_to'] ?? $uyathandwa->id,
            ]);

            $task->categories()->sync(
                $categories
                    ->whereIn('name', $taskCategories)
                    ->pluck('id')
                    ->all()
            );
        }

        $this->command->info('✅ Database seeded successfully!');
        $this->command->info('');
        $this->command->info('📋 Team Members:');
        $this->command->info('   👑 Admin: Uyathandwa Ngomana');
        $this->command->info('   👤 Team: Amanda Msuthu');
        $this->command->info('   👤 Team: Zahrah Martin');
        $this->command->info('');
        $this->command->info('📋 Tasks Created:');
        $this->command->info('   1. Design Database Schema - Amanda ✅ Completed');
        $this->command->info('   2. Create Login & Registration - Zahrah 🔄 In Progress');
        $this->command->info('   3. Develop User Dashboard - Uyathandwa 🔄 In Progress');
        $this->command->info('   4. Implement Task Assignment - Amanda ⏳ Pending');
        $this->command->info('   5. Implement Task Status Tracking - Zahrah ⏳ Pending');
        $this->command->info('   6. Create Notification System - Uyathandwa ⏳ Pending');
        $this->command->info('   7. Test Application Features - Amanda ⏳ Pending');
        $this->command->info('   8. Deploy Application - Uyathandwa ⏳ Pending');
        $this->command->info('');
        $this->command->info('📧 Login: admin@example.com / password');
        $this->command->info('👥 Group AZU: Uyathandwa • Amanda • Zahrah');
    }
}