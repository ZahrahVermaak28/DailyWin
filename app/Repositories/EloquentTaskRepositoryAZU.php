<?php

namespace App\Repositories;

use App\Models\TaskAZU;
use Illuminate\Database\Eloquent\Collection;

class EloquentTaskRepositoryAZU implements TaskRepositoryAZU
{
    public function getAllTasks(): Collection
    {
        return TaskAZU::all();
    }

    public function getTaskById(int $id): ?TaskAZU
    {
        return TaskAZU::find($id);
    }

    public function createTask(array $data): TaskAZU
    {
        return TaskAZU::create($data);
    }

    public function updateTask(int $id, array $data): ?TaskAZU
    {
        $task = $this->getTaskById($id);
        if ($task) {
            $task->update($data);
            return $task;
        }
        return null;
    }

    public function deleteTask(int $id): bool
    {
        return TaskAZU::destroy($id);
    }

    public function getTasksCreatedByUser(int $userId): Collection
    {
        return TaskAZU::createdBy($userId)->get();
    }

    public function getTasksAssignedToUser(int $userId): Collection
    {
        return TaskAZU::assignedTo($userId)->get();
    }
}
