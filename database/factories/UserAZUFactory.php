<?php

namespace Database\Factories;

use App\Models\UserAZU;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Enums\UserRoleEnum;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<UserAZU>
 */
class UserAZUFactory extends Factory
{
    protected $model = UserAZU::class;

    /**
     * The current password being used by the factory.
     */
    protected static ?string $password;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password' => static::$password ??= Hash::make('password'),
            'remember_token' => Str::random(10),
            'role' => fake()->randomElement([UserRoleEnum::Admin, UserRoleEnum::TeamMember, UserRoleEnum::Guest]),
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }

    /**
     * Indicate that the user is an admin.
     */
    public function admin(): static
    {
        return $this->state(fn (array $attributes) => [
            'role' => UserRoleEnum::Admin,
        ]);
    }

    /**
     * Indicate that the user is a team member.
     */
    public function teamMember(): static
    {
        return $this->state(fn (array $attributes) => [
            'role' => UserRoleEnum::TeamMember,
        ]);
    }

    /**
     * Indicate that the user is a guest.
     */
    public function guest(): static
    {
        return $this->state(fn (array $attributes) => [
            'role' => UserRoleEnum::Guest,
        ]);
    }
}
