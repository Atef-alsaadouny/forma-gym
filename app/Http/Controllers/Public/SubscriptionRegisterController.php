<?php

declare(strict_types=1);

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Http\Requests\Public\StoreSubscriptionRegistrationRequest;
use App\Services\SubscriptionRegistrationService;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SubscriptionRegisterController extends Controller
{
    private const TRAINERS = [
        ['id' => 1, 'name' => 'أحمد محمد', 'label_key' => 'messages.trainer_ahmed'],
        ['id' => 2, 'name' => 'سارة علي', 'label_key' => 'messages.trainer_sara'],
        ['id' => 3, 'name' => 'محمد حسن', 'label_key' => 'messages.trainer_mohamed'],
        ['id' => 4, 'name' => 'ليلى خالد', 'label_key' => 'messages.trainer_laila'],
    ];

    private const SUBSCRIPTIONS = [
        ['name' => 'شهر', 'label_key' => 'messages.plan_month', 'price' => 29, 'duration' => 30, 'period' => 'شهرياً', 'popular' => false],
        ['name' => 'شهرين', 'label_key' => 'messages.plan_2months', 'price' => 49, 'duration' => 60, 'period' => 'شهرياً', 'popular' => false],
        ['name' => '3 أشهر', 'label_key' => 'messages.plan_3months', 'price' => 69, 'duration' => 90, 'period' => 'شهرياً', 'popular' => true],
        ['name' => '6 أشهر', 'label_key' => 'messages.plan_6months', 'price' => 99, 'duration' => 180, 'period' => 'شهرياً', 'popular' => false],
        ['name' => 'سنة', 'label_key' => 'messages.plan_year', 'price' => 149, 'duration' => 365, 'period' => 'شهرياً', 'popular' => false],
    ];

    public function __construct(
        private readonly SubscriptionRegistrationService $registrationService,
    ) {}

    public function create(Request $request): View
    {
        $plan = $request->query('plan');
        $price = $request->query('price') ? (float) $request->query('price') : null;
        $duration = $request->query('duration') ? (int) $request->query('duration') : null;

        if (! $plan || ! $price || ! $duration) {
            $plan = null;
            $price = null;
            $duration = null;
        }

        return view('public.register', [
            'plan' => $plan,
            'price' => $price,
            'duration' => $duration,
            'subscriptions' => self::SUBSCRIPTIONS,
            'trainers' => self::TRAINERS,
        ]);
    }

    public function store(StoreSubscriptionRegistrationRequest $request): View
    {
        $data = $request->validated();

        $result = $this->registrationService->register(
            $data,
            $data['plan'],
            (float) $data['price'],
            (int) $data['duration'],
        );

        return view('public.register', [
            'plan' => $data['plan'],
            'price' => (float) $data['price'],
            'duration' => (int) $data['duration'],
            'success' => true,
            'booking' => $result,
            'subscriptions' => self::SUBSCRIPTIONS,
            'trainers' => self::TRAINERS,
        ]);
    }
}
