<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StorePackageRequest;
use App\Http\Requests\Admin\UpdatePackageRequest;
use App\Models\Package;
use App\Services\PackageService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class PackageController extends Controller
{
    public function __construct(
        private readonly PackageService $packageService,
    ) {}

    public function index(): View
    {
        $this->authorize('viewAny', Package::class);

        $packages = $this->packageService->list(
            filters: request()->only(['search', 'is_active'])
        );

        return view('admin.packages.index', compact('packages'));
    }

    public function create(): View
    {
        $this->authorize('create', Package::class);

        return view('admin.packages.create');
    }

    public function store(StorePackageRequest $request): RedirectResponse
    {
        $package = $this->packageService->create($request->validated());

        return to_route('admin.packages.show', $package)
            ->with('success', __('Package created successfully.'));
    }

    public function show(Package $package): View
    {
        $this->authorize('view', $package);

        return view('admin.packages.show', compact('package'));
    }

    public function edit(Package $package): View
    {
        $this->authorize('update', $package);

        return view('admin.packages.edit', compact('package'));
    }

    public function update(UpdatePackageRequest $request, Package $package): RedirectResponse
    {
        $this->packageService->update($package, $request->validated());

        return to_route('admin.packages.show', $package)
            ->with('success', __('Package updated successfully.'));
    }

    public function destroy(Package $package): RedirectResponse
    {
        $this->authorize('delete', $package);

        $this->packageService->delete($package);

        return to_route('admin.packages.index')
            ->with('success', __('Package deleted successfully.'));
    }
}
