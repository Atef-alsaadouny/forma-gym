<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Enums\MemberRole;
use App\Enums\TrainerStatus;
use App\Models\Trainer;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class TrainerManagementTest extends TestCase
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

    public function test_guest_cannot_access_trainer_pages(): void
    {
        $this->get(route('admin.trainers.index'))->assertRedirect(route('login'));
        $this->get(route('admin.trainers.create'))->assertRedirect(route('login'));
        $this->get(route('admin.trainers.show', 1))->assertRedirect(route('login'));
        $this->get(route('admin.trainers.edit', 1))->assertRedirect(route('login'));
        $this->post(route('admin.trainers.store'))->assertRedirect(route('login'));
        $this->put(route('admin.trainers.update', 1))->assertRedirect(route('login'));
        $this->delete(route('admin.trainers.destroy', 1))->assertRedirect(route('login'));
    }

    public function test_member_cannot_access_trainer_management_pages(): void
    {
        $this->actingAs($this->member);

        $this->get(route('admin.trainers.index'))->assertStatus(403);
        $this->get(route('admin.trainers.create'))->assertStatus(403);
    }

    public function test_admin_can_view_trainers_list(): void
    {
        $this->actingAs($this->admin);

        Trainer::factory()->count(3)->create();

        $response = $this->get(route('admin.trainers.index'));

        $response->assertStatus(200);
        $response->assertViewIs('admin.trainers.index');
    }

    public function test_admin_can_view_create_trainer_page(): void
    {
        $this->actingAs($this->admin);

        $response = $this->get(route('admin.trainers.create'));

        $response->assertStatus(200);
        $response->assertViewIs('admin.trainers.create');
    }

    public function test_admin_can_create_trainer(): void
    {
        $this->actingAs($this->admin);

        $response = $this->post(route('admin.trainers.store'), [
            'first_name' => 'John',
            'last_name' => 'Smith',
            'email' => 'john.smith@example.com',
            'phone' => '1234567890',
            'specialization' => 'Personal Training',
            'experience_years' => 5,
            'bio' => 'Certified personal trainer with 5 years of experience.',
            'certifications' => 'CPT, Nutrition Specialist',
            'gender' => 'male',
            'date_of_birth' => '1990-01-15',
            'notes' => 'Great trainer.',
        ]);

        $response->assertRedirect();
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('users', [
            'email' => 'john.smith@example.com',
            'name' => 'John Smith',
            'role' => MemberRole::Trainer->value,
        ]);

        $user = User::where('email', 'john.smith@example.com')->first();
        $this->assertDatabaseHas('trainers', [
            'user_id' => $user->id,
            'specialization' => 'Personal Training',
            'experience_years' => 5,
            'status' => TrainerStatus::Active->value,
        ]);
    }

    public function test_validation_prevents_invalid_trainer_creation(): void
    {
        $this->actingAs($this->admin);

        $response = $this->post(route('admin.trainers.store'), [
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

        $response = $this->post(route('admin.trainers.store'), [
            'first_name' => 'John',
            'last_name' => 'Smith',
            'email' => 'existing@example.com',
        ]);

        $response->assertSessionHasErrors(['email']);
    }

    public function test_admin_can_view_trainer_details(): void
    {
        $this->actingAs($this->admin);

        $trainer = Trainer::factory()->create();

        $response = $this->get(route('admin.trainers.show', $trainer));

        $response->assertStatus(200);
        $response->assertViewIs('admin.trainers.show');
        $response->assertSee($trainer->user->name);
    }

    public function test_admin_can_view_edit_trainer_page(): void
    {
        $this->actingAs($this->admin);

        $trainer = Trainer::factory()->create();

        $response = $this->get(route('admin.trainers.edit', $trainer));

        $response->assertStatus(200);
        $response->assertViewIs('admin.trainers.edit');
    }

    public function test_admin_can_update_trainer(): void
    {
        $this->actingAs($this->admin);

        $trainer = Trainer::factory()->create();

        $response = $this->put(route('admin.trainers.update', $trainer), [
            'first_name' => 'Updated',
            'last_name' => 'Name',
            'email' => 'updated@example.com',
            'specialization' => 'Yoga',
            'status' => 'inactive',
            'is_available' => false,
        ]);

        $response->assertRedirect();
        $response->assertSessionHas('success');

        $trainer->refresh();

        $this->assertEquals('inactive', $trainer->status->value);
        $this->assertEquals('Yoga', $trainer->specialization);
        $this->assertFalse($trainer->is_available);
        $this->assertEquals('Updated Name', $trainer->user->name);
        $this->assertEquals('updated@example.com', $trainer->user->email);
    }

    public function test_admin_can_delete_trainer(): void
    {
        $this->actingAs($this->admin);

        $trainer = Trainer::factory()->create();

        $response = $this->delete(route('admin.trainers.destroy', $trainer));

        $response->assertRedirect();
        $response->assertSessionHas('success');

        $this->assertSoftDeleted($trainer);
    }

    public function test_manager_can_manage_trainers(): void
    {
        $this->actingAs($this->manager);

        $response = $this->get(route('admin.trainers.index'));
        $response->assertStatus(200);

        $trainer = Trainer::factory()->create();

        $response = $this->get(route('admin.trainers.show', $trainer));
        $response->assertStatus(200);

        $response = $this->post(route('admin.trainers.store'), [
            'first_name' => 'Manager',
            'last_name' => 'Created',
            'email' => 'manager.created@example.com',
        ]);
        $response->assertRedirect();
    }

    public function test_trainer_can_view_own_profile(): void
    {
        $trainerUser = User::factory()->create(['role' => MemberRole::Trainer]);
        $this->actingAs($trainerUser);

        $trainer = Trainer::factory()->create(['user_id' => $trainerUser->id]);

        $response = $this->get(route('admin.trainers.show', $trainer));
        $response->assertStatus(200);

        $response = $this->get(route('admin.trainers.edit', $trainer));
        $response->assertStatus(200);

        $response = $this->put(route('admin.trainers.update', $trainer), [
            'first_name' => 'Self',
            'last_name' => 'Update',
            'email' => $trainerUser->email,
        ]);
        $response->assertRedirect();
    }

    public function test_member_cannot_delete_other_trainers(): void
    {
        $this->actingAs($this->member);

        $trainer = Trainer::factory()->create();

        $response = $this->delete(route('admin.trainers.destroy', $trainer));

        $response->assertStatus(403);
    }

    public function test_search_filter_works(): void
    {
        $this->actingAs($this->admin);

        Trainer::factory()->create();
        $target = Trainer::factory()->create();
        $target->user->update(['name' => 'UniqueTrainerName']);

        $response = $this->get(route('admin.trainers.index', ['search' => 'UniqueTrainerName']));

        $response->assertStatus(200);
        $response->assertSee('UniqueTrainerName');
    }

    public function test_status_filter_works(): void
    {
        $this->actingAs($this->admin);

        Trainer::factory()->active()->create();
        Trainer::factory()->inactive()->create();
        Trainer::factory()->suspended()->create();

        $response = $this->get(route('admin.trainers.index', ['status' => 'active']));

        $response->assertStatus(200);
    }

    public function test_unauthorized_user_cannot_manage_trainers(): void
    {
        $memberUser = User::factory()->create(['role' => MemberRole::Member]);
        $this->actingAs($memberUser);

        $this->get(route('admin.trainers.index'))->assertStatus(403);
    }

    public function test_admin_can_create_trainer_with_profile_photo(): void
    {
        Storage::fake('public');

        $this->actingAs($this->admin);

        $file = UploadedFile::fake()->image('trainer.jpg', 200, 200);

        $response = $this->post(route('admin.trainers.store'), [
            'first_name' => 'Photo',
            'last_name' => 'Trainer',
            'email' => 'photo@example.com',
            'profile_photo' => $file,
        ]);

        $response->assertRedirect();

        $user = User::where('email', 'photo@example.com')->first();
        $trainer = Trainer::where('user_id', $user->id)->first();

        $this->assertNotNull($trainer->profile_photo_path);
        Storage::disk('public')->assertExists($trainer->profile_photo_path);
    }

    public function test_invalid_profile_photo_upload_is_rejected(): void
    {
        $this->actingAs($this->admin);

        $file = UploadedFile::fake()->create('document.pdf', 500);

        $response = $this->post(route('admin.trainers.store'), [
            'first_name' => 'Bad',
            'last_name' => 'Photo',
            'email' => 'bad@example.com',
            'profile_photo' => $file,
        ]);

        $response->assertSessionHasErrors(['profile_photo']);
    }
}
