<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Enums\TrainerStatus;
use App\Models\Branch;
use App\Models\Gym;
use App\Models\Trainer;
use App\Models\User;
use App\Enums\MemberRole;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Trainer>
 */
class TrainerFactory extends Factory
{
    protected $model = Trainer::class;

    public function definition(): array
    {
        return [
            'user_id' => User::factory()->state(['role' => MemberRole::Trainer]),
            'gym_id' => Gym::factory(),
            'branch_id' => Branch::factory(),
            'specialization' => fake()->randomElement([
                'Personal Training', 'Yoga', 'CrossFit', 'Bodybuilding',
                'Cardio', 'Pilates', 'Martial Arts', 'Rehabilitation',
            ]),
            'experience_years' => fake()->numberBetween(1, 20),
            'rating' => fake()->randomFloat(2, 3.0, 5.0),
            'bio' => fake()->paragraph(),
            'certifications' => fake()->words(3),
            'profile_photo_path' => null,
            'is_available' => true,
            'status' => TrainerStatus::Active,
            'joined_at' => fake()->dateTimeBetween('-2 years'),
            'notes' => fake()->optional()->sentence(),
            'gender' => fake()->randomElement(['male', 'female']),
            'date_of_birth' => fake()->date(max: '-22 years'),
        ];
    }

    public function active(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => TrainerStatus::Active,
        ]);
    }

    public function inactive(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => TrainerStatus::Inactive,
        ]);
    }

    public function suspended(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => TrainerStatus::Suspended,
        ]);
    }

    public function unavailable(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_available' => false,
        ]);
    }
}
