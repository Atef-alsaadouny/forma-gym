# CODING_STANDARDS.md

# Coding Standards

> Scope: Reusable engineering standard

## Purpose

This file defines how code must be written across projects.

## General Rules

- Code must be readable before being clever.
- Use meaningful names.
- Keep functions small and focused.
- Avoid duplicated logic.
- Avoid magic numbers and hardcoded business values.
- Never leave debugging code in production.

## PHP Rules

- Use strict typing when appropriate.
- Follow PSR standards.
- Use Laravel Pint for formatting.
- Prefer early returns over deep nesting.
- Use dependency injection where useful.

## Bad Example

```php
if ($u->r == 1) {
    // ...
}
```

## Good Example

```php
if ($user->hasRole('admin')) {
    // ...
}
```

## Final Principle

Code should explain itself through names, structure, and clear responsibility.
