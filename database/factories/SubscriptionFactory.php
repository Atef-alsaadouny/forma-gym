<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Enums\SubscriptionStatus;
use App\Models\Branch;
use App\Models\Gym;
use App\Models\Member;
use App\Models\Package;
use App\Models\Subscription;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Subscription>
 */
class SubscriptionFactory extends Factory
{
    protected $model = Subscription::class;

    public function definition(): array
    {
        $startDate = fake()->dateTimeBetween('-1 year');

        return [
            'member_id' => Member::factory(),
            'package_id' => Package::factory(),
            'gym_id' => Gym::factory(),
            'branch_id' => Branch::factory(),
            'start_date' => $startDate,
            'end_date' => fake()->dateTimeBetween($startDate->format('Y-m-d'), '+1 year'),
            'status' => fake()->randomElement(SubscriptionStatus::cases()),
            'price_paid' => fake()->randomFloat(2, 10, 500),
            'notes' => fake()->optional()->sentence(),
        ];
    }

    public function active(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => SubscriptionStatus::Active,
            'start_date' => now()->subDays(30),
            'end_date' => now()->addDays(30),
        ]);
    }

    public function expired(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => SubscriptionStatus::Expired,
            'start_date' => now()->subDays(60),
            'end_date' => now()->subDays(30),
        ]);
    }

    public function pending(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => SubscriptionStatus::Pending,
            'start_date' => now(),
            'end_date' => now()->addDays(30),
        ]);
    }
}
