<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\MemberStatus;
use App\Traits\HasGymAndBranch;
use Database\Factories\MemberFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Member extends Model
{
    /** @use HasFactory<MemberFactory> */
    use HasFactory, HasGymAndBranch, SoftDeletes;

    protected $fillable = [
        'user_id',
        'gym_id',
        'branch_id',
        'emergency_contact',
        'emergency_phone',
        'date_of_birth',
        'gender',
        'status',
        'joined_at',
        'notes',
    ];

    protected function casts(): array
    {
        return [
            'date_of_birth' => 'date',
            'joined_at' => 'datetime',
            'status' => MemberStatus::class,
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function scopeSearch(Builder $query, string $term): Builder
    {
        return $query->whereHas('user', function (Builder $q) use ($term): void {
            $q->whereAny(['name', 'email'], 'like', "%{$term}%");
        });
    }

    public function scopeByStatus(Builder $query, MemberStatus $status): Builder
    {
        return $query->where('status', $status);
    }

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('status', MemberStatus::Active);
    }

    public function scopeJoinedBetween(Builder $query, string $from, string $to): Builder
    {
        return $query->whereBetween('joined_at', [$from, $to]);
    }
}
