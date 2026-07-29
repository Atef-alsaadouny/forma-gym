<?php

declare(strict_types=1);

namespace App\Models;

use Database\Factories\GymFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Gym extends Model
{
    /** @use HasFactory<GymFactory> */
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'slug',
        'email',
        'phone',
        'address',
        'logo_path',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
        ];
    }

    public function branches(): HasMany
    {
        return $this->hasMany(Branch::class);
    }

    public function settings(): HasMany
    {
        return $this->hasMany(GymSetting::class);
    }

    public function members(): HasMany
    {
        return $this->hasMany(Member::class);
    }

    public function trainers(): HasMany
    {
        return $this->hasMany(Trainer::class);
    }
}
