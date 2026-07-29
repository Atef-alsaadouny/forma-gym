<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreAttendanceRequest;
use App\Http\Requests\Admin\UpdateAttendanceRequest;
use App\Models\AttendanceRecord;
use App\Models\Member;
use App\Services\AttendanceService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class AttendanceController extends Controller
{
    public function __construct(
        private readonly AttendanceService $attendanceService,
    ) {}

    public function index(): View
    {
        $this->authorize('viewAny', AttendanceRecord::class);

        $records = $this->attendanceService->list(
            filters: request()->only(['search', 'date_from', 'date_to', 'member_id', 'checked_in'])
        );

        $members = Member::with('user')->get()->sortBy('user.name');

        return view('admin.attendance.index', compact('records', 'members'));
    }

    public function create(): View
    {
        $this->authorize('create', AttendanceRecord::class);

        $members = Member::with('user')->get()->sortBy('user.name');

        return view('admin.attendance.create', compact('members'));
    }

    public function store(StoreAttendanceRequest $request): RedirectResponse
    {
        try {
            $record = $this->attendanceService->checkIn($request->validated());
        } catch (\RuntimeException $e) {
            return back()->withInput()->withErrors(['member_id' => $e->getMessage()]);
        }

        return to_route('admin.attendance.show', $record)
            ->with('success', __('Check-in recorded successfully.'));
    }

    public function show(AttendanceRecord $attendance): View
    {
        $this->authorize('view', $attendance);

        $attendance->load(['member.user', 'branch']);

        return view('admin.attendance.show', compact('attendance'));
    }

    public function edit(AttendanceRecord $attendance): View
    {
        $this->authorize('update', $attendance);

        $attendance->load('member.user');

        return view('admin.attendance.edit', compact('attendance'));
    }

    public function update(UpdateAttendanceRequest $request, AttendanceRecord $attendance): RedirectResponse
    {
        $this->attendanceService->update($attendance, $request->validated());

        return to_route('admin.attendance.show', $attendance)
            ->with('success', __('Attendance record updated successfully.'));
    }

    public function destroy(AttendanceRecord $attendance): RedirectResponse
    {
        $this->authorize('delete', $attendance);

        $this->attendanceService->delete($attendance);

        return to_route('admin.attendance.index')
            ->with('success', __('Attendance record deleted successfully.'));
    }

    public function checkOut(AttendanceRecord $record): RedirectResponse
    {
        $this->authorize('update', $record);

        try {
            $this->attendanceService->checkOut($record);
        } catch (\RuntimeException $e) {
            return back()->withErrors(['error' => $e->getMessage()]);
        }

        return to_route('admin.attendance.show', $record)
            ->with('success', __('Check-out recorded successfully.'));
    }
}
