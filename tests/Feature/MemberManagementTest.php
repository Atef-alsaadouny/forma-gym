<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Enums\MemberRole;
use App\Enums\MemberStatus;
use App\Models\Member;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MemberManagementTest extends TestCase
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

    public function test_guest_cannot_access_member_pages(): void
    {
        $this->get(route('admin.members.index'))->assertRedirect(route('login'));
        $this->get(route('admin.members.create'))->assertRedirect(route('login'));
        $this->get(route('admin.members.show', 1))->assertRedirect(route('login'));
        $this->get(route('admin.members.edit', 1))->assertRedirect(route('login'));
        $this->post(route('admin.members.store'))->assertRedirect(route('login'));
        $this->put(route('admin.members.update', 1))->assertRedirect(route('login'));
        $this->delete(route('admin.members.destroy', 1))->assertRedirect(route('login'));
    }

    public function test_member_cannot_access_member_management_pages(): void
    {
        $this->actingAs($this->member);

        $this->get(route('admin.members.index'))->assertStatus(403);
        $this->get(route('admin.members.create'))->assertStatus(403);
    }

    public function test_admin_can_view_members_list(): void
    {
        $this->actingAs($this->admin);

        Member::factory()->count(3)->create();

        $response = $this->get(route('admin.members.index'));

        $response->assertStatus(200);
        $response->assertViewIs('admin.members.index');
    }

    public function test_admin_can_view_create_member_page(): void
    {
        $this->actingAs($this->admin);

        $response = $this->get(route('admin.members.create'));

        $response->assertStatus(200);
        $response->assertViewIs('admin.members.create');
    }

    public function test_admin_can_create_member(): void
    {
        $this->actingAs($this->admin);

        $response = $this->post(route('admin.members.store'), [
            'first_name' => 'John',
            'last_name' => 'Doe',
            'email' => 'john@example.com',
            'phone' => '1234567890',
            'gender' => 'male',
            'date_of_birth' => '1990-01-15',
            'emergency_contact' => 'Jane Doe',
            'emergency_phone' => '0987654321',
            'notes' => 'Test member',
        ]);

        $response->assertRedirect();
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('users', [
            'email' => 'john@example.com',
            'name' => 'John Doe',
        ]);

        $user = User::where('email', 'john@example.com')->first();
        $this->assertDatabaseHas('members', [
            'user_id' => $user->id,
            'status' => MemberStatus::Active->value,
        ]);
    }

    public function test_validation_prevents_invalid_member_creation(): void
    {
        $this->actingAs($this->admin);

        $response = $this->post(route('admin.members.store'), [
            'first_name' => '',
            'last_name' => '',
            'email' => 'not-an-email',
        ]);

        $response->assertSessionHasErrors(['first_name', 'last_name', 'email']);
    }

    public function test_validation_prevents_duplicate_email(): void
    {
        $this->actingAs($this->admin);

        User::factory()->create(['email' => 'existing@example.com']);

        $response = $this->post(route('admin.members.store'), [
            'first_name' => 'John',
            'last_name' => 'Doe',
            'email' => 'existing@example.com',
        ]);

        $response->assertSessionHasErrors(['email']);
    }

    public function test_admin_can_view_member_details(): void
    {
        $this->actingAs($this->admin);

        $member = Member::factory()->create();

        $response = $this->get(route('admin.members.show', $member));

        $response->assertStatus(200);
        $response->assertViewIs('admin.members.show');
        $response->assertSee($member->user->name);
    }

    public function test_admin_can_view_edit_member_page(): void
    {
        $this->actingAs($this->admin);

        $member = Member::factory()->create();

        $response = $this->get(route('admin.members.edit', $member));

        $response->assertStatus(200);
        $response->assertViewIs('admin.members.edit');
    }

    public function test_admin_can_update_member(): void
    {
        $this->actingAs($this->admin);

        $member = Member::factory()->create();

        $response = $this->put(route('admin.members.update', $member), [
            'first_name' => 'Updated',
            'last_name' => 'Name',
            'email' => 'updated@example.com',
            'status' => 'inactive',
        ]);

        $response->assertRedirect();
        $response->assertSessionHas('success');

        $member->refresh();

        $this->assertEquals('inactive', $member->status->value);
        $this->assertEquals('Updated Name', $member->user->name);
        $this->assertEquals('updated@example.com', $member->user->email);
    }

    public function test_admin_can_delete_member(): void
    {
        $this->actingAs($this->admin);

        $member = Member::factory()->create();

        $response = $this->delete(route('admin.members.destroy', $member));

        $response->assertRedirect();
        $response->assertSessionHas('success');

        $this->assertSoftDeleted($member);
    }

    public function test_manager_can_manage_members(): void
    {
        $this->actingAs($this->manager);

        $response = $this->get(route('admin.members.index'));
        $response->assertStatus(200);

        $member = Member::factory()->create();

        $response = $this->get(route('admin.members.show', $member));
        $response->assertStatus(200);

        $response = $this->post(route('admin.members.store'), [
            'first_name' => 'Manager',
            'last_name' => 'Created',
            'email' => 'manager@example.com',
        ]);
        $response->assertRedirect();
    }

    public function test_member_cannot_delete_other_members(): void
    {
        $this->actingAs($this->member);

        $member = Member::factory()->create();

        $response = $this->delete(route('admin.members.destroy', $member));

        $response->assertStatus(403);
    }

    public function test_search_filter_works(): void
    {
        $this->actingAs($this->admin);

        Member::factory()->create();
        $target = Member::factory()->create();
        $target->user->update(['name' => 'UniqueSearchName']);

        $response = $this->get(route('admin.members.index', ['search' => 'UniqueSearchName']));

        $response->assertStatus(200);
        $response->assertSee('UniqueSearchName');
    }

    public function test_status_filter_works(): void
    {
        $this->actingAs($this->admin);

        Member::factory()->active()->create();
        Member::factory()->inactive()->create();
        Member::factory()->suspended()->create();

        $response = $this->get(route('admin.members.index', ['status' => 'active']));

        $response->assertStatus(200);
    }

    public function test_unauthorized_user_cannot_manage_members(): void
    {
        $memberUser = User::factory()->create(['role' => MemberRole::Member]);
        $this->actingAs($memberUser);

        $this->get(route('admin.members.index'))->assertStatus(403);
    }
}
