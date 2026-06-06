<?php

namespace App\Services;

use App\Models\TaskAZU;
use App\Repositories\TaskRepositoryAZU;
use Illuminate\Database\Eloquent\Collection;

class TaskServiceAZU
{
    protected $taskRepository;

    public function __construct(TaskRepositoryAZU $taskRepository)
    {
        $this->taskRepository = $taskRepository;
    }

    public function getAllTasks(): Collection
    {
        return $this->taskRepository->getAllTasks();
    }

    public function getTaskById(int $id): ?TaskAZU
    {
        return $this->taskRepository->getTaskById($id);
    }

    public function createTask(array $data): TaskAZU
    {
        return $this->taskRepository->createTask($data);
    }

    public function updateTask(int $id, array $data): ?TaskAZU
    {
        return $this->taskRepository->updateTask($id, $data);
    }

    public function deleteTask(int $id): bool
    {
        return $this->taskRepository->deleteTask($id);
    }

    public function getTasksCreatedByUser(int $userId): Collection
    {
        return $this->taskRepository->getTasksCreatedByUser($userId);
    }

    public function getTasksAssignedToUser(int $userId): Collection
    {
        return $this->taskRepository->getTasksAssignedToUser($userId);
    }
}
