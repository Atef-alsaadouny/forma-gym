<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Enums\MemberRole;
use App\Enums\MemberStatus;
use App\Enums\SubscriptionStatus;
use App\Models\Gym;
use App\Models\Member;
use App\Models\Package;
use App\Models\Subscription;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PublicBookingFlowTest extends TestCase
{
    use RefreshDatabase;

    private function createSubscription(array $overrides = []): Subscription
    {
        $gym = Gym::firstOrCreate(['slug' => 'default'], ['name' => 'Test Gym', 'is_active' => true]);

        $user = User::create([
            'name' => $overrides['name'] ?? 'Test User',
            'email' => 'test_'.time().'@gym.com',
            'password' => bcrypt('password'),
            'phone' => $overrides['phone'] ?? '55123456',
            'role' => MemberRole::Member,
            'is_active' => true,
        ]);

        $member = Member::create([
            'user_id' => $user->id,
            'gym_id' => $gym->id,
            'status' => MemberStatus::Active,
            'joined_at' => now(),
        ]);

        $package = Package::create([
            'gym_id' => $gym->id,
            'name' => $overrides['plan_name'] ?? 'شهر',
            'duration_days' => 30,
            'price' => 29.0,
            'is_active' => true,
        ]);

        return Subscription::create([
            'member_id' => $member->id,
            'package_id' => $package->id,
            'gym_id' => $gym->id,
            'start_date' => now()->startOfDay(),
            'end_date' => now()->startOfDay()->addDays(30),
            'status' => SubscriptionStatus::Active,
            'price_paid' => 29.0,
            'package_snapshot' => [
                'name' => $overrides['plan_name'] ?? 'شهر',
                'duration_days' => 30,
                'base_price' => 29.0,
            ],
            'addons' => $overrides['addons'] ?? null,
            'notes' => 'تسجيل عبر الموقع',
        ]);
    }

    // ── Registration Page ──

    public function test_registration_page_renders(): void
    {
        $response = $this->get(route('subscription.register'));

        $response->assertStatus(200);
        $response->assertSee('register-form');
    }

    public function test_registration_page_with_plan_query_params(): void
    {
        $response = $this->get(route('subscription.register', [
            'plan' => 'شهر',
            'price' => 29,
            'duration' => 30,
        ]));

        $response->assertStatus(200);
    }

    // ── Registration Store ──

    public function test_registration_with_valid_data_succeeds(): void
    {
        $response = $this->post(route('subscription.register.store'), [
            'name' => 'أحمد علي',
            'phone' => '55123456',
            'plan' => 'شهر',
            'price' => 29,
            'duration' => 30,
        ]);

        $response->assertStatus(200);
        $response->assertSee('FOG');

        $this->assertDatabaseHas('users', ['phone' => '55123456']);
        $this->assertDatabaseHas('subscriptions', [
            'status' => SubscriptionStatus::Active,
            'price_paid' => 29.0,
        ]);
    }

    public function test_registration_with_trainer_addon(): void
    {
        $response = $this->post(route('subscription.register.store'), [
            'name' => 'محمد حسن',
            'phone' => '66123456',
            'trainer_id' => 1,
            'plan' => 'شهر',
            'price' => 29,
            'duration' => 30,
        ]);

        $response->assertStatus(200);

        $subscription = Subscription::first();
        $this->assertEquals(49.0, $subscription->price_paid);
        $this->assertNotNull($subscription->addons);
    }

    public function test_registration_with_locker_addon(): void
    {
        $response = $this->post(route('subscription.register.store'), [
            'name' => 'سارة علي',
            'phone' => '95123456',
            'locker' => true,
            'plan' => 'شهر',
            'price' => 29,
            'duration' => 30,
        ]);

        $response->assertStatus(200);

        $subscription = Subscription::first();
        $this->assertEquals(34.0, $subscription->price_paid);
    }

    public function test_registration_rejects_invalid_phone(): void
    {
        $response = $this->post(route('subscription.register.store'), [
            'name' => 'أحمد علي',
            'phone' => '123',
            'plan' => 'شهر',
            'price' => 29,
            'duration' => 30,
        ]);

        $response->assertSessionHasErrors('phone');
    }

    public function test_registration_rejects_missing_name(): void
    {
        $response = $this->post(route('subscription.register.store'), [
            'phone' => '55123456',
            'plan' => 'شهر',
            'price' => 29,
            'duration' => 30,
        ]);

        $response->assertSessionHasErrors('name');
    }

    public function test_registration_rejects_invalid_plan(): void
    {
        $response = $this->post(route('subscription.register.store'), [
            'name' => 'أحمد علي',
            'phone' => '55123456',
            'plan' => '',
            'price' => 29,
            'duration' => 30,
        ]);

        $response->assertSessionHasErrors('plan');
    }

    public function test_registration_creates_booking_ref_with_fog_prefix(): void
    {
        $response = $this->post(route('subscription.register.store'), [
            'name' => 'أحمد علي',
            'phone' => '55123456',
            'plan' => 'شهر',
            'price' => 29,
            'duration' => 30,
        ]);

        $response->assertStatus(200);
        $response->assertSee('FOG00001');
    }

    // ── Active Subscription Guard ──

    public function test_registration_rejects_phone_with_active_subscription(): void
    {
        $this->createSubscription(['phone' => '55123456']);

        $response = $this->post(route('subscription.register.store'), [
            'name' => 'أحمد علي',
            'phone' => '55123456',
            'plan' => 'شهر',
            'price' => 29,
            'duration' => 30,
        ]);

        $response->assertSessionHasErrors('phone');
    }

    public function test_registration_rejects_phone_with_pending_subscription(): void
    {
        $this->createSubscription(['phone' => '66123456']);

        $response = $this->post(route('subscription.register.store'), [
            'name' => 'سارة علي',
            'phone' => '66123456',
            'plan' => 'شهر',
            'price' => 29,
            'duration' => 30,
        ]);

        $response->assertSessionHasErrors('phone');
    }

    public function test_registration_allows_phone_with_expired_subscription(): void
    {
        $subscription = $this->createSubscription(['phone' => '95123456']);
        $subscription->update([
            'status' => SubscriptionStatus::Expired,
            'end_date' => now()->subDays(10)->startOfDay(),
        ]);

        $response = $this->post(route('subscription.register.store'), [
            'name' => 'ليلى خالد',
            'phone' => '95123456',
            'plan' => 'شهر',
            'price' => 29,
            'duration' => 30,
        ]);

        $response->assertStatus(200);
        $response->assertSee('FOG');
    }

    public function test_registration_allows_phone_with_cancelled_subscription(): void
    {
        $subscription = $this->createSubscription(['phone' => '44123456']);
        $subscription->update([
            'status' => SubscriptionStatus::Cancelled,
            'end_date' => now()->subDays(5)->startOfDay(),
        ]);

        $response = $this->post(route('subscription.register.store'), [
            'name' => 'محمد حسن',
            'phone' => '44123456',
            'plan' => 'شهر',
            'price' => 29,
            'duration' => 30,
        ]);

        $response->assertStatus(200);
        $response->assertSee('FOG');
    }

    // ── Subscription Lookup ──

    public function test_lookup_page_renders(): void
    {
        $response = $this->get(route('subscription.lookup'));

        $response->assertStatus(200);
        $response->assertSee('lookup-form');
    }

    public function test_lookup_with_valid_reference_succeeds(): void
    {
        $subscription = $this->createSubscription(['phone' => '55123456']);
        $ref = 'FOG'.str_pad((string) $subscription->id, 5, '0', STR_PAD_LEFT);

        $response = $this->post(route('subscription.lookup.store'), [
            'booking_ref' => $ref,
            'phone' => '55123456',
        ]);

        $response->assertStatus(200);
        $response->assertSee($ref);
    }

    public function test_lookup_with_invalid_reference_fails(): void
    {
        $response = $this->post(route('subscription.lookup.store'), [
            'booking_ref' => 'FOG99999',
            'phone' => '55123456',
        ]);

        $response->assertStatus(200);
        $response->assertSee('error');
    }

    public function test_lookup_with_wrong_phone_fails(): void
    {
        $subscription = $this->createSubscription(['phone' => '55123456']);
        $ref = 'FOG'.str_pad((string) $subscription->id, 5, '0', STR_PAD_LEFT);

        $response = $this->post(route('subscription.lookup.store'), [
            'booking_ref' => $ref,
            'phone' => '99999999',
        ]);

        $response->assertStatus(200);
        $response->assertSee('error');
    }

    public function test_lookup_rejects_non_fog_prefix(): void
    {
        $response = $this->post(route('subscription.lookup.store'), [
            'booking_ref' => 'ABC12345',
            'phone' => '55123456',
        ]);

        $response->assertStatus(200);
        $response->assertSee('error');
    }

    public function test_lookup_rejects_empty_fields(): void
    {
        $response = $this->post(route('subscription.lookup.store'), [
            'booking_ref' => '',
            'phone' => '',
        ]);

        $response->assertSessionHasErrors(['booking_ref', 'phone']);
    }

    // ── Locale Switching ──

    public function test_locale_switch_to_english(): void
    {
        $response = $this->get('/locale/en');

        $response->assertRedirect();
        $this->assertEquals('en', session('locale'));
    }

    public function test_locale_switch_to_arabic(): void
    {
        $response = $this->get('/locale/ar');

        $response->assertRedirect();
        $this->assertEquals('ar', session('locale'));
    }

    public function test_locale_switch_rejects_invalid_locale(): void
    {
        $response = $this->get('/locale/fr');

        $response->assertStatus(400);
    }

    // ── Public Pages ──

    public function test_home_page_renders(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    public function test_crossfit_page_renders(): void
    {
        $response = $this->get('/crossfit');

        $response->assertStatus(200);
    }

    public function test_faq_page_renders(): void
    {
        $response = $this->get('/faq');

        $response->assertStatus(200);
    }

    public function test_rules_page_renders(): void
    {
        $response = $this->get('/rules');

        $response->assertStatus(200);
    }

    public function test_about_redirects_to_home(): void
    {
        $response = $this->get('/about');

        $response->assertRedirect('/#features');
    }

    public function test_contact_redirects_to_home(): void
    {
        $response = $this->get('/contact');

        $response->assertRedirect('/#contact');
    }

    // ── Cache Headers ──

    public function test_home_page_has_cache_headers(): void
    {
        $response = $this->get('/');

        $response->assertHeader('Cache-Control');
    }

    public function test_crossfit_page_has_cache_headers(): void
    {
        $response = $this->get('/crossfit');

        $response->assertHeader('Cache-Control');
    }

    // ── Registration with Arabic numerals ──

    public function test_registration_with_arabic_numerals_normalizes_phone(): void
    {
        $response = $this->post(route('subscription.register.store'), [
            'name' => 'أحمد علي',
            'phone' => '٥٥١٢٣٤٥٦',
            'plan' => 'شهر',
            'price' => 29,
            'duration' => 30,
        ]);

        $response->assertStatus(200);
        $this->assertDatabaseHas('users', ['phone' => '55123456']);
    }
}
