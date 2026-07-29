<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\TrainerStatus;
use App\Traits\HasGymAndBranch;
use Database\Factories\TrainerFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Trainer extends Model
{
    /** @use HasFactory<TrainerFactory> */
    use HasFactory, HasGymAndBranch, SoftDeletes;

    protected $fillable = [
        'user_id',
        'gym_id',
        'branch_id',
        'specialization',
        'experience_years',
        'rating',
        'bio',
        'certifications',
        'profile_photo_path',
        'is_available',
        'status',
        'joined_at',
        'notes',
        'gender',
        'date_of_birth',
    ];

    protected function casts(): array
    {
        return [
            'is_available' => 'boolean',
            'certifications' => 'array',
            'experience_years' => 'integer',
            'rating' => 'decimal:2',
            'status' => TrainerStatus::class,
            'joined_at' => 'datetime',
            'date_of_birth' => 'date',
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

    public function scopeByStatus(Builder $query, TrainerStatus $status): Builder
    {
        return $query->where('status', $status);
    }

    public function scopeBySpecialization(Builder $query, string $specialization): Builder
    {
        return $query->where('specialization', $specialization);
    }

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('status', TrainerStatus::Active);
    }

    public function scopeAvailable(Builder $query): Builder
    {
        return $query->where('is_available', true);
    }
}
