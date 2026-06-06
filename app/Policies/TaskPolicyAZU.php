<?php

namespace App\Policies;

use App\Models\TaskAZU;
use App\Models\UserAZU;

class TaskPolicyAZU
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(UserAZU $user): bool
    {
        return !$user->isGuest();
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(UserAZU $user, TaskAZU $task): bool
    {
        return $user->isAdmin() || $user->id === $task->created_by || $user->id === $task->assigned_to;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(UserAZU $user): bool
    {
        return $user->isAdmin() || $user->isTeamMember();
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(UserAZU $user, TaskAZU $task): bool
    {
        return $user->isAdmin() || $user->id === $task->created_by || $user->id === $task->assigned_to;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(UserAZU $user, TaskAZU $task): bool
    {
        return $user->isAdmin() || $user->id === $task->created_by;
    }

    public function assign(UserAZU $user): bool
    {
        return $user->isAdmin();
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(UserAZU $user, TaskAZU $task): bool
    {
        return $user->isAdmin();
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(UserAZU $user, TaskAZU $task): bool
    {
        return $user->isAdmin();
    }
}
