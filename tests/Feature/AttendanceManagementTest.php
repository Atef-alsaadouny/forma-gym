<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Enums\MemberRole;
use App\Models\AttendanceRecord;
use App\Models\Member;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AttendanceManagementTest extends TestCase
{
    use RefreshDatabase;

    private User $admin;

    private User $manager;

    private User $member;

    protected function setUp(): void
    {
        parent::setUp();

        $this->admin = User::factory()->admin()->create();
        $this->manager = User::factory()->create([
            'role' => MemberRole::Manager,
        ]);
        $this->member = User::factory()->create();
    }

    public function test_guest_cannot_access_attendance_pages(): void
    {
        $this->get(route('admin.attendance.index'))->assertRedirect(route('login'));
        $this->get(route('admin.attendance.create'))->assertRedirect(route('login'));
        $this->get(route('admin.attendance.show', 1))->assertRedirect(route('login'));
        $this->get(route('admin.attendance.edit', 1))->assertRedirect(route('login'));
        $this->post(route('admin.attendance.store'))->assertRedirect(route('login'));
        $this->put(route('admin.attendance.update', 1))->assertRedirect(route('login'));
        $this->delete(route('admin.attendance.destroy', 1))->assertRedirect(route('login'));
    }

    public function test_member_cannot_access_attendance_pages(): void
    {
        $this->actingAs($this->member);

        $this->get(route('admin.attendance.index'))->assertStatus(403);
        $this->get(route('admin.attendance.create'))->assertStatus(403);
    }

    public function test_admin_can_view_attendance_list(): void
    {
        $this->actingAs($this->admin);

        AttendanceRecord::factory()->count(3)->create();

        $response = $this->get(route('admin.attendance.index'));

        $response->assertStatus(200);
        $response->assertViewIs('admin.attendance.index');
    }

    public function test_admin_can_view_create_page(): void
    {
        $this->actingAs($this->admin);

        $response = $this->get(route('admin.attendance.create'));

        $response->assertStatus(200);
        $response->assertViewIs('admin.attendance.create');
    }

    public function test_admin_can_check_in_member(): void
    {
        $this->actingAs($this->admin);

        $member = Member::factory()->create();

        $response = $this->post(route('admin.attendance.store'), [
            'member_id' => $member->id,
            'date' => today()->format('Y-m-d'),
            'checked_in_at' => now()->format('Y-m-d H:i:s'),
        ]);

        $response->assertRedirect();
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('attendance_records', [
            'member_id' => $member->id,
        ]);

        $created = AttendanceRecord::where('member_id', $member->id)->first();

        $this->assertNotNull($created);
        $this->assertEquals(today()->format('Y-m-d'), $created->date->format('Y-m-d'));
    }

    public function test_prevents_duplicate_check_in(): void
    {
        $this->actingAs($this->admin);

        $member = Member::factory()->create();

        AttendanceRecord::factory()->checkedIn()->create([
            'member_id' => $member->id,
        ]);

        $response = $this->post(route('admin.attendance.store'), [
            'member_id' => $member->id,
            'date' => today()->format('Y-m-d'),
            'checked_in_at' => now()->format('Y-m-d H:i:s'),
        ]);

        $response->assertSessionHasErrors(['member_id']);
    }

    public function test_admin_can_check_out_member(): void
    {
        $this->actingAs($this->admin);

        $record = AttendanceRecord::factory()->checkedIn()->create();

        $response = $this->post(route('admin.attendance.check-out', $record));

        $response->assertRedirect();
        $response->assertSessionHas('success');

        $record->refresh();

        $this->assertNotNull($record->checked_out_at);
    }

    public function test_admin_can_view_record_details(): void
    {
        $this->actingAs($this->admin);

        $record = AttendanceRecord::factory()->create();

        $response = $this->get(route('admin.attendance.show', $record));

        $response->assertStatus(200);
        $response->assertViewIs('admin.attendance.show');
        $response->assertSee($record->member->user->name);
    }

    public function test_admin_can_view_edit_page(): void
    {
        $this->actingAs($this->admin);

        $record = AttendanceRecord::factory()->create();

        $response = $this->get(route('admin.attendance.edit', $record));

        $response->assertStatus(200);
        $response->assertViewIs('admin.attendance.edit');
    }

    public function test_admin_can_update_record(): void
    {
        $this->actingAs($this->admin);

        $record = AttendanceRecord::factory()->create();

        $response = $this->put(route('admin.attendance.update', $record), [
            'checked_in_at' => '2026-01-01 08:00:00',
            'checked_out_at' => '2026-01-01 11:00:00',
        ]);

        $response->assertRedirect();
        $response->assertSessionHas('success');

        $record->refresh();

        $this->assertEquals('2026-01-01 08:00:00', $record->checked_in_at->format('Y-m-d H:i:s'));
    }

    public function test_admin_can_delete_record(): void
    {
        $this->actingAs($this->admin);

        $record = AttendanceRecord::factory()->create();

        $response = $this->delete(route('admin.attendance.destroy', $record));

        $response->assertRedirect();
        $response->assertSessionHas('success');

        $this->assertSoftDeleted($record);
    }

    public function test_manager_can_manage_attendance(): void
    {
        $this->actingAs($this->manager);

        $response = $this->get(route('admin.attendance.index'));
        $response->assertStatus(200);

        $member = Member::factory()->create();

        $response = $this->post(route('admin.attendance.store'), [
            'member_id' => $member->id,
            'date' => today()->format('Y-m-d'),
            'checked_in_at' => now()->format('Y-m-d H:i:s'),
        ]);
        $response->assertRedirect();
    }

    public function test_member_cannot_delete_records(): void
    {
        $this->actingAs($this->member);

        $record = AttendanceRecord::factory()->create();

        $response = $this->delete(route('admin.attendance.destroy', $record));

        $response->assertStatus(403);
    }

    public function test_unauthorized_user_cannot_manage_attendance(): void
    {
        $memberUser = User::factory()->create(['role' => MemberRole::Member]);
        $this->actingAs($memberUser);

        $this->get(route('admin.attendance.index'))->assertStatus(403);
    }
}
