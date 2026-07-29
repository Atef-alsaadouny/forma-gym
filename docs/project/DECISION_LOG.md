# DECISION_LOG.md

# Decision Log

## Decision 001: Single Gym First

The first version will serve one gym only.

## Reason

This allows faster delivery while keeping architecture ready for SaaS expansion.

## Decision 002: Multi-Tenant Ready Design

Tables, storage, settings, and services should avoid assumptions that only one gym will exist forever.

## Decision 003: Laravel + Blade + Tailwind

This stack is practical, fast, maintainable, and suitable for the first commercial release.

## Decision 004: Arabic-First with RTL Default

The UI must be Arabic-first from the initial release.

### Details

- Default locale: `ar`
- Fallback locale: `en`
- HTML direction: `rtl`
- HTML language: `ar`
- Font: Cairo (Arabic-optimized) via Google Fonts
- All translation strings use Laravel's `__()` helper for future English support
- No language switcher is implemented yet
- English support will be added later without UI rewrites

### Reason

The target market is Arabic-speaking gyms in Kuwait. Building Arabic-first eliminates technical debt of retrofitting RTL later.

## Decision 005: Dark Premium Gym Theme (Lime Green Accent)

The entire application must follow a dark premium fitness theme.

### Approved Color Palette

- **Primary (Lime Green):** `#9ACD32` base, with full scale (`primary-50` through `primary-900`)
- **Dark Background:** `#071014` (`surface-950`)
- **Card Background:** `#1E293B` (`surface-800`)
- **Elevated Surfaces:** `#0F172A` (`surface-900`)
- **Light Sections:** `#F8FAFC` (`surface-50`) where appropriate
- **Text Primary:** `#FFFFFF`
- **Text Secondary:** `#CBD5E1` (`surface-300`)
- **Text Muted:** `#64748B` (`surface-500`)
- **Borders:** `#334155` (`surface-700`)

All component colors are centralized in `resources/css/app.css` via Tailwind CSS v4 `@theme` directives. No hardcoded color values in Blade files.

### Reason

The gym industry demands a bold, premium visual identity. The dark theme with lime green accent creates the desired premium fitness SaaS feel.

## Final Principle

Important technical decisions must be documented so future developers understand why they exist.
