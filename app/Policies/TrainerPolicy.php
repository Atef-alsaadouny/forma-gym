<?php

declare(strict_types=1);

namespace App\Policies;

use App\Enums\MemberRole;
use App\Models\Trainer;
use App\Models\User;

class TrainerPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->isAdmin()
            || $user->hasRole(MemberRole::Manager)
            || $user->hasRole(MemberRole::Receptionist)
            || $user->isTrainer();
    }

    public function view(User $user, Trainer $trainer): bool
    {
        if ($user->isAdmin()) {
            return true;
        }

        if ($user->hasRole(MemberRole::Manager) || $user->hasRole(MemberRole::Receptionist)) {
            return true;
        }

        return $user->id === $trainer->user_id;
    }

    public function create(User $user): bool
    {
        return $user->isAdmin()
            || $user->hasRole(MemberRole::Manager);
    }

    public function update(User $user, Trainer $trainer): bool
    {
        if ($user->isAdmin()) {
            return true;
        }

        return $user->id === $trainer->user_id;
    }

    public function delete(User $user, Trainer $trainer): bool
    {
        return $user->isAdmin()
            || $user->hasRole(MemberRole::Manager);
    }

    public function restore(User $user, Trainer $trainer): bool
    {
        return $user->isAdmin();
    }

    public function forceDelete(User $user, Trainer $trainer): bool
    {
        return $user->isAdmin();
    }
}
