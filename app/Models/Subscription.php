<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\SubscriptionStatus;
use App\Traits\HasGymAndBranch;
use Database\Factories\SubscriptionFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Subscription extends Model
{
    /** @use HasFactory<SubscriptionFactory> */
    use HasFactory, HasGymAndBranch, SoftDeletes;

    protected $fillable = [
        'member_id',
        'package_id',
        'gym_id',
        'branch_id',
        'start_date',
        'end_date',
        'status',
        'price_paid',
        'package_snapshot',
        'addons',
        'notes',
        'source',
    ];

    protected function casts(): array
    {
        return [
            'start_date' => 'date',
            'end_date' => 'date',
            'price_paid' => 'decimal:2',
            'package_snapshot' => 'array',
            'addons' => 'array',
            'status' => SubscriptionStatus::class,
            'source' => 'string',
        ];
    }

    public function member(): BelongsTo
    {
        return $this->belongsTo(Member::class);
    }

    public function package(): BelongsTo
    {
        return $this->belongsTo(Package::class);
    }

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('status', SubscriptionStatus::Active);
    }

    public function scopeByStatus(Builder $query, SubscriptionStatus $status): Builder
    {
        return $query->where('status', $status);
    }

    public function scopeExpiringSoon(Builder $query, int $days = 7): Builder
    {
        return $query->active()
            ->whereDate('end_date', '>=', now())
            ->whereDate('end_date', '<=', now()->addDays($days));
    }

    public function scopeExpired(Builder $query): Builder
    {
        return $query->whereDate('end_date', '<', now())
            ->where('status', SubscriptionStatus::Active);
    }
}
