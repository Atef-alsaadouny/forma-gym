<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Enums\MemberRole;
use App\Models\Branch;
use App\Models\Gym;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $gym = Gym::create([
            'name' => 'Forma Gym',
            'slug' => 'power-gym',
            'email' => 'info@powergym.com',
            'phone' => '+96512345678',
            'address' => 'Kuwait City, Kuwait',
            'is_active' => true,
        ]);

        Branch::create([
            'gym_id' => $gym->id,
            'name' => 'Main Branch',
            'slug' => 'main-branch',
            'email' => 'main@powergym.com',
            'phone' => '+96512345678',
            'address' => 'Kuwait City, Kuwait',
            'is_active' => true,
        ]);

        User::create([
            'name' => 'Admin',
            'email' => 'admin@powergym.com',
            'password' => Hash::make('password'),
            'phone' => '+96512345678',
            'role' => MemberRole::Admin,
            'is_active' => true,
        ]);
    }
}
