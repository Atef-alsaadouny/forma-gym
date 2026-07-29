<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreSubscriptionRequest;
use App\Http\Requests\Admin\UpdateSubscriptionRequest;
use App\Models\Member;
use App\Models\Package;
use App\Models\Subscription;
use App\Services\SubscriptionService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class SubscriptionController extends Controller
{
    public function __construct(
        private readonly SubscriptionService $subscriptionService,
    ) {}

    public function index(): View
    {
        $this->authorize('viewAny', Subscription::class);

        $subscriptions = $this->subscriptionService->list(
            filters: request()->only(['search', 'status', 'package_id', 'source'])
        );

        $packages = Package::active()->orderBy('name')->get();

        return view('admin.subscriptions.index', compact('subscriptions', 'packages'));
    }

    public function publicRegistrations(): View
    {
        $this->authorize('viewAny', Subscription::class);

        $subscriptions = $this->subscriptionService->list(
            filters: ['source' => 'public', ...request()->only(['search', 'status', 'package_id'])]
        );

        $packages = Package::active()->orderBy('name')->get();

        return view('admin.subscriptions.index', compact('subscriptions', 'packages'));
    }

    public function create(): View
    {
        $this->authorize('create', Subscription::class);

        $members = Member::with('user')->get()->sortBy('user.name');
        $packages = Package::active()->orderBy('name')->get();

        return view('admin.subscriptions.create', compact('members', 'packages'));
    }

    public function store(StoreSubscriptionRequest $request): RedirectResponse
    {
        $subscription = $this->subscriptionService->create($request->validated());

        return to_route('admin.subscriptions.show', $subscription)
            ->with('success', __('Subscription created successfully.'));
    }

    public function show(Subscription $subscription): View
    {
        $this->authorize('view', $subscription);

        $subscription->load(['member.user', 'package']);

        return view('admin.subscriptions.show', compact('subscription'));
    }

    public function edit(Subscription $subscription): View
    {
        $this->authorize('update', $subscription);

        $members = Member::with('user')->get()->sortBy('user.name');
        $packages = Package::active()->orderBy('name')->get();
        $subscription->load(['member.user', 'package']);

        return view('admin.subscriptions.edit', compact('subscription', 'members', 'packages'));
    }

    public function update(UpdateSubscriptionRequest $request, Subscription $subscription): RedirectResponse
    {
        $this->subscriptionService->update($subscription, $request->validated());

        return to_route('admin.subscriptions.show', $subscription)
            ->with('success', __('Subscription updated successfully.'));
    }

    public function destroy(Subscription $subscription): RedirectResponse
    {
        $this->authorize('delete', $subscription);

        $this->subscriptionService->delete($subscription);

        return to_route('admin.subscriptions.index')
            ->with('success', __('Subscription deleted successfully.'));
    }
}
