<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Enums\MemberRole;
use App\Models\Branch;
use App\Models\Gym;
use App\Models\Member;
use App\Models\Package;
use App\Models\Subscription;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SubscriptionManagementTest extends TestCase
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

    public function test_guest_cannot_access_subscription_pages(): void
    {
        $this->get(route('admin.subscriptions.index'))->assertRedirect(route('login'));
        $this->get(route('admin.subscriptions.create'))->assertRedirect(route('login'));
        $this->get(route('admin.subscriptions.show', 1))->assertRedirect(route('login'));
        $this->get(route('admin.subscriptions.edit', 1))->assertRedirect(route('login'));
        $this->post(route('admin.subscriptions.store'))->assertRedirect(route('login'));
        $this->put(route('admin.subscriptions.update', 1))->assertRedirect(route('login'));
        $this->delete(route('admin.subscriptions.destroy', 1))->assertRedirect(route('login'));
    }

    public function test_member_cannot_access_subscription_pages(): void
    {
        $this->actingAs($this->member);

        $this->get(route('admin.subscriptions.index'))->assertStatus(403);
        $this->get(route('admin.subscriptions.create'))->assertStatus(403);
    }

    public function test_admin_can_view_subscriptions_list(): void
    {
        $this->actingAs($this->admin);

        $gym = Gym::factory()->create();
        $branch = Branch::factory()->create(['gym_id' => $gym->id]);
        Subscription::factory()->count(3)->create([
            'gym_id' => $gym->id,
            'branch_id' => $branch->id,
        ]);

        $response = $this->get(route('admin.subscriptions.index'));

        $response->assertStatus(200);
        $response->assertViewIs('admin.subscriptions.index');
    }

    public function test_admin_can_view_create_subscription_page(): void
    {
        $this->actingAs($this->admin);

        $response = $this->get(route('admin.subscriptions.create'));

        $response->assertStatus(200);
        $response->assertViewIs('admin.subscriptions.create');
    }

    public function test_admin_can_create_subscription(): void
    {
        $this->actingAs($this->admin);

        $member = Member::factory()->create();
        $package = Package::factory()->create();

        $response = $this->post(route('admin.subscriptions.store'), [
            'member_id' => $member->id,
            'package_id' => $package->id,
            'start_date' => '2026-01-01',
            'end_date' => '2026-03-31',
            'status' => 'active',
            'price_paid' => 99.99,
            'notes' => 'Test subscription',
        ]);

        $response->assertRedirect();
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('subscriptions', [
            'member_id' => $member->id,
            'package_id' => $package->id,
            'status' => 'active',
        ]);
    }

    public function test_validation_prevents_invalid_subscription_creation(): void
    {
        $this->actingAs($this->admin);

        $response = $this->post(route('admin.subscriptions.store'), [
            'member_id' => '',
            'package_id' => '',
            'start_date' => '',
            'end_date' => '',
            'status' => '',
        ]);

        $response->assertSessionHasErrors(['member_id', 'package_id', 'start_date', 'end_date', 'status']);
    }

    public function test_end_date_must_be_after_start_date(): void
    {
        $this->actingAs($this->admin);

        $member = Member::factory()->create();
        $package = Package::factory()->create();

        $response = $this->post(route('admin.subscriptions.store'), [
            'member_id' => $member->id,
            'package_id' => $package->id,
            'start_date' => '2026-06-01',
            'end_date' => '2026-05-01',
            'status' => 'active',
        ]);

        $response->assertSessionHasErrors(['end_date']);
    }

    public function test_admin_can_view_subscription_details(): void
    {
        $this->actingAs($this->admin);

        $subscription = Subscription::factory()->create();

        $response = $this->get(route('admin.subscriptions.show', $subscription));

        $response->assertStatus(200);
        $response->assertViewIs('admin.subscriptions.show');
        $response->assertSee($subscription->member->user->name);
    }

    public function test_admin_can_view_edit_subscription_page(): void
    {
        $this->actingAs($this->admin);

        $subscription = Subscription::factory()->create();

        $response = $this->get(route('admin.subscriptions.edit', $subscription));

        $response->assertStatus(200);
        $response->assertViewIs('admin.subscriptions.edit');
    }

    public function test_admin_can_update_subscription(): void
    {
        $this->actingAs($this->admin);

        $subscription = Subscription::factory()->create();
        $newPackage = Package::factory()->create();

        $response = $this->put(route('admin.subscriptions.update', $subscription), [
            'package_id' => $newPackage->id,
            'start_date' => '2026-02-01',
            'end_date' => '2026-08-01',
            'status' => 'cancelled',
        ]);

        $response->assertRedirect();
        $response->assertSessionHas('success');

        $subscription->refresh();

        $this->assertEquals($newPackage->id, $subscription->package_id);
        $this->assertEquals('cancelled', $subscription->status->value);
    }

    public function test_admin_can_delete_subscription(): void
    {
        $this->actingAs($this->admin);

        $subscription = Subscription::factory()->create();

        $response = $this->delete(route('admin.subscriptions.destroy', $subscription));

        $response->assertRedirect();
        $response->assertSessionHas('success');

        $this->assertSoftDeleted($subscription);
    }

    public function test_manager_can_manage_subscriptions(): void
    {
        $this->actingAs($this->manager);

        $response = $this->get(route('admin.subscriptions.index'));
        $response->assertStatus(200);

        $member = Member::factory()->create();
        $package = Package::factory()->create();

        $response = $this->post(route('admin.subscriptions.store'), [
            'member_id' => $member->id,
            'package_id' => $package->id,
            'start_date' => '2026-01-01',
            'end_date' => '2026-06-30',
            'status' => 'active',
        ]);
        $response->assertRedirect();
    }

    public function test_member_cannot_delete_subscriptions(): void
    {
        $this->actingAs($this->member);

        $subscription = Subscription::factory()->create();

        $response = $this->delete(route('admin.subscriptions.destroy', $subscription));

        $response->assertStatus(403);
    }

    public function test_search_filter_works(): void
    {
        $this->actingAs($this->admin);

        $target = Subscription::factory()->create();
        $target->member->user->update(['name' => 'UniqueSearchName']);

        $other = Subscription::factory()->create();

        $response = $this->get(route('admin.subscriptions.index', ['search' => 'UniqueSearchName']));

        $response->assertStatus(200);
        $response->assertSee('UniqueSearchName');
    }

    public function test_status_filter_works(): void
    {
        $this->actingAs($this->admin);

        Subscription::factory()->active()->create();
        Subscription::factory()->expired()->create();

        $response = $this->get(route('admin.subscriptions.index', ['status' => 'expired']));

        $response->assertStatus(200);
    }

    public function test_package_filter_works(): void
    {
        $this->actingAs($this->admin);

        $package = Package::factory()->create();
        Subscription::factory()->create(['package_id' => $package->id]);

        $response = $this->get(route('admin.subscriptions.index', ['package_id' => $package->id]));

        $response->assertStatus(200);
    }

    public function test_unauthorized_user_cannot_manage_subscriptions(): void
    {
        $memberUser = User::factory()->create(['role' => MemberRole::Member]);
        $this->actingAs($memberUser);

        $this->get(route('admin.subscriptions.index'))->assertStatus(403);
    }
}
