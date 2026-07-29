# SECURITY_GUIDELINES.md

# Security Guidelines

> Scope: Reusable security standard

## Purpose

This file defines minimum security requirements for production applications.

## Rules

- Never trust user input.
- Validate all requests.
- Authorize all protected actions.
- Keep `APP_DEBUG=false` in production.
- Never commit secrets.
- Use HTTPS in production.
- Protect forms with CSRF.
- Escape output unless intentionally rendering safe HTML.
- Rate-limit sensitive actions.

## Passwords

Use Laravel hashing.
Never store plain text passwords.

## File Uploads

Validate file type, size, and storage location.
Never execute uploaded files.

## Final Principle

Security is not a feature. It is a default requirement.
