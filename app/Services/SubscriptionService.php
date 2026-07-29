<?php

declare(strict_types=1);

namespace App\Services;

use App\Enums\SubscriptionStatus;
use App\Models\Subscription;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;

class SubscriptionService extends BaseService
{
    public function list(array $filters = []): LengthAwarePaginator
    {
        $query = Subscription::with(['member.user', 'package'])
            ->orderBy('created_at', 'desc');

        $query = $this->applyFilters($query, $filters);

        return $query->paginate(15);
    }

    public function create(array $data): Subscription
    {
        $subscription = Subscription::create([
            'member_id' => $data['member_id'],
            'package_id' => $data['package_id'],
            'gym_id' => $data['gym_id'] ?? $this->getDefaultGymId(),
            'start_date' => $data['start_date'],
            'end_date' => $data['end_date'],
            'status' => $data['status'] ?? SubscriptionStatus::Pending,
            'price_paid' => $data['price_paid'] ?? null,
            'notes' => $data['notes'] ?? null,
        ]);

        $this->logInfo('Subscription created', [
            'subscription_id' => $subscription->id,
            'member_id' => $subscription->member_id,
        ]);

        return $subscription->load(['member.user', 'package']);
    }

    public function update(Subscription $subscription, array $data): Subscription
    {
        $subscription->update([
            'package_id' => $data['package_id'] ?? $subscription->package_id,
            'start_date' => $data['start_date'] ?? $subscription->start_date,
            'end_date' => $data['end_date'] ?? $subscription->end_date,
            'status' => $data['status'] ?? $subscription->status,
            'price_paid' => array_key_exists('price_paid', $data) ? $data['price_paid'] : $subscription->price_paid,
            'notes' => array_key_exists('notes', $data) ? $data['notes'] : $subscription->notes,
        ]);

        $this->logInfo('Subscription updated', [
            'subscription_id' => $subscription->id,
        ]);

        return $subscription->load(['member.user', 'package']);
    }

    public function delete(Subscription $subscription): void
    {
        $subscription->delete();

        $this->logInfo('Subscription deleted', [
            'subscription_id' => $subscription->id,
        ]);
    }

    public function activate(Subscription $subscription): Subscription
    {
        $subscription->update(['status' => SubscriptionStatus::Active]);

        $this->logInfo('Subscription activated', [
            'subscription_id' => $subscription->id,
        ]);

        return $subscription->fresh()->load(['member.user', 'package']);
    }

    public function cancel(Subscription $subscription): Subscription
    {
        $subscription->update(['status' => SubscriptionStatus::Cancelled]);

        $this->logInfo('Subscription cancelled', [
            'subscription_id' => $subscription->id,
        ]);

        return $subscription->fresh()->load(['member.user', 'package']);
    }

    private function applyFilters(Builder $query, array $filters): Builder
    {
        if (! empty($filters['search'])) {
            $query->whereHas('member.user', function (Builder $q) use ($filters): void {
                $q->whereAny(['name', 'email'], 'like', "%{$filters['search']}%");
            });
        }

        if (! empty($filters['status'])) {
            $status = SubscriptionStatus::tryFrom($filters['status']);
            if ($status) {
                $query->byStatus($status);
            }
        }

        if (! empty($filters['package_id'])) {
            $query->where('package_id', $filters['package_id']);
        }

        if (! empty($filters['source'])) {
            $query->where('source', $filters['source']);
        }

        return $query;
    }
}
