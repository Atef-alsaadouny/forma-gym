<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\AttendanceRecord;
use App\Models\Gym;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;

class AttendanceService extends BaseService
{
    public function list(array $filters = []): LengthAwarePaginator
    {
        $query = AttendanceRecord::with(['member.user', 'branch'])
            ->orderBy('date', 'desc')
            ->orderBy('checked_in_at', 'desc');

        $query = $this->applyFilters($query, $filters);

        return $query->paginate(15);
    }

    public function checkIn(array $data): AttendanceRecord
    {
        $memberId = $data['member_id'];

        $existing = AttendanceRecord::checkedInToday($memberId)->first();

        if ($existing) {
            throw new \RuntimeException('Member is already checked in today.');
        }

        $record = AttendanceRecord::create([
            'member_id' => $memberId,
            'gym_id' => $data['gym_id'] ?? $this->getDefaultGymId(),
            'branch_id' => $data['branch_id'] ?? null,
            'date' => $data['date'] ?? today(),
            'checked_in_at' => $data['checked_in_at'] ?? now(),
            'notes' => $data['notes'] ?? null,
        ]);

        $this->logInfo('Member checked in', [
            'member_id' => $memberId,
            'record_id' => $record->id,
        ]);

        return $record->load(['member.user']);
    }

    public function checkOut(AttendanceRecord $record): AttendanceRecord
    {
        if ($record->checked_out_at) {
            throw new \RuntimeException('Member is already checked out.');
        }

        $record->update([
            'checked_out_at' => now(),
        ]);

        $this->logInfo('Member checked out', [
            'record_id' => $record->id,
        ]);

        return $record->fresh()->load(['member.user']);
    }

    public function update(AttendanceRecord $record, array $data): AttendanceRecord
    {
        $record->update([
            'checked_in_at' => $data['checked_in_at'] ?? $record->checked_in_at,
            'checked_out_at' => array_key_exists('checked_out_at', $data) ? $data['checked_out_at'] : $record->checked_out_at,
            'notes' => $data['notes'] ?? $record->notes,
        ]);

        $this->logInfo('Attendance record updated', [
            'record_id' => $record->id,
        ]);

        return $record->refresh()->load(['member.user']);
    }

    public function delete(AttendanceRecord $record): void
    {
        $record->delete();

        $this->logInfo('Attendance record deleted', [
            'record_id' => $record->id,
        ]);
    }

    private function getDefaultGymId(): int
    {
        return Gym::firstOrCreate(
            ['slug' => 'default'],
            ['name' => 'Default Gym', 'is_active' => true],
        )->id;
    }

    private function applyFilters(Builder $query, array $filters): Builder
    {
        if (!empty($filters['search'])) {
            $query->whereHas('member.user', function (Builder $q) use ($filters): void {
                $q->whereAny(['name', 'email'], 'like', "%{$filters['search']}%");
            });
        }

        if (!empty($filters['date_from'])) {
            $query->whereDate('date', '>=', $filters['date_from']);
        }

        if (!empty($filters['date_to'])) {
            $query->whereDate('date', '<=', $filters['date_to']);
        }

        if (!empty($filters['member_id'])) {
            $query->where('member_id', $filters['member_id']);
        }

        if (isset($filters['checked_in'])) {
            if (filter_var($filters['checked_in'], FILTER_VALIDATE_BOOLEAN)) {
                $query->whereNull('checked_out_at');
            } else {
                $query->whereNotNull('checked_out_at');
            }
        }

        return $query;
    }
}
