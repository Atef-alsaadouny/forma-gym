<?php

declare(strict_types=1);

namespace App\Policies;

use App\Enums\MemberRole;
use App\Models\Subscription;
use App\Models\User;

class SubscriptionPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->isAdmin()
            || $user->isTrainer()
            || $user->hasRole(MemberRole::Manager)
            || $user->hasRole(MemberRole::Receptionist);
    }

    public function view(User $user, Subscription $subscription): bool
    {
        if ($user->isAdmin()) {
            return true;
        }

        if ($user->hasRole(MemberRole::Manager) || $user->hasRole(MemberRole::Receptionist)) {
            return true;
        }

        return $user->member?->id === $subscription->member_id;
    }

    public function create(User $user): bool
    {
        return $user->isAdmin()
            || $user->hasRole(MemberRole::Manager)
            || $user->hasRole(MemberRole::Receptionist);
    }

    public function update(User $user, Subscription $subscription): bool
    {
        return $user->isAdmin()
            || $user->hasRole(MemberRole::Manager);
    }

    public function delete(User $user, Subscription $subscription): bool
    {
        return $user->isAdmin();
    }
}
