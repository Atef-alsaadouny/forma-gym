# SYSTEM_ARCHITECTURE.md

# System Architecture

## Stack

- Laravel
- Blade
- Tailwind CSS
- Alpine.js when needed
- MySQL
- Docker
- Render

## Architecture Style

- MVC with clean service layer
- Thin controllers
- Form Requests for validation
- Policies for authorization
- Eloquent relationships
- Component-based UI

## Multi-Tenant Readiness

The first release is Single Gym, but core tables should be ready for future `gym_id` support where appropriate.

## Final Principle

Architecture should support growth without making the first version unnecessarily complex.
