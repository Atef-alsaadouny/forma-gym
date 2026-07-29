# Project Documentation

> Project: Forma Gym Management System  
> Architecture: Single Gym now, Multi-Tenant ready later

This documentation is split into two layers:

```text
docs/
├── engineering/   # Reusable engineering standards for this and future projects
└── project/       # Business and architecture knowledge specific to this gym project
```

## How to use this documentation

Before writing or changing any code, read:

1. `docs/engineering/MASTER_PROMPT.md`
2. Every file inside `docs/engineering/`
3. `docs/project/AI_PROJECT_PROMPT.md`
4. Every file inside `docs/project/`

## Core principle

Build the first version as a Single Gym system, but never write code that blocks a future Multi-Tenant SaaS version.
