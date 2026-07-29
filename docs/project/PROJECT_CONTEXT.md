# PROJECT_CONTEXT.md

> Version: 1.0
> Status: Active Development
> Project: Forma Gym Management System

---

# ==========================================================
# ملاحظات للمطور
#
# هذا الملف ليس بديلاً عن الوثائق.
#
# الهدف منه إعطاء أي مطور أو AI
# فهمًا سريعًا للمشروع خلال أقل من دقيقة.
#
# بعد قراءة هذا الملف يجب الانتقال إلى:
#
# docs/engineering/
#
# ثم
#
# docs/project/
#
# للحصول على جميع التفاصيل.
#
# ==========================================================

# Project Summary

Forma Gym Management System is a modern, production-ready Gym Management Platform designed to evolve into a Multi-Tenant SaaS product.

The current release targets a single gym while maintaining an architecture that allows future migration to multiple gyms with minimal changes.

---

# Current Phase

Current Version

✔ Single Gym

Future Versions

✔ Multi Branch

✔ Multi Gym

✔ SaaS Platform

---

# Primary Goal

Build a maintainable, scalable, secure, and production-ready software product.

The project prioritizes long-term quality over rapid implementation.

---

# Technology Stack

## Backend

Laravel

PHP

---

## Frontend

Blade

Tailwind CSS

Alpine.js (when needed)

---

## Database

PostgreSQL

---

## Authentication

Laravel Authentication

Policies

Permissions

---

## Deployment

Docker

Render

GitHub

---

# Project Philosophy

The project follows a Documentation First approach.

Documentation defines the architecture.

Implementation follows documentation.

Documentation is always the source of truth.

---

# Architecture Philosophy

The application is built using:

- Thin Controllers
- Service Layer
- Form Requests
- Policies
- Eloquent Relationships
- Reusable Components
- Clean Architecture Principles

Business logic must never live inside Controllers or Views.

---

# Core Modules

Current planned modules include:

- Website
- Authentication
- Dashboard
- Members
- Trainers
- Employees
- Branches
- Membership Packages
- Subscriptions
- Attendance
- Workout Programs
- Nutrition Plans
- Measurements
- Notifications
- Reports
- Settings

---

# Future Modules

Possible future expansions:

- Multi-Tenant Support
- Online Payments
- Mobile Application
- QR Check-in
- AI Coach
- Loyalty Program
- Referral System
- Online Booking
- Video Library
- CRM Integration

---

# Development Principles

Always prioritize:

- Security
- Performance
- Maintainability
- Scalability
- Readability
- User Experience

Never optimize for short-term convenience.

---

# Documentation Structure

Engineering documentation:

docs/engineering/

Project documentation:

docs/project/

AI entry point:

AGENTS.md

---

# AI Workflow

Every AI Agent must:

1. Read AGENTS.md

↓

2. Read all engineering documentation

↓

3. Read all project documentation

↓

4. Understand the business

↓

5. Understand the architecture

↓

6. Validate the requirement

↓

7. Propose implementation

↓

8. Wait for approval (unless instructed to implement immediately)

---

# Development Workflow

Requirement

↓

Analysis

↓

Architecture Validation

↓

Database Impact

↓

Implementation

↓

Testing

↓

Documentation Update

↓

Deployment

---

# Code Quality

The codebase must always remain:

- Production Ready
- Clean
- Modular
- Well Documented
- Secure
- Easy to Extend

Technical debt should never be introduced for short-term gains.

---

# Documentation Maintenance

Whenever changes affect:

- Architecture
- Business Rules
- Database
- Folder Structure
- API
- Deployment
- Security
- Workflows

The corresponding documentation must be updated.

Documentation and implementation must always remain synchronized.

---

# Final Reminder

This project is not a prototype.

It is a long-term software product.

Every technical decision should support future growth while keeping the current implementation simple, maintainable, and production-ready.