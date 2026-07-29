# CODE_REVIEW_CHECKLIST.md

# Code Review Checklist

> Scope: Reusable review standard

## Review Questions

- Is the code readable?
- Is the business logic correct?
- Is validation handled?
- Is authorization handled?
- Are names clear?
- Is there duplicated logic?
- Are database queries efficient?
- Are errors handled?
- Are tests needed?
- Does this create technical debt?

## Blockers

Reject code that contains:

- `dd()`
- `dump()`
- hardcoded secrets
- missing authorization
- unsafe file uploads
- untested critical business logic

## Final Principle

Code review protects the product, not the ego of the developer.
