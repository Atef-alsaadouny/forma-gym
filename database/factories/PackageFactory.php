<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Branch;
use App\Models\Gym;
use App\Models\Package;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Package>
 */
class PackageFactory extends Factory
{
    protected $model = Package::class;

    public function definition(): array
    {
        return [
            'gym_id' => Gym::factory(),
            'branch_id' => Branch::factory(),
            'name' => fake()->unique()->randomElement([
                'Basic Membership',
                'Standard Membership',
                'Premium Membership',
                'Gold Membership',
                'Platinum Membership',
            ]),
            'description' => fake()->sentence(),
            'duration_days' => fake()->randomElement([30, 90, 180, 365]),
            'price' => fake()->randomFloat(2, 10, 500),
            'number_of_sessions' => fake()->optional()->randomElement([12, 24, 48]),
            'features' => fake()->randomElements([
                'Gym Access',
                'Locker Room',
                'Personal Trainer',
                'Group Classes',
                'Sauna',
                'Pool Access',
                'Nutrition Plan',
            ], fake()->numberBetween(2, 5)),
            'is_active' => true,
            'sort_order' => fake()->numberBetween(0, 10),
        ];
    }

    public function inactive(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_active' => false,
        ]);
    }
}
