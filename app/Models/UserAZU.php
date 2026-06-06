<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

use Illuminate\Database\Eloquent\Relations\HasMany;

class UserAZU extends Authenticatable implements MustVerifyEmail
{
    use HasFactory, Notifiable;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'role' => \App\Enums\UserRoleEnum::class, // Assuming an Enum for roles
    ];

    /**
     * Get the tasks created by the user.
     */
    public function createdTasks(): HasMany
    {
        return $this->hasMany(TaskAZU::class, 'created_by');
    }

    /**
     * Get the tasks assigned to the user.
     */
    public function assignedTasks(): HasMany
    {
        return $this->hasMany(TaskAZU::class, 'assigned_to');
    }

    /**
     * Check if the user has a specific role.
     */
    public function hasRole(string $role): bool
    {
        $currentRole = $this->role instanceof \App\Enums\UserRoleEnum ? $this->role->value : $this->role;

        return $currentRole === $role;
    }

    /**
     * Check if the user is an admin.
     */
    public function isAdmin(): bool
    {
        return $this->hasRole('admin');
    }

    /**
     * Check if the user is a team member.
     */
    public function isTeamMember(): bool
    {
        return $this->hasRole('team_member');
    }

    /**
     * Check if the user is a guest.
     */
    public function isGuest(): bool
    {
        return $this->hasRole('guest');
    }
}
