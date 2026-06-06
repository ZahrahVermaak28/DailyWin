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
        $admin = UserAZU::factory()->admin()->create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
        ]);

        $teamMembers = collect([
            ['name' => 'Ava Johnson', 'email' => 'ava.johnson@example.com'],
            ['name' => 'Brian Smith', 'email' => 'brian.smith@example.com'],
            ['name' => 'Chipo Moyo', 'email' => 'chipo.moyo@example.com'],
            ['name' => 'Daniel Carter', 'email' => 'daniel.carter@example.com'],
            ['name' => 'Emily Brown', 'email' => 'emily.brown@example.com'],
        ])->map(fn (array $user) => UserAZU::factory()->teamMember()->create([
            ...$user,
            'password' => Hash::make('password'),
        ]));

        collect([
            ['name' => 'Guest Reviewer', 'email' => 'guest.reviewer@example.com'],
            ['name' => 'External Auditor', 'email' => 'external.auditor@example.com'],
        ])->each(fn (array $user) => UserAZU::factory()->guest()->create([
            ...$user,
            'password' => Hash::make('password'),
        ]));

        $categories = collect([
            ['name' => 'Bug Fixes', 'slug' => 'bug-fixes'],
            ['name' => 'Security', 'slug' => 'security'],
            ['name' => 'Customer Support', 'slug' => 'customer-support'],
            ['name' => 'Documentation', 'slug' => 'documentation'],
            ['name' => 'Reporting', 'slug' => 'reporting'],
            ['name' => 'Testing', 'slug' => 'testing'],
            ['name' => 'Refactoring', 'slug' => 'refactoring'],
        ])->map(fn (array $category) => CategoryAZU::create($category));

        $tasks = [
            [
                'title' => 'Fix critical login bug affecting production users',
                'description' => 'Investigate the failed login reports, identify the root cause, deploy a tested fix, and confirm that affected production users can sign in again.',
                'priority' => 'high',
                'status' => 'in_progress',
                'due_date' => now()->addDays(1)->toDateString(),
                'categories' => ['Bug Fixes', 'Customer Support'],
            ],
            [
                'title' => 'Deploy security patch for CVE-2024-123 by Friday',
                'description' => 'Apply the required security patch, run regression checks, and document the deployment steps for audit tracking.',
                'priority' => 'high',
                'status' => 'pending',
                'due_date' => now()->next('Friday')->toDateString(),
                'categories' => ['Security'],
            ],
            [
                'title' => 'Resolve customer payment issue #4423',
                'description' => 'Review the failed payment logs for ticket #4423, correct the billing workflow issue, and update the customer support team with the resolution.',
                'priority' => 'high',
                'status' => 'pending',
                'due_date' => now()->addDays(2)->toDateString(),
                'categories' => ['Customer Support', 'Bug Fixes'],
            ],
            [
                'title' => 'Complete Q3 financial report for stakeholders',
                'description' => 'Compile the final Q3 financial figures, verify the totals, and prepare the stakeholder-ready report for review.',
                'priority' => 'medium',
                'status' => 'in_progress',
                'due_date' => now()->addWeek()->toDateString(),
                'categories' => ['Reporting'],
            ],
            [
                'title' => 'Review pull request #127 from development branch',
                'description' => 'Check the code changes in pull request #127, test the affected workflow locally, and leave clear review comments for the developer.',
                'priority' => 'medium',
                'status' => 'pending',
                'due_date' => now()->addDays(4)->toDateString(),
                'categories' => ['Testing'],
            ],
            [
                'title' => 'Update API documentation for new endpoints',
                'description' => 'Document the new API endpoints, include request and response examples, and confirm the documentation matches the current implementation.',
                'priority' => 'medium',
                'status' => 'pending',
                'due_date' => now()->addDays(6)->toDateString(),
                'categories' => ['Documentation'],
            ],
            [
                'title' => 'Refactor old service classes for better maintainability',
                'description' => 'Clean up outdated service classes, remove duplicated logic, and keep behavior unchanged while improving readability.',
                'priority' => 'low',
                'status' => 'pending',
                'due_date' => now()->addWeeks(2)->toDateString(),
                'categories' => ['Refactoring'],
            ],
            [
                'title' => 'Write unit tests for notification service',
                'description' => 'Add focused unit tests for the notification service to cover successful delivery, failed delivery, and invalid recipient scenarios.',
                'priority' => 'low',
                'status' => 'in_progress',
                'due_date' => now()->addDays(10)->toDateString(),
                'categories' => ['Testing'],
            ],
            [
                'title' => 'Create onboarding guide for new developers',
                'description' => 'Write a practical onboarding guide that explains local setup, coding standards, common commands, and the first tasks new developers should complete.',
                'priority' => 'low',
                'status' => 'completed',
                'due_date' => now()->addWeeks(3)->toDateString(),
                'categories' => ['Documentation'],
            ],
        ];

        foreach ($tasks as $index => $taskData) {
            $taskCategories = $taskData['categories'];
            unset($taskData['categories']);

            $task = TaskAZU::create([
                ...$taskData,
                'created_by' => $admin->id,
                'assigned_to' => $teamMembers[$index % $teamMembers->count()]->id,
            ]);

            $task->categories()->sync(
                $categories
                    ->whereIn('name', $taskCategories)
                    ->pluck('id')
                    ->all()
            );
        }
    }
}
