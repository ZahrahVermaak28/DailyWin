<?php

namespace App\Models;

use App\Enums\TaskPriorityEnum;
use App\Enums\TaskStatusEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Builder;

class TaskAZU extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'tasks';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'title',
        'description',
        'status',
        'priority',
        'due_date',
        'created_by',
        'assigned_to',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'due_date' => 'date',
        'status' => TaskStatusEnum::class,
        'priority' => TaskPriorityEnum::class,
    ];

    /**
     * Get the user who created the task.
     */
    public function creator(): BelongsTo
    {
        return $this->belongsTo(UserAZU::class, 'created_by');
    }

    /**
     * Get the user to whom the task is assigned.
     */
    public function assignee(): BelongsTo
    {
        return $this->belongsTo(UserAZU::class, 'assigned_to');
    }

    /**
     * The categories that belong to the task.
     */
    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(CategoryAZU::class, 'category_task', 'task_id', 'category_id')->withTimestamps();
    }

    /**
     * Scope a query to only include tasks with a given status.
     */
    public function scopeStatus(Builder $query, string $status): void
    {
        $query->where('status', $status);
    }

    /**
     * Scope a query to only include tasks with a given priority.
     */
    public function scopePriority(Builder $query, string $priority): void
    {
        $query->where('priority', $priority);
    }

    /**
     * Scope a query to only include tasks assigned to a specific user.
     */
    public function scopeAssignedTo(Builder $query, int $userId): void
    {
        $query->where('assigned_to', $userId);
    }

    /**
     * Scope a query to only include tasks created by a specific user.
     */
    public function scopeCreatedBy(Builder $query, int $userId): void
    {
        $query->where('created_by', $userId);
    }

    /**
     * Accessor for formatted due date.
     */
    public function getFormattedDueDateAttribute(): ?string
    {
        return $this->due_date ? $this->due_date->format('M d, Y') : null;
    }

    public function getStatusBadgeAttribute(): string
    {
        $status = $this->status instanceof TaskStatusEnum ? $this->status->value : $this->status;

        return match ($status) {
            'completed' => 'bg-green-100 text-green-800',
            'in_progress' => 'bg-blue-100 text-blue-800',
            default => 'bg-yellow-100 text-yellow-800',
        };
    }

    public function getPriorityBadgeAttribute(): string
    {
        $priority = $this->priority instanceof TaskPriorityEnum ? $this->priority->value : $this->priority;

        return match ($priority) {
            'high' => 'bg-red-100 text-red-800',
            'low' => 'bg-gray-100 text-gray-800',
            default => 'bg-purple-100 text-purple-800',
        };
    }

    /**
     * Mutator for title to ensure it's capitalized.
     */
    public function setTitleAttribute(string $value): void
    {
        $this->attributes['title'] = ucfirst($value);
    }
}
