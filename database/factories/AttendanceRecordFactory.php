<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\AttendanceRecord;
use App\Models\Branch;
use App\Models\Gym;
use App\Models\Member;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<AttendanceRecord>
 */
class AttendanceRecordFactory extends Factory
{
    protected $model = AttendanceRecord::class;

    public function definition(): array
    {
        $date = fake()->dateTimeBetween('-1 month');
        $checkedIn = clone $date;
        $checkedIn->modify('+'.fake()->numberBetween(6, 10).' hours');

        return [
            'member_id' => Member::factory(),
            'gym_id' => Gym::factory(),
            'branch_id' => Branch::factory(),
            'date' => $date,
            'checked_in_at' => $checkedIn,
            'checked_out_at' => fake()->optional(0.7)->dateTimeBetween($checkedIn->format('Y-m-d H:i:s'), '+3 hours'),
            'notes' => fake()->optional()->sentence(),
        ];
    }

    public function checkedIn(): static
    {
        return $this->state(fn (array $attributes) => [
            'date' => today(),
            'checked_in_at' => now(),
            'checked_out_at' => null,
        ]);
    }

    public function checkedOut(): static
    {
        return $this->state(fn (array $attributes) => [
            'date' => today(),
            'checked_in_at' => now()->subHours(2),
            'checked_out_at' => now(),
        ]);
    }
}
