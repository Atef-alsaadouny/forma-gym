<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\Gym;
use Illuminate\Support\Facades\Log;

abstract class BaseService
{
    protected function logError(string $message, array $context = []): void
    {
        Log::error(class_basename(static::class).': '.$message, $context);
    }

    protected function logInfo(string $message, array $context = []): void
    {
        Log::info(class_basename(static::class).': '.$message, $context);
    }

    protected function getDefaultGymId(): int
    {
        return Gym::firstOrCreate(
            ['slug' => 'default'],
            ['name' => 'Default Gym', 'is_active' => true],
        )->id;
    }
}
