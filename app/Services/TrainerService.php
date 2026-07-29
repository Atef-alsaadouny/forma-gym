<?php

declare(strict_types=1);

namespace App\Services;

use App\Enums\MemberRole;
use App\Enums\TrainerStatus;
use App\Models\Trainer;
use App\Models\User;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class TrainerService extends BaseService
{
    public function list(array $filters = []): LengthAwarePaginator
    {
        $query = Trainer::with('user')
            ->orderBy('created_at', 'desc');

        $query = $this->applyFilters($query, $filters);

        return $query->paginate(15);
    }

    public function create(array $data): Trainer
    {
        $user = User::create([
            'name' => $data['first_name'].' '.$data['last_name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password'] ?? 'password'),
            'phone' => $data['phone'] ?? null,
            'role' => MemberRole::Trainer,
            'is_active' => true,
        ]);

        $trainer = Trainer::create([
            'user_id' => $user->id,
            'gym_id' => $data['gym_id'] ?? $this->getDefaultGymId(),
            'branch_id' => $data['branch_id'] ?? null,
            'specialization' => $data['specialization'] ?? null,
            'experience_years' => $data['experience_years'] ?? null,
            'rating' => null,
            'bio' => $data['bio'] ?? null,
            'certifications' => isset($data['certifications'])
                ? (is_string($data['certifications']) ? explode(',', $data['certifications']) : $data['certifications'])
                : null,
            'profile_photo_path' => isset($data['profile_photo'])
                ? $this->uploadPhoto($data['profile_photo'])
                : null,
            'is_available' => true,
            'status' => TrainerStatus::Active,
            'joined_at' => $data['joined_at'] ?? now(),
            'notes' => $data['notes'] ?? null,
            'gender' => $data['gender'] ?? null,
            'date_of_birth' => $data['date_of_birth'] ?? null,
        ]);

        $this->logInfo('Trainer created', ['trainer_id' => $trainer->id, 'user_id' => $user->id]);

        return $trainer->load('user');
    }

    public function update(Trainer $trainer, array $data): Trainer
    {
        $trainer->update([
            'branch_id' => $data['branch_id'] ?? $trainer->branch_id,
            'specialization' => $data['specialization'] ?? $trainer->specialization,
            'experience_years' => $data['experience_years'] ?? $trainer->experience_years,
            'bio' => $data['bio'] ?? $trainer->bio,
            'certifications' => isset($data['certifications'])
                ? (is_string($data['certifications']) ? explode(',', $data['certifications']) : $data['certifications'])
                : $trainer->certifications,
            'is_available' => $data['is_available'] ?? $trainer->is_available,
            'status' => $data['status'] ?? $trainer->status,
            'joined_at' => $data['joined_at'] ?? $trainer->joined_at,
            'notes' => $data['notes'] ?? $trainer->notes,
            'gender' => $data['gender'] ?? $trainer->gender,
            'date_of_birth' => $data['date_of_birth'] ?? $trainer->date_of_birth,
        ]);

        if (isset($data['profile_photo'])) {
            if ($trainer->profile_photo_path) {
                Storage::disk('public')->delete($trainer->profile_photo_path);
            }
            $trainer->update(['profile_photo_path' => $this->uploadPhoto($data['profile_photo'])]);
        }

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
                $trainer->user->update($userData);
            }
        }

        if (isset($data['rating'])) {
            $trainer->update(['rating' => $data['rating']]);
        }

        $this->logInfo('Trainer updated', ['trainer_id' => $trainer->id]);

        return $trainer->load('user');
    }

    public function delete(Trainer $trainer): void
    {
        if ($trainer->profile_photo_path) {
            Storage::disk('public')->delete($trainer->profile_photo_path);
        }
        $trainer->delete();

        $this->logInfo('Trainer deleted', ['trainer_id' => $trainer->id]);
    }

    public function restore(int $trainerId): Trainer
    {
        $trainer = Trainer::withTrashed()->findOrFail($trainerId);
        $trainer->restore();

        $this->logInfo('Trainer restored', ['trainer_id' => $trainer->id]);

        return $trainer->load('user');
    }

    public function forceDelete(int $trainerId): void
    {
        $trainer = Trainer::withTrashed()->findOrFail($trainerId);
        if ($trainer->profile_photo_path) {
            Storage::disk('public')->delete($trainer->profile_photo_path);
        }
        $trainer->forceDelete();

        $this->logInfo('Trainer permanently deleted', ['trainer_id' => $trainerId]);
    }

    public function updateStatus(Trainer $trainer, TrainerStatus $status): Trainer
    {
        $trainer->update(['status' => $status]);

        $this->logInfo('Trainer status updated', [
            'trainer_id' => $trainer->id,
            'status' => $status->value,
        ]);

        return $trainer->load('user');
    }

    private function uploadPhoto(UploadedFile $photo): string
    {
        return $photo->store('trainer-photos', 'public');
    }

    private function applyFilters(Builder $query, array $filters): Builder
    {
        if (! empty($filters['search'])) {
            $query->search($filters['search']);
        }

        if (! empty($filters['status'])) {
            $status = TrainerStatus::tryFrom($filters['status']);
            if ($status) {
                $query->byStatus($status);
            }
        }

        if (! empty($filters['specialization'])) {
            $query->bySpecialization($filters['specialization']);
        }

        if (! empty($filters['is_available'])) {
            $query->available();
        }

        if (! empty($filters['gender'])) {
            $query->where('gender', $filters['gender']);
        }

        return $query;
    }
}
