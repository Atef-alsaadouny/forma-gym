<?php

declare(strict_types=1);

namespace App\Services;

use App\Enums\MemberRole;
use App\Enums\MemberStatus;
use App\Models\Member;
use App\Models\User;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;

class MemberService extends BaseService
{
    public function list(array $filters = []): LengthAwarePaginator
    {
        $query = Member::with('user')
            ->orderBy('created_at', 'desc');

        $query = $this->applyFilters($query, $filters);

        return $query->paginate(15);
    }

    public function create(array $data): Member
    {
        $user = User::create([
            'name' => $data['first_name'].' '.$data['last_name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password'] ?? 'password'),
            'phone' => $data['phone'] ?? null,
            'role' => MemberRole::Member,
            'is_active' => true,
        ]);

        $member = Member::create([
            'user_id' => $user->id,
            'gym_id' => $data['gym_id'] ?? $this->getDefaultGymId(),
            'branch_id' => $data['branch_id'] ?? null,
            'emergency_contact' => $data['emergency_contact'] ?? null,
            'emergency_phone' => $data['emergency_phone'] ?? null,
            'date_of_birth' => $data['date_of_birth'] ?? null,
            'gender' => $data['gender'] ?? null,
            'status' => MemberStatus::Active,
            'joined_at' => $data['joined_at'] ?? now(),
            'notes' => $data['notes'] ?? null,
        ]);

        $this->logInfo('Member created', ['member_id' => $member->id, 'user_id' => $user->id]);

        return $member->load('user');
    }

    public function update(Member $member, array $data): Member
    {
        $member->update([
            'branch_id' => $data['branch_id'] ?? $member->branch_id,
            'emergency_contact' => $data['emergency_contact'] ?? $member->emergency_contact,
            'emergency_phone' => $data['emergency_phone'] ?? $member->emergency_phone,
            'date_of_birth' => $data['date_of_birth'] ?? $member->date_of_birth,
            'gender' => $data['gender'] ?? $member->gender,
            'status' => $data['status'] ?? $member->status,
            'joined_at' => $data['joined_at'] ?? $member->joined_at,
            'notes' => $data['notes'] ?? $member->notes,
        ]);

        if (isset($data['first_name']) || isset($data['last_name']) || isset($data['email']) || isset($data['phone'])) {
            $userData = [];
            if (isset($data['first_name'], $data['last_name'])) {
                $userData['name'] = $data['first_name'].' '.$data['last_name'];
            }
            if (isset($data['email'])) {
                $userData['email'] = $data['email'];
            }
            if (isset($data['phone'])) {
                $userData['phone'] = $data['phone'];
            }

            if ($userData) {
                $member->user->update($userData);
            }
        }

        $this->logInfo('Member updated', ['member_id' => $member->id]);

        return $member->load('user');
    }

    public function delete(Member $member): void
    {
        $member->delete();

        $this->logInfo('Member deleted', ['member_id' => $member->id]);
    }

    public function restore(int $memberId): Member
    {
        $member = Member::withTrashed()->findOrFail($memberId);
        $member->restore();

        $this->logInfo('Member restored', ['member_id' => $member->id]);

        return $member->load('user');
    }

    public function forceDelete(int $memberId): void
    {
        $member = Member::withTrashed()->findOrFail($memberId);
        $member->forceDelete();

        $this->logInfo('Member permanently deleted', ['member_id' => $memberId]);
    }

    public function updateStatus(Member $member, MemberStatus $status): Member
    {
        $member->update(['status' => $status]);

        $this->logInfo('Member status updated', [
            'member_id' => $member->id,
            'status' => $status->value,
        ]);

        return $member->load('user');
    }

    private function applyFilters(Builder $query, array $filters): Builder
    {
        if (! empty($filters['search'])) {
            $query->search($filters['search']);
        }

        if (! empty($filters['status'])) {
            $status = MemberStatus::tryFrom($filters['status']);
            if ($status) {
                $query->byStatus($status);
            }
        }

        if (! empty($filters['date_from']) && ! empty($filters['date_to'])) {
            $query->joinedBetween($filters['date_from'], $filters['date_to']);
        }

        if (! empty($filters['gender'])) {
            $query->where('gender', $filters['gender']);
        }

        return $query;
    }
}
