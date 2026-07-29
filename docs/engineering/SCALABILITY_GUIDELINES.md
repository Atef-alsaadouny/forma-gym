# SCALABILITY_GUIDELINES.md

# Scalability Guidelines

> Scope: Reusable scalability standard

## Purpose

This file defines how systems should be designed for future growth without over-engineering.

## Rules

- Avoid hardcoding business data.
- Keep business logic isolated.
- Design database relationships carefully.
- Keep storage paths flexible.
- Use services for domain logic.
- Use cache keys that can scale.
- Keep future multi-tenant support possible when relevant.

## Warning

Scalability does not mean building every future feature today.
It means avoiding decisions that block future growth.

## Final Principle

Build today's solution with tomorrow's architecture in mind.
