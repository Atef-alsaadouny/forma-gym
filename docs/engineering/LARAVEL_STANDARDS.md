# LARAVEL_STANDARDS.md

# Laravel Standards

> Scope: Reusable Laravel standard

## Purpose

This file defines Laravel-specific rules for structure and implementation.

## Controllers

Controllers should be thin.
They should receive requests, call services, and return responses.

## Services

Business logic belongs in Services.

Example:

```text
app/Services/SubscriptionService.php
```

## Validation

Use Form Requests for validation.

Never place large validation arrays directly inside controllers.

## Authorization

Use Policies and Gates.

Avoid manual role checks inside controllers.

## Models

Models should contain relationships, casts, scopes, and simple model behavior.
Do not turn models into huge service classes.

## Routes

Group routes by domain and middleware.
Name routes clearly.

## Final Principle

Use Laravel conventions unless there is a strong reason not to.
