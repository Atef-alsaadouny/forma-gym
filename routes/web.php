<?php

declare(strict_types=1);

use App\Http\Controllers\Admin\MemberController;
use App\Http\Controllers\Admin\AttendanceController;
use App\Http\Controllers\Admin\PackageController;
use App\Http\Controllers\Admin\SubscriptionController;
use App\Http\Controllers\Admin\TrainerController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Member\MemberDashboardController;
use App\Http\Controllers\Public\HomeController;
use App\Http\Controllers\Public\SitemapController;
use App\Http\Controllers\Public\SubscriptionLookupController;
use App\Http\Controllers\Public\SubscriptionRegisterController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;

Route::view('/offline', 'public.offline')->name('offline');

Route::get('/robots.txt', function () {
    $sitemap = url('/sitemap.xml');

    return response("User-agent: *\nAllow: /\n\nSitemap: {$sitemap}\n", 200, [
        'Content-Type' => 'text/plain',
    ]);
})->name('robots');

Route::get('/sitemap.xml', SitemapController::class)->name('sitemap');

Route::get('/locale/{locale}', function (string $locale) {
    if (! in_array($locale, ['ar', 'en'], true)) {
        abort(400);
    }

    Session::put('locale', $locale);

    return redirect()->back();
})->name('locale.switch');

Route::middleware('cache.public')->group(function () {
    Route::get('/', [HomeController::class, 'index'])->name('home');
    Route::get('/about', [HomeController::class, 'about'])->name('about');
    Route::get('/contact', [HomeController::class, 'contact'])->name('contact');
    Route::view('/rules', 'public.rules')->name('rules');
    Route::view('/faq', 'public.faq')->name('faq');
    Route::view('/crossfit', 'public.crossfit')->name('crossfit');
});

Route::get('/subscription/register', [SubscriptionRegisterController::class, 'create'])->name('subscription.register');
Route::post('/subscription/register', [SubscriptionRegisterController::class, 'store'])->name('subscription.register.store')->middleware('throttle:5,1');

Route::get('/subscription/lookup', [SubscriptionLookupController::class, 'create'])->name('subscription.lookup');
Route::post('/subscription/lookup', [SubscriptionLookupController::class, 'store'])->name('subscription.lookup.store')->middleware('throttle:10,1');

Route::middleware('guest')->group(function () {
    Route::get('register', [RegisteredUserController::class, 'create'])->name('register');
    Route::post('register', [RegisteredUserController::class, 'store']);

    Route::get('login', [AuthenticatedSessionController::class, 'create'])->name('login');
    Route::post('login', [AuthenticatedSessionController::class, 'store']);

    Route::get('forgot-password', [PasswordResetLinkController::class, 'create'])->name('password.request');
    Route::post('forgot-password', [PasswordResetLinkController::class, 'store'])->name('password.email');

    Route::get('reset-password/{token}', [NewPasswordController::class, 'create'])->name('password.reset');
    Route::post('reset-password', [NewPasswordController::class, 'store'])->name('password.store');
});

Route::middleware('auth')->group(function () {
    Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');

    Route::middleware('role:member')->group(function () {
        Route::get('/dashboard', [MemberDashboardController::class, 'index'])->name('member.dashboard');
    });

    Route::prefix('admin')->name('admin.')->middleware('role:owner,admin,manager,receptionist,trainer')->group(function () {
        Route::resource('members', MemberController::class)
            ->only(['index', 'create', 'store', 'show', 'edit', 'update', 'destroy']);

        Route::resource('trainers', TrainerController::class)
            ->only(['index', 'create', 'store', 'show', 'edit', 'update', 'destroy']);

        Route::resource('packages', PackageController::class)
            ->only(['index', 'create', 'store', 'show', 'edit', 'update', 'destroy']);

        Route::get('/subscriptions/public', [SubscriptionController::class, 'publicRegistrations'])
            ->name('subscriptions.public');

        Route::resource('subscriptions', SubscriptionController::class)
            ->only(['index', 'create', 'store', 'show', 'edit', 'update', 'destroy']);

        Route::resource('attendance', AttendanceController::class)
            ->only(['index', 'create', 'store', 'show', 'edit', 'update', 'destroy']);
        Route::post('attendance/{record}/check-out', [AttendanceController::class, 'checkOut'])
            ->name('attendance.check-out');

        Route::get('/workout-plans', function () {
            return redirect()->route('admin.subscriptions.index');
        })->name('workout-plans.index');

        Route::get('/reports', function () {
            return redirect()->route('admin.subscriptions.index');
        })->name('reports.index');

        Route::get('/branches', function () {
            return redirect()->route('admin.subscriptions.index');
        })->name('branches.index');

        Route::get('/settings', function () {
            return redirect()->route('admin.subscriptions.index');
        })->name('settings.index');
    });
});
