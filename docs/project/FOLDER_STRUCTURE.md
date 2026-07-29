# FOLDER_STRUCTURE.md

# Folder Structure

## Application Structure

```text
app/
├── Enums/                  # Domain enums (MemberRole, SubscriptionStatus, AttendanceType)
├── Events/                 # Domain events (placeholder)
├── Exceptions/             # Custom exception classes
├── Http/
│   ├── Controllers/
│   │   ├── Admin/          # Admin controllers (placeholder)
│   │   ├── Auth/           # Authentication controllers
│   │   ├── Member/         # Member dashboard controllers
│   │   └── Public/         # Public website controllers
│   ├── Middleware/          # Custom middleware (CheckRole)
│   └── Requests/           # Form Requests (Auth/ namespace)
├── Jobs/                   # Queued jobs (placeholder)
├── Models/                 # Eloquent models
├── Notifications/          # Notifications (placeholder)
├── Policies/               # Authorization policies
├── Services/               # Business logic layer
│   ├── Admin/              # Admin services (placeholder)
│   ├── Member/             # Member services (placeholder)
│   └── Shared/             # Shared services (placeholder)
└── Traits/                 # Reusable traits (HasGymAndBranch)
```

## Views

```text
resources/views/
├── layouts/                # Base, Guest, Auth layouts
├── components/             # Reusable Blade components
├── public/                 # Public website pages
├── auth/                   # Auth pages (login, register, etc.)
├── member/                 # Member dashboard
├── trainer/                # Trainer views (placeholder)
└── admin/                  # Admin views (placeholder)
```

## Docker

```text
docker/
├── Dockerfile              # PHP-FPM container
├── docker-compose.yml      # App + PostgreSQL + Nginx
├── nginx/
│   └── default.conf
└── php/
    └── php.ini
```

## Documentation

```text
docs/
├── engineering/            # Shared engineering standards
└── project/                # Project-specific documentation
```

## Final Principle

Folder structure must make the project easy to understand before reading the code.
