<?php

declare(strict_types=1);

namespace App\Policies;

use App\Enums\MemberRole;
use App\Models\AttendanceRecord;
use App\Models\User;

class AttendanceRecordPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->isAdmin()
            || $user->isTrainer()
            || $user->hasRole(MemberRole::Manager)
            || $user->hasRole(MemberRole::Receptionist);
    }

    public function view(User $user, AttendanceRecord $record): bool
    {
        return $user->isAdmin()
            || $user->hasRole(MemberRole::Manager)
            || $user->hasRole(MemberRole::Receptionist);
    }

    public function create(User $user): bool
    {
        return $user->isAdmin()
            || $user->hasRole(MemberRole::Manager)
            || $user->hasRole(MemberRole::Receptionist);
    }

    public function update(User $user, AttendanceRecord $record): bool
    {
        return $user->isAdmin()
            || $user->hasRole(MemberRole::Manager);
    }

    public function delete(User $user, AttendanceRecord $record): bool
    {
        return $user->isAdmin();
    }
}
