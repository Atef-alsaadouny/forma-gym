<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\Gym;

class GymService extends BaseService
{
    public function getActiveGym(): ?Gym
    {
        return Gym::where('is_active', true)->first();
    }

    public function getSettings(int $gymId): array
    {
        $settings = Gym::findOrFail($gymId)
            ->settings()
            ->pluck('value', 'key')
            ->toArray();

        return $settings;
    }
}
