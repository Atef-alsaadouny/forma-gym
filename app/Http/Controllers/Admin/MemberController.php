<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Member\StoreMemberRequest;
use App\Http\Requests\Member\UpdateMemberRequest;
use App\Models\Member;
use App\Services\MemberService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class MemberController extends Controller
{
    public function __construct(
        private readonly MemberService $memberService,
    ) {}

    public function index(): View
    {
        $this->authorize('viewAny', Member::class);

        $members = $this->memberService->list(
            filters: request()->only(['search', 'status', 'gender', 'date_from', 'date_to'])
        );

        return view('admin.members.index', compact('members'));
    }

    public function create(): View
    {
        $this->authorize('create', Member::class);

        return view('admin.members.create');
    }

    public function store(StoreMemberRequest $request): RedirectResponse
    {
        $member = $this->memberService->create($request->validated());

        return to_route('admin.members.show', $member)
            ->with('success', __('Member created successfully.'));
    }

    public function show(Member $member): View
    {
        $this->authorize('view', $member);

        $member->load('user');

        return view('admin.members.show', compact('member'));
    }

    public function edit(Member $member): View
    {
        $this->authorize('update', $member);

        $member->load('user');

        return view('admin.members.edit', compact('member'));
    }

    public function update(UpdateMemberRequest $request, Member $member): RedirectResponse
    {
        $member = $this->memberService->update($member, $request->validated());

        return to_route('admin.members.show', $member)
            ->with('success', __('Member updated successfully.'));
    }

    public function destroy(Member $member): RedirectResponse
    {
        $this->authorize('delete', $member);

        $this->memberService->delete($member);

        return to_route('admin.members.index')
            ->with('success', __('Member deleted successfully.'));
    }
}
