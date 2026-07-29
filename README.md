# Forma Gym Management System

A modern, production-ready Gym Management Platform built with Laravel 12.

## Tech Stack

- **Backend:** Laravel 12, PHP 8.2+
- **Frontend:** Blade, Tailwind CSS 4, Alpine.js
- **Database:** PostgreSQL 16
- **DevOps:** Docker, GitHub Actions

## Requirements

- PHP 8.2+
- Composer
- Node.js 18+
- PostgreSQL 16
- Docker (optional)

## Setup

```bash
# Install dependencies
composer install
npm install

# Environment
cp .env.example .env
php artisan key:generate

# Database
php artisan migrate
php artisan db:seed

# Build assets
npm run build

# Start development
php artisan serve
npm run dev
```

## Docker

```bash
docker compose -f docker/docker-compose.yml up -d
```

## Default Admin

- Email: admin@powergym.com
- Password: password

## Testing

```bash
php artisan test
```
