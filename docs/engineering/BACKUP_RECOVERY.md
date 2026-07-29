# BACKUP_RECOVERY.md

# Backup & Recovery

> Scope: Reusable backup standard

## Purpose

This file defines how project data must be protected.

## Backup Scope

Back up:

- Database
- Uploaded files
- Environment configuration references
- Deployment scripts

## Rules

- Always backup before production migrations.
- Test restore procedures.
- Store backups outside the application server when possible.
- Never rely on one backup location only.

## Recovery Steps

1. Stop risky writes.
2. Identify the latest healthy backup.
3. Restore database.
4. Restore files.
5. Verify application behavior.

## Final Principle

A backup that has never been restored is only a hope.
