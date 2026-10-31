<?php

namespace Database\Factories;

use App\Models\Service;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Service>
 */
class ServiceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'category' => 'workshop',
            'name' => fake()->sentence(2),
            'slug' => fake()->unique()->slug(),
            'description' => fake()->paragraph(),
            'features' => ['Fasilitator berpengalaman'],
            'sort_order' => 1,
            'is_active' => true,
        ];
    }
}
