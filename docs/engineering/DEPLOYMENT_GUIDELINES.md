# DEPLOYMENT_GUIDELINES.md

# Deployment Guidelines

> Scope: Reusable deployment standard

## Purpose

This file defines safe deployment practices.

## Before Deployment

Run:

```bash
php artisan test
php artisan pint
npm run build
```

Backup the database before migrations.

## Production Settings

- `APP_DEBUG=false`
- HTTPS enabled
- Strong `APP_KEY`
- Secrets stored only in environment variables

## After Deployment

Run smoke tests.
Check logs.
Verify critical pages.

## Final Principle

Production is never the place to test code.
