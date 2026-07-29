<?php

declare(strict_types=1);

namespace App\Models;

use App\Traits\HasGymAndBranch;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Employee extends Model
{
    use HasGymAndBranch, SoftDeletes;

    protected $fillable = [
        'user_id',
        'gym_id',
        'branch_id',
        'position',
        'department',
        'hire_date',
    ];

    protected function casts(): array
    {
        return [
            'hire_date' => 'date',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
