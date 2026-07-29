<?php

declare(strict_types=1);

namespace App\Traits;

use App\Models\Branch;
use App\Models\Gym;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

trait HasGymAndBranch
{
    public function gym(): BelongsTo
    {
        return $this->belongsTo(Gym::class);
    }

    public function branch(): BelongsTo
    {
        return $this->belongsTo(Branch::class);
    }

    public function scopeByGym($query, int $gymId): void
    {
        $query->where('gym_id', $gymId);
    }

    public function scopeByBranch($query, int $branchId): void
    {
        $query->where('branch_id', $branchId);
    }
}
