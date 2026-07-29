<?php

declare(strict_types=1);

namespace App\Enums;

enum MemberRole: string
{
    case Owner = 'owner';
    case Admin = 'admin';
    case Manager = 'manager';
    case Receptionist = 'receptionist';
    case Trainer = 'trainer';
    case Member = 'member';

    public function label(): string
    {
        return match ($this) {
            self::Owner => 'Owner',
            self::Admin => 'Admin',
            self::Manager => 'Manager',
            self::Receptionist => 'Receptionist',
            self::Trainer => 'Trainer',
            self::Member => 'Member',
        };
    }

    public function isDashboardRole(): bool
    {
        return in_array($this, [
            self::Owner,
            self::Admin,
            self::Manager,
            self::Receptionist,
            self::Trainer,
        ], true);
    }
}
