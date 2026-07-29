<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\Package;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;

class PackageService extends BaseService
{
    public function list(array $filters = []): LengthAwarePaginator
    {
        $query = Package::orderBy('sort_order')
            ->orderBy('name');

        $query = $this->applyFilters($query, $filters);

        return $query->paginate(15);
    }

    public function create(array $data): Package
    {
        $package = Package::create([
            'gym_id' => $data['gym_id'] ?? $this->getDefaultGymId(),
            'branch_id' => $data['branch_id'] ?? null,
            'name' => $data['name'],
            'description' => $data['description'] ?? null,
            'duration_days' => $data['duration_days'],
            'price' => $data['price'],
            'number_of_sessions' => $data['number_of_sessions'] ?? null,
            'features' => isset($data['features']) ? array_map('trim', explode("\n", $data['features'])) : null,
            'is_active' => $data['is_active'] ?? true,
            'sort_order' => $data['sort_order'] ?? 0,
        ]);

        $this->logInfo('Package created', ['package_id' => $package->id, 'name' => $package->name]);

        return $package;
    }

    public function update(Package $package, array $data): Package
    {
        $package->update([
            'name' => $data['name'] ?? $package->name,
            'description' => $data['description'] ?? $package->description,
            'duration_days' => $data['duration_days'] ?? $package->duration_days,
            'price' => $data['price'] ?? $package->price,
            'number_of_sessions' => array_key_exists('number_of_sessions', $data) ? $data['number_of_sessions'] : $package->number_of_sessions,
            'features' => isset($data['features']) ? array_map('trim', explode("\n", $data['features'])) : $package->features,
            'is_active' => $data['is_active'] ?? $package->is_active,
            'sort_order' => $data['sort_order'] ?? $package->sort_order,
            'branch_id' => array_key_exists('branch_id', $data) ? $data['branch_id'] : $package->branch_id,
        ]);

        $this->logInfo('Package updated', ['package_id' => $package->id]);

        return $package;
    }

    public function delete(Package $package): void
    {
        $package->delete();

        $this->logInfo('Package deleted', ['package_id' => $package->id]);
    }

    private function getDefaultGymId(): int
    {
        return \App\Models\Gym::firstOrCreate(
            ['slug' => 'default'],
            ['name' => 'Default Gym', 'is_active' => true],
        )->id;
    }

    private function applyFilters(Builder $query, array $filters): Builder
    {
        if (!empty($filters['search'])) {
            $query->search($filters['search']);
        }

        if (isset($filters['is_active'])) {
            $query->where('is_active', filter_var($filters['is_active'], FILTER_VALIDATE_BOOLEAN));
        }

        return $query;
    }
}
