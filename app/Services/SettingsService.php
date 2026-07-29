<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\GymSetting;

class SettingsService extends BaseService
{
    public function get(string $key, mixed $default = null): mixed
    {
        $setting = GymSetting::where('key', $key)->first();

        return $setting?->value ?? $default;
    }

    public function set(int $gymId, string $key, mixed $value): void
    {
        GymSetting::updateOrCreate(
            ['gym_id' => $gymId, 'key' => $key],
            ['value' => (string) $value],
        );
    }
}
