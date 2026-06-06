<?php

namespace Database\Factories;

use App\Models\TaskAZU;
use App\Models\UserAZU;
use App\Enums\TaskStatusEnum;
use App\Enums\TaskPriorityEnum;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<TaskAZU>
 */
class TaskAZUFactory extends Factory
{
    protected $model = TaskAZU::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $users = UserAZU::query()->where('role', '!=', 'guest')->get();
        $createdBy = $users->random()->id;
        $assignedTo = $users->random()->id;

        return [
            'title' => fake()->sentence(),
            'description' => fake()->paragraph(),
            'status' => fake()->randomElement(TaskStatusEnum::cases()),
            'priority' => fake()->randomElement(TaskPriorityEnum::cases()),
            'due_date' => fake()->dateTimeBetween('now', '+1 year')->format('Y-m-d'),
            'created_by' => $createdBy,
            'assigned_to' => $assignedTo,
        ];
    }
}
