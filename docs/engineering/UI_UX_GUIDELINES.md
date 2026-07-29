# UI_UX_GUIDELINES.md

# UI / UX Guidelines

> Scope: Reusable design standard

## Purpose

This file defines interface and user-experience standards.

## Visual Identity

The application follows a **Dark Premium Gym Theme** with a lime green accent.

Refer to the design tokens in `resources/css/app.css` for exact color values.

Never hardcode random colors inside Blade files.

## Color System

All colors are centralized in `resources/css/app.css` via the `@theme` directive:

- `primary-*`: Lime green accent (primary actions, highlights, active states)
- `surface-*`: Neutral palette (backgrounds, cards, text, borders)
- Backgrounds are dark (`surface-900` / `surface-950`), cards are elevated (`surface-800`)
- Text uses white (`text-white`) and surface gray tones (`surface-300`, `surface-400`)
- Destructive actions use standard red (`red-400` / `red-600`)

## Typography

- Font: **Cairo** (Arabic-optimized, via Google Fonts)
- Fallback: `Noto Kufi Arabic`, system-ui, -apple-system, sans-serif
- Hierarchy: Bold for headings, medium for labels, normal for body

## RTL Layout

- The UI is **RTL by default** (`dir="rtl"`)
- Use logical properties: `start`/`end` instead of `left`/`right`
- Use `ms-*`/`me-*` instead of `ml-*`/`mr-*`
- Use `ps-*`/`pe-*` instead of `pl-*`/`pr-*`
- Use `border-s-*`/`border-e-*` instead of `border-l-*`/`border-r-*`
- Sidebar is on the **right** side

## Visual Rules

- Use consistent spacing.
- Use clear typography hierarchy.
- Make primary actions obvious.
- Keep forms simple.
- Avoid visual noise.
- Use rounded corners (`rounded-lg`, `rounded-xl`) consistently.
- Use subtle shadows (`shadow-sm`) on elevated elements.
- Use lime green for primary actions, dark cards for data containers.

## UX Rules

- Every page must have a clear purpose.
- Every form must show validation feedback.
- Every destructive action must require confirmation.
- Empty states must be designed.
- Loading states must be handled.

## Components

Prefer reusable components:

- Buttons (`<x-button>`)
- Inputs (`<x-input>`)
- Cards (`<x-card>`)
- Tables (`<x-dashboard.data-table>`)
- Modals (`<x-modal>`)
- Alerts (`<x-alert>`)
- Badges (`<x-badge>`)
- Empty states (`<x-empty-state>`)
- Sidebar (`<x-dashboard.sidebar>`)
- Stats cards (`<x-dashboard.stats-card>`)
- Action buttons (`<x-dashboard.action-button>`)
- Page headers (`<x-dashboard.page-header>`)

## Design Principles

1. **Reusable components first** — never duplicate UI patterns.
2. **Centralized tokens** — all colors in `app.css` `@theme`, never hardcoded.
3. **Dark-first** — dark backgrounds, light text, lime green accents.
4. **RTL-safe** — use logical CSS properties, avoid physical positioning.

## Final Principle

Good UI makes the next action obvious.
