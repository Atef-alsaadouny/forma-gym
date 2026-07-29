# TESTING_GUIDELINES.md

# Testing Guidelines

> Scope: Reusable testing standard

## Purpose

Testing prevents production bugs and protects business rules.

## Philosophy

Test business behavior.
Do not test the framework itself.

## Required Tests

Feature tests are required for:

- Authentication
- Authorization
- CRUD actions
- Validation
- Business rules
- Payment or subscription logic

## Unit Tests

Use unit tests for:

- Calculations
- Services
- Helpers
- Reports

## Database

Use isolated test data.
Never depend on production data.

## Final Principle

When a bug is found, write a failing test first, then fix it.
