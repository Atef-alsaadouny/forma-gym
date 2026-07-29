# PERFORMANCE_GUIDELINES.md

# Performance Guidelines

> Scope: Reusable performance standard

## Purpose

This file defines how performance must be considered during development.

## Rules

- Avoid N+1 queries.
- Use eager loading when needed.
- Add indexes for frequent filters.
- Paginate large datasets.
- Cache stable data.
- Optimize images.
- Avoid heavy work during user requests.

## Queues

Use queues for:

- Emails
- Notifications
- Reports
- Exports
- Image processing

## Final Principle

Performance problems are cheaper to prevent than to fix after launch.
