<?php

declare(strict_types=1);

namespace App\Http\Controllers\Public;

use App\Helpers\PhoneHelper;
use App\Http\Controllers\Controller;
use App\Models\Subscription;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SubscriptionLookupController extends Controller
{
    public function create(): View
    {
        return view('public.subscription-lookup');
    }

    public function store(Request $request): View
    {
        $validated = $request->validate([
            'booking_ref' => ['required', 'string', 'max:20'],
            'phone' => ['required', 'string', 'max:20'],
        ]);

        $ref = strtoupper(trim($validated['booking_ref']));
        $phone = $this->normalizePhone(trim($validated['phone']));

        if (! str_starts_with($ref, 'FOG')) {
            return view('public.subscription-lookup', [
                'error' => 'صيغة رقم الحجز غير صحيحة',
            ]);
        }

        $id = (int) substr($ref, 3);
        if ($id <= 0) {
            return view('public.subscription-lookup', [
                'error' => 'رقم حجز غير صالح',
            ]);
        }

        $subscription = Subscription::with('member.user', 'package')->find($id);

        if (! $subscription || $subscription->member->user->phone !== $phone) {
            return view('public.subscription-lookup', [
                'error' => 'لم يتم العثور على اشتراك بهذه البيانات. تأكد من رقم الحجز ورقم الهاتف.',
            ]);
        }

        $booking = $this->buildBooking($subscription, $ref);

        return view('public.subscription-lookup', [
            'success' => true,
            'booking' => $booking,
        ]);
    }

    private function buildBooking(Subscription $subscription, string $ref): array
    {
        $snapshot = $subscription->package_snapshot ?? [];
        $addons = $subscription->addons ?? [];

        $trainerName = null;
        $trainerPrice = 0.0;
        $locker = false;
        $lockerPrice = 0.0;

        foreach ($addons as $addon) {
            $type = $addon['type'] ?? '';
            if ($type === 'trainer') {
                $trainerName = $addon['name'] ?? null;
                $trainerPrice = (float) ($addon['price'] ?? 0);
            }
            if ($type === 'locker') {
                $locker = true;
                $lockerPrice = (float) ($addon['price'] ?? 0);
            }
        }

        return [
            'booking_ref' => $ref,
            'subscription' => $subscription,
            'member' => $subscription->member,
            'name' => $subscription->member->user->name,
            'phone' => $subscription->member->user->phone,
            'plan_name' => $snapshot['name'] ?? $subscription->package?->name ?? 'غير محدد',
            'base_price' => (float) ($snapshot['base_price'] ?? 0),
            'trainer_name' => $trainerName,
            'trainer_price' => $trainerPrice,
            'locker' => $locker,
            'locker_price' => $lockerPrice,
            'total_price' => (float) $subscription->price_paid,
            'start_date' => $subscription->start_date->format('Y-m-d'),
            'end_date' => $subscription->end_date->format('Y-m-d'),
        ];
    }

    private function normalizePhone(string $phone): string
    {
        return PhoneHelper::normalizeArabicNumerals($phone);
    }
}
