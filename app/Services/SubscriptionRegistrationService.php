<?php

declare(strict_types=1);

namespace App\Services;

use App\Enums\MemberRole;
use App\Enums\MemberStatus;
use App\Enums\SubscriptionStatus;
use App\Models\Member;
use App\Models\Package;
use App\Models\Subscription;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class SubscriptionRegistrationService extends BaseService
{
    public function register(array $data, string $planName, float $price, int $durationDays): array
    {
        $this->assertNoActiveSubscription($data['phone']);

        return DB::transaction(function () use ($data, $planName, $price, $durationDays): array {
            $gymId = $this->getDefaultGymId();

            $user = $this->createUser($data['name'], $data['phone']);

            $member = $this->createMember($user->id, $gymId);

            $package = $this->findOrCreatePackage($planName, $durationDays, $price, $gymId);

            $startDate = now()->startOfDay();
            $endDate = now()->startOfDay()->addDays($durationDays);

            $trainerNames = [1 => 'أحمد محمد', 2 => 'سارة علي', 3 => 'محمد حسن', 4 => 'ليلى خالد'];
            $trainerPrice = 0;
            $trainerName = null;
            $trainerId = ! empty($data['trainer_id']) ? (int) $data['trainer_id'] : 0;
            if ($trainerId && isset($trainerNames[$trainerId])) {
                $trainerPrice = 20;
                $trainerName = $trainerNames[$trainerId];
            }

            $lockerPrice = ! empty($data['locker']) ? 5 : 0;

            $totalPrice = $price + $trainerPrice + $lockerPrice;

            $addons = [];
            if ($trainerName) {
                $addons[] = ['type' => 'trainer', 'name' => $trainerName, 'price' => $trainerPrice];
            }
            if ($lockerPrice > 0) {
                $addons[] = ['type' => 'locker', 'price' => $lockerPrice];
            }

            $subscription = Subscription::create([
                'member_id' => $member->id,
                'package_id' => $package->id,
                'gym_id' => $gymId,
                'start_date' => $startDate,
                'end_date' => $endDate,
                'status' => SubscriptionStatus::Active,
                'price_paid' => $totalPrice,
                'package_snapshot' => [
                    'name' => $planName,
                    'duration_days' => $durationDays,
                    'base_price' => $price,
                ],
                'addons' => ! empty($addons) ? $addons : null,
                'notes' => 'تسجيل عبر الموقع',
                'source' => 'public',
            ]);

            $bookingRef = 'FOG'.str_pad((string) $subscription->id, 5, '0', STR_PAD_LEFT);

            $user->update(['email' => $bookingRef.'@gym.com']);

            return [
                'booking_ref' => $bookingRef,
                'subscription' => $subscription->load('package'),
                'member' => $member->load('user'),
                'name' => $user->name,
                'phone' => $user->phone,
                'plan_name' => $planName,
                'base_price' => (float) $price,
                'trainer_name' => $trainerName,
                'trainer_price' => $trainerPrice,
                'locker' => $lockerPrice > 0,
                'locker_price' => $lockerPrice,
                'total_price' => $totalPrice,
                'start_date' => $startDate->format('Y-m-d'),
                'end_date' => $endDate->format('Y-m-d'),
            ];
        });
    }

    private function createUser(string $name, string $phone): User
    {
        return User::create([
            'name' => $name,
            'email' => 'tmp_'.Str::random(16).'@gym.com',
            'password' => bcrypt('password'),
            'phone' => $phone,
            'role' => MemberRole::Member,
            'is_active' => true,
        ]);
    }

    private function createMember(int $userId, int $gymId): Member
    {
        return Member::create([
            'user_id' => $userId,
            'gym_id' => $gymId,
            'status' => MemberStatus::Active,
            'joined_at' => now(),
        ]);
    }

    private function findOrCreatePackage(string $name, int $durationDays, float $price, int $gymId): Package
    {
        $package = Package::where('gym_id', $gymId)
            ->where('name', $name)
            ->where('duration_days', $durationDays)
            ->first();

        if (! $package) {
            $package = Package::create([
                'gym_id' => $gymId,
                'name' => $name,
                'duration_days' => $durationDays,
                'price' => $price,
                'is_active' => true,
            ]);
        }

        return $package;
    }

    private function assertNoActiveSubscription(string $phone): void
    {
        $user = User::where('phone', $phone)->first();

        if (! $user || ! $user->member) {
            return;
        }

        $hasActive = Subscription::where('member_id', $user->member->id)
            ->whereIn('status', [SubscriptionStatus::Pending, SubscriptionStatus::Active])
            ->where('end_date', '>=', now()->startOfDay())
            ->exists();

        if ($hasActive) {
            abort(422, 'هذا الرقم لديه اشتراك فعال بالفعل. لا يمكن التسجيل مرة أخرى.');
        }
    }
}
