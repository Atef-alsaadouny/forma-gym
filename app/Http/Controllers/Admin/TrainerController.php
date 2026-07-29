<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Trainer\StoreTrainerRequest;
use App\Http\Requests\Trainer\UpdateTrainerRequest;
use App\Models\Trainer;
use App\Services\TrainerService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class TrainerController extends Controller
{
    public function __construct(
        private readonly TrainerService $trainerService,
    ) {}

    public function index(): View
    {
        $this->authorize('viewAny', Trainer::class);

        $trainers = $this->trainerService->list(
            filters: request()->only(['search', 'status', 'specialization', 'is_available', 'gender'])
        );

        return view('admin.trainers.index', compact('trainers'));
    }

    public function create(): View
    {
        $this->authorize('create', Trainer::class);

        return view('admin.trainers.create');
    }

    public function store(StoreTrainerRequest $request): RedirectResponse
    {
        $trainer = $this->trainerService->create($request->validated());

        return to_route('admin.trainers.show', $trainer)
            ->with('success', 'Trainer created successfully.');
    }

    public function show(Trainer $trainer): View
    {
        $this->authorize('view', $trainer);

        $trainer->load('user');

        return view('admin.trainers.show', compact('trainer'));
    }

    public function edit(Trainer $trainer): View
    {
        $this->authorize('update', $trainer);

        $trainer->load('user');

        return view('admin.trainers.edit', compact('trainer'));
    }

    public function update(UpdateTrainerRequest $request, Trainer $trainer): RedirectResponse
    {
        $trainer = $this->trainerService->update($trainer, $request->validated());

        return to_route('admin.trainers.show', $trainer)
            ->with('success', 'Trainer updated successfully.');
    }

    public function destroy(Trainer $trainer): RedirectResponse
    {
        $this->authorize('delete', $trainer);

        $this->trainerService->delete($trainer);

        return to_route('admin.trainers.index')
            ->with('success', 'Trainer deleted successfully.');
    }
}
