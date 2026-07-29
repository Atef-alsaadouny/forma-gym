<?php

declare(strict_types=1);

namespace App\Policies;

use App\Enums\MemberRole;
use App\Models\Member;
use App\Models\User;

class MemberPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->isAdmin()
            || $user->isTrainer()
            || $user->hasRole(MemberRole::Manager)
            || $user->hasRole(MemberRole::Receptionist);
    }

    public function view(User $user, Member $member): bool
    {
        if ($user->isAdmin()) {
            return true;
        }

        if ($user->hasRole(MemberRole::Manager) || $user->hasRole(MemberRole::Receptionist)) {
            return true;
        }

        return $user->id === $member->user_id;
    }

    public function create(User $user): bool
    {
        return $user->isAdmin()
            || $user->hasRole(MemberRole::Manager)
            || $user->hasRole(MemberRole::Receptionist);
    }

    public function update(User $user, Member $member): bool
    {
        if ($user->isAdmin()) {
            return true;
        }

        return $user->id === $member->user_id;
    }

    public function delete(User $user, Member $member): bool
    {
        return $user->isAdmin()
            || $user->hasRole(MemberRole::Manager);
    }

    public function restore(User $user, Member $member): bool
    {
        return $user->isAdmin();
    }

    public function forceDelete(User $user, Member $member): bool
    {
        return $user->isAdmin();
    }
}
