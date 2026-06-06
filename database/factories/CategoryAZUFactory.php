<?php

namespace Database\Factories;

use App\Models\CategoryAZU;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Eloquent\Factories\Factory<CategoryAZU>
 */
class CategoryAZUFactory extends Factory
{
    protected $model = CategoryAZU::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $name = fake()->unique()->words(2, true);

        return [
            'name' => $name,
            'slug' => Str::slug($name),
        ];
    }
}
