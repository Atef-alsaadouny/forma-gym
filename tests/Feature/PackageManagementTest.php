<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Enums\MemberRole;
use App\Models\Package;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PackageManagementTest extends TestCase
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

    public function test_guest_cannot_access_package_pages(): void
    {
        $this->get(route('admin.packages.index'))->assertRedirect(route('login'));
        $this->get(route('admin.packages.create'))->assertRedirect(route('login'));
        $this->get(route('admin.packages.show', 1))->assertRedirect(route('login'));
        $this->get(route('admin.packages.edit', 1))->assertRedirect(route('login'));
        $this->post(route('admin.packages.store'))->assertRedirect(route('login'));
        $this->put(route('admin.packages.update', 1))->assertRedirect(route('login'));
        $this->delete(route('admin.packages.destroy', 1))->assertRedirect(route('login'));
    }

    public function test_member_cannot_access_package_management_pages(): void
    {
        $this->actingAs($this->member);

        $this->get(route('admin.packages.index'))->assertStatus(403);
        $this->get(route('admin.packages.create'))->assertStatus(403);
    }

    public function test_admin_can_view_packages_list(): void
    {
        $this->actingAs($this->admin);

        Package::factory()->count(3)->create();

        $response = $this->get(route('admin.packages.index'));

        $response->assertStatus(200);
        $response->assertViewIs('admin.packages.index');
    }

    public function test_admin_can_view_create_package_page(): void
    {
        $this->actingAs($this->admin);

        $response = $this->get(route('admin.packages.create'));

        $response->assertStatus(200);
        $response->assertViewIs('admin.packages.create');
    }

    public function test_admin_can_create_package(): void
    {
        $this->actingAs($this->admin);

        $response = $this->post(route('admin.packages.store'), [
            'name' => 'Gold Membership',
            'description' => 'Premium gym access',
            'duration_days' => 30,
            'price' => 49.99,
            'number_of_sessions' => 12,
            'features' => "Gym Access\nLocker Room\nGroup Classes",
            'is_active' => true,
            'sort_order' => 1,
        ]);

        $response->assertRedirect();
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('packages', [
            'name' => 'Gold Membership',
            'price' => 49.99,
            'duration_days' => 30,
            'is_active' => true,
        ]);
    }

    public function test_validation_prevents_invalid_package_creation(): void
    {
        $this->actingAs($this->admin);

        $response = $this->post(route('admin.packages.store'), [
            'name' => '',
            'duration_days' => -1,
            'price' => -10,
        ]);

        $response->assertSessionHasErrors(['name', 'duration_days', 'price']);
    }

    public function test_admin_can_view_package_details(): void
    {
        $this->actingAs($this->admin);

        $package = Package::factory()->create();

        $response = $this->get(route('admin.packages.show', $package));

        $response->assertStatus(200);
        $response->assertViewIs('admin.packages.show');
        $response->assertSee($package->name);
    }

    public function test_admin_can_view_edit_package_page(): void
    {
        $this->actingAs($this->admin);

        $package = Package::factory()->create();

        $response = $this->get(route('admin.packages.edit', $package));

        $response->assertStatus(200);
        $response->assertViewIs('admin.packages.edit');
    }

    public function test_admin_can_update_package(): void
    {
        $this->actingAs($this->admin);

        $package = Package::factory()->create();

        $response = $this->put(route('admin.packages.update', $package), [
            'name' => 'Updated Plan',
            'duration_days' => 90,
            'price' => 99.99,
            'is_active' => false,
        ]);

        $response->assertRedirect();
        $response->assertSessionHas('success');

        $package->refresh();

        $this->assertEquals('Updated Plan', $package->name);
        $this->assertEquals(90, $package->duration_days);
        $this->assertEquals(99.99, (float) $package->price);
        $this->assertFalse($package->is_active);
    }

    public function test_admin_can_delete_package(): void
    {
        $this->actingAs($this->admin);

        $package = Package::factory()->create();

        $response = $this->delete(route('admin.packages.destroy', $package));

        $response->assertRedirect();
        $response->assertSessionHas('success');

        $this->assertSoftDeleted($package);
    }

    public function test_manager_can_manage_packages(): void
    {
        $this->actingAs($this->manager);

        $response = $this->get(route('admin.packages.index'));
        $response->assertStatus(200);

        $response = $this->post(route('admin.packages.store'), [
            'name' => 'Manager Created',
            'duration_days' => 30,
            'price' => 29.99,
        ]);
        $response->assertRedirect();
    }

    public function test_member_cannot_delete_packages(): void
    {
        $this->actingAs($this->member);

        $package = Package::factory()->create();

        $response = $this->delete(route('admin.packages.destroy', $package));

        $response->assertStatus(403);
    }

    public function test_search_filter_works(): void
    {
        $this->actingAs($this->admin);

        Package::factory()->create(['name' => 'Basic Plan']);
        Package::factory()->create(['name' => 'Premium Plan']);

        $response = $this->get(route('admin.packages.index', ['search' => 'Premium']));

        $response->assertStatus(200);
        $response->assertSee('Premium Plan');
        $response->assertDontSee('Basic Plan');
    }

    public function test_status_filter_works(): void
    {
        $this->actingAs($this->admin);

        Package::factory()->create(['name' => 'Active Plan', 'is_active' => true]);
        Package::factory()->create(['name' => 'Inactive Plan', 'is_active' => false]);

        $response = $this->get(route('admin.packages.index', ['is_active' => '0']));

        $response->assertStatus(200);
        $response->assertSee('Inactive Plan');
    }

    public function test_unauthorized_user_cannot_manage_packages(): void
    {
        $memberUser = User::factory()->create(['role' => MemberRole::Member]);
        $this->actingAs($memberUser);

        $this->get(route('admin.packages.index'))->assertStatus(403);
    }
}
