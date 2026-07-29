# Code Cleanup Report

**Date:** 2026-07-30

## Initial Project Condition

The project was functional (114 passing tests) but contained:
- Dead/unused code files
- Unused imports
- Empty `messages()` methods
- Duplicate logic copy-pasted across 6+ service classes
- Inconsistent success message formatting (mixed `__()` and plain strings)
- Redundant route file
- Placeholder service stubs
- Outdated README referencing wrong database and credentials

## Files Reviewed

All 115+ PHP files across:
- `app/` (Controllers, Models, Services, Requests, Policies, Middleware, Exceptions, Traits, Enums, Providers)
- `bootstrap/`
- `config/`
- `database/` (migrations, seeders, factories)
- `routes/`
- `tests/`
- `resources/` (views, JS, CSS)
- `docs/` (engineering + project documentation)

## Files Removed

| File | Reason |
|------|--------|
| `app/Http/Requests/Auth/RegisterRequest.php` | **Dead code** — `RegisteredUserController::store()` does inline `$request->validate()`, never referenced this class |
| `app/Services/GymService.php` | **Unused** — `getActiveGym()` and `getSettings()` never called by any controller or service |
| `app/Services/SettingsService.php` | **Unused** — `get()` and `set()` never called by any controller or service |
| `routes/auth.php` | **Redundant** — contained only a comment saying "Auth routes are defined in web.php". Laravel auto-loads it but it's empty |

### Files Added

| File | Purpose |
|------|---------|
| `app/Helpers/PhoneHelper.php` | Shared `normalizeArabicNumerals()` extracted from 2 classes into 1 static helper |
| `docs/CODE_CLEANUP_REPORT.md` | This report |

## Unused Dependencies

No Composer or NPM packages were removed.

## Duplicate Code Removed / Refactored

### 1. `getDefaultGymId()` — 6 copies → 1

Extracted into `BaseService` (line 25). Removed private methods from:
- `MemberService`
- `PackageService`
- `SubscriptionService`
- `AttendanceService`
- `TrainerService`
- `SubscriptionRegistrationService` (now extends `BaseService`)

### 2. `normalizeArabicNumerals()` — 2 copies → 1 shared helper

Extracted into `App\Helpers\PhoneHelper::normalizeArabicNumerals()`.
Both `StoreSubscriptionRegistrationRequest` and `SubscriptionLookupController` now call the shared helper.

## Major Refactoring Performed

### SubscriptionRegistrationService now extends BaseService
- Gains access to `getDefaultGymId()`, `logError()`, `logInfo()`
- Removed its private duplicate `getDefaultGymId()`

### Success Message Standardization
- `MemberController` — changed 3 plain strings to `__()` wrappers
- `TrainerController` — changed 3 plain strings to `__()` wrappers
- All admin controllers now use `__()` consistently for flash messages

## Security Improvements

- None required — existing CSP, CSRF, validation, and policies were already correct
- Removed `TrustProxies` unused import from `bootstrap/app.php`

## Performance Improvements

- Removed unused service instantiations (no longer loading `GymService` or `SettingsService` via DI)
- No N+1 queries were introduced or removed

## Unused Imports Removed

| File | Removed Import |
|------|----------------|
| `app/Http/Controllers/Admin/AttendanceController.php` | `Illuminate\Http\Request` |
| `app/Http/Requests/Member/UpdateMemberRequest.php` | `App\Enums\MemberRole`, `App\Models\Member` |
| `app/Http/Requests/Member/StoreMemberRequest.php` | `App\Enums\MemberRole` |
| `app/Http/Requests/Trainer/UpdateTrainerRequest.php` | `App\Enums\MemberRole` |
| `app/Http/Requests/Trainer/StoreTrainerRequest.php` | `App\Enums\MemberRole` |
| `app/Models/Trainer.php` | `Illuminate\Database\Eloquent\Relations\HasMany` |
| `bootstrap/app.php` | `Illuminate\Http\Middleware\TrustProxies` |

## Code Style (Pint)

27 files auto-fixed by Laravel Pint:
- `not_operator_with_successor_space`, `concat_space`, `ordered_imports`
- `fully_qualified_strict_types`, `ordered_traits`, `class_attributes_separation`
- `braces_position`, `unary_operator_spaces`, `single_line_empty_body`, `no_unused_imports`

## Tests Added or Updated

No new tests added. Existing 114 tests continue to pass with no modifications.

## Test Results

**114 tests passed (318 assertions)** — both before and after all changes.

## Items Kept Despite Uncertain Usage

| Item | Reason Kept |
|------|-------------|
| `WorkoutProgramService`, `MeasurementService`, `NotificationService` | Documented as future stubs in project docs; intentional placeholder |
| `MemberService::restore()`, `forceDelete()`, `updateStatus()` | Future-ready API methods — not routed yet but logically complete |
| `TrainerService::restore()`, `forceDelete()`, `updateStatus()` | Same — future-ready |
| `SubscriptionService::activate()`, `cancel()` | Same — future-ready |
| `Subscription::scopeExpiringSoon()`, `scopeExpired()` | Model scopes for future reporting |
| Empty directories (`Actions/`, `DTOs/`, `Events/`, `Jobs/`, `Notifications/`, `Resources/`, `Dashboard/`, `Services/Admin/`, etc.) | Documented as placeholders in `FOLDER_STRUCTURE.md` |
| `BusinessRuleException`, `NotFoundException`, `BaseServiceException` | Exception hierarchy built for future service layer; harmless |
| `ContentSecurityPolicy` middleware applied to admin routes | Slight overhead but intentional security measure |
| `CheckRole` middleware logging user role | Low risk (dev environments); documented in audit |
| `routes/web.php` placeholder redirects for workout-plans, reports, branches, settings | Placeholder routes for future modules — documented |

## Remaining Technical Debt

1. **Database docs outdated** — `docs/project/DATABASE_SCHEMA.md` references tables (workout_programs, exercises, measurements, announcements, notifications) that have no migrations
2. **Doc vs reality mismatches** — Several `docs/project/` files claim PostgreSQL; actual DB is MySQL
3. **`Member::with('user')->get()->sortBy('user.name')** — Loads all members into memory; should use query-level ordering + pagination (used in 4 controllers)
4. **Empty `messages()` in `StoreSubscriptionRegistrationRequest` removed** — was harmless but unnecessary; relies on `validation.php` now
5. **No admin seeder** — Production DB has no admin user; setup must be done manually or via tinker

## Recommended Future Improvements

1. Seed admin user (`admin@formagym.com`) via a dedicated seeder for production
2. Migrate `Member::with('user')->get()->sortBy('user.name')` to query-level ordering
3. Online payment integration (KNET, etc.)
4. Phone normalization in `SubscriptionLookupController` to strip `+965`/`00965` prefixes
5. Generate proper 192×192 / 512×512 PNG icons for full PWA compliance
6. Add `workflow` scope to GitHub token for CI restoration
7. Update `docs/project/DATABASE_SCHEMA.md` to reflect actual migrated tables
8. Consider removing `ContentSecurityPolicy` from admin routes or making it route-specific
