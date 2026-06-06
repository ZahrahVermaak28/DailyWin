<?php

namespace App\Repositories;

use App\Models\TaskAZU;
use Illuminate\Database\Eloquent\Collection;

interface TaskRepositoryAZU
{
    public function getAllTasks(): Collection;
    public function getTaskById(int $id): ?TaskAZU;
    public function createTask(array $data): TaskAZU;
    public function updateTask(int $id, array $data): ?TaskAZU;
    public function deleteTask(int $id): bool;
    public function getTasksCreatedByUser(int $userId): Collection;
    public function getTasksAssignedToUser(int $userId): Collection;
}
