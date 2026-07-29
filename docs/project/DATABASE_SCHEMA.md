# DATABASE_SCHEMA.md

# Database Schema Direction

## Core Tables

- gyms
- gym_settings
- branches
- users
- members
- trainers
- employees
- packages
- subscriptions
- attendance_records
- workout_programs
- exercises
- measurements
- announcements
- notifications

## Multi-Tenant Readiness

Business tables should be designed so `gym_id` can be used now or added later with minimal refactoring.

## Example

```text
gyms
├── branches
├── members
├── trainers
├── packages
└── subscriptions
```

## Final Principle

The schema must describe the business clearly and protect data consistency.
