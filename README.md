# Forma Gym Management System

Arabic-first gym management platform with public subscription registration, booking lookup, and admin management of members, trainers, packages, subscriptions, and attendance.

Built for a single gym in Kuwait and architected for future multi-tenant SaaS expansion.

## Features

### Implemented

- **Public Website** — Home, CrossFit schedule, FAQ, rules, virtual tour, trainer profiles
- **Subscription Registration** — 5 pricing plans, trainer add-ons, locker add-on, Kuwaiti phone validation (Cash only)
- **Subscription Lookup** — Search by booking reference (`FOG` prefix + 5-digit ID) + phone
- **Locale Switching** — Arabic (`ar`) default with English (`en`) fallback, RTL/LTR layout
- **Admin Dashboard** — Full CRUD for members, trainers, packages, subscriptions, attendance
- **Authentication** — Login, registration, password reset, role-based authorization
- **Authorization** — Policies for all resources; roles: owner, admin, manager, receptionist, trainer, member
- **Attendance Tracking** — Check-in/check-out with duplicate prevention
- **Booking Reference System** — Auto-generated `FOG` + zero-padded ID for public registrations
- **PWA Support** — Service worker, manifest, offline page for public pages
- **SEO** — Sitemap, robots.txt, JSON-LD schema (`HealthClub`), Google Search Console verification
- **Content Security Policy** — CSP middleware with OpenStreetMap iframe support
- **Public Page Caching** — Cache headers on public pages
- **Validation** — Form Request validation, inline error display, Arabic numeral normalization
- **Phone Deduplication** — Active/pending subscriptions block duplicate registration
- **Translation System** — `__()` helper across `messages.*` and `validation.*` namespaces for `ar`/`en`
- **114 Passing Tests**

### Future

- Online payments
- Member/Trainer dashboards
- Workout programs & measurements
- Notifications & reports
- Multi-branch & multi-gym (SaaS)
- QR check-in

## Technology Stack

| Layer | Technology |
|---|---|
| **Backend** | Laravel 12, PHP 8.2+ |
| **Frontend** | Blade, Tailwind CSS 4, Alpine.js 3, Swiper 14 |
| **Database** | MySQL 8 (local) / Aiven Cloud MySQL (production) |
| **Auth** | Laravel Authentication, Sanctum, Policies |
| **Assets** | Vite 7, `@tailwindcss/vite` plugin |
| **Testing** | PHPUnit 11, Laravel Pint |
| **Container** | Docker (single Dockerfile) |
| **Deployment** | Render (via `render.yaml`) |

## Architecture

- **MVC + Service Layer** — Thin controllers delegate business logic to Services
- **Form Requests** — All validation extracted from controllers
- **Policies** — Role-based authorization for every resource
- **Multi-tenant Ready** — `gym_id` on all business tables; `HasGymAndBranch` trait for future multi-branch
- **Locale-first** — Arabic default (`ar`), English (`en`) via session-based locale switching
- **Color System** — All `gym-*` CSS tokens defined in `resources/css/app.css` via `@theme`

## Folder Structure

```
app/
├── Enums/              # MemberRole, SubscriptionStatus, TrainerStatus, etc.
├── Exceptions/         # BaseServiceException, BusinessRuleException, NotFoundException
├── Helpers/            # PhoneHelper
├── Http/
│   ├── Controllers/    # Admin/, Auth/, Member/, Public/
│   ├── Middleware/      # SetLocale, CheckRole, CachePublicPages, ContentSecurityPolicy
│   └── Requests/       # Admin/, Auth/, Member/, Public/, Trainer/
├── Models/             # 10 Eloquent models
├── Policies/           # Authorization policies for all resources
├── Services/           # Business logic layer (7 active services + 3 stubs)
└── Traits/             # HasGymAndBranch

resources/
├── views/              # Blade: admin/, auth/, components/, layouts/, public/, member/
├── css/app.css         # Tailwind v4 with @theme tokens
└── js/                 # Alpine.js, Swiper, navbar/trainer interactions

docs/
├── engineering/        # Reusable engineering standards
└── project/            # Project vision, business rules, architecture decisions
```

## Requirements

- PHP 8.2+
- Composer 2
- Node.js 18+
- MySQL 8
- Vite (for frontend)

## Installation

```bash
# 1. Clone and install
git clone <repo-url> && cd Gym
composer install
npm install

# 2. Environment
cp .env.example .env
php artisan key:generate

# 3. Database
mysql -u root -p -e "CREATE DATABASE forma_gym"
php artisan migrate
php artisan db:seed

# 4. Storage
php artisan storage:link

# 5. Build assets
npm run build

# 6. Start
php artisan serve
# In another terminal:
npm run dev
```

## Environment Variables

```env
APP_NAME="Forma Gym"
APP_ENV=local
APP_DEBUG=true
APP_URL=http://localhost

APP_LOCALE=ar
APP_FALLBACK_LOCALE=en

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=forma_gym
DB_USERNAME=root
DB_PASSWORD=

SESSION_DRIVER=file
CACHE_STORE=file
QUEUE_CONNECTION=sync
MAIL_MAILER=log
```

## Default Credentials (local only)

- **Admin:** `admin@formagym.com` / `password` (after running `db:seed`)
- **Member registration:** Public registration via the website (no pre-seeded members)

## Testing

```bash
# All tests
php artisan test

# Specific test suite
php artisan test --filter=PublicBookingFlowTest
php artisan test --filter=Admin

# Code style
php vendor/bin/pint
```

## Deployment (Render)

The project deploys via `render.yaml` using Docker. Key steps:

1. Set `APP_KEY` in Render Dashboard env vars
2. Configure Aiven Cloud MySQL credentials in Dashboard
3. Ensure `APP_DEBUG=false` in production
4. The Docker startup script handles `.env` creation, key generation, migrations, and caching

## Code Standards

- Strict typing (`declare(strict_types=1)`) on all files
- Controllers are thin; business logic in Services
- Validation in Form Requests
- Authorization in Policies
- `gym-*` CSS tokens only — no hardcoded color values in Blade
- `__()` helper for all user-facing strings
- Logical CSS properties (`start`/`end`, `ms-*`/`me-*`) for RTL support

## License

This project is private and proprietary unless otherwise stated.
