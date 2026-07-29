# DATABASE_STANDARDS.md

# Database Standards

> Scope: Reusable engineering standard

## Purpose

This file defines how database tables, columns, indexes, and relationships must be designed.

## Table Naming

- Use plural snake_case table names.
- Examples: `members`, `subscriptions`, `attendance_records`.

## Column Naming

- Use snake_case.
- Foreign keys must follow Laravel convention: `user_id`, `branch_id`, `gym_id`.

## Primary Keys

- Use `id` as the primary key by default.
- Keep UUID support possible for public-facing entities later.

## Timestamps

Use:

```php
$table->timestamps();
```

Use soft deletes when business recovery is needed:

```php
$table->softDeletes();
```

## Indexes

Add indexes for:

- Foreign keys
- Search fields
- Status fields used frequently
- Date filters used in reports

## Relationships

Define database relationships clearly in migrations and Eloquent models.

## Final Principle

The database must protect business truth, not only store data.
