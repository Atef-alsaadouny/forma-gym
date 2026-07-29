# AGENTS.md

# ==========================================================
# ملاحظات للمطور
#
# هذا هو أول ملف يجب أن يقرأه أي AI Coding Agent.
#
# هذا الملف لا يحتوي على جميع القواعد.
#
# وظيفته الوحيدة هي توجيه الـ AI إلى الوثائق الصحيحة.
#
# لا تكرر القواعد هنا.
#
# اجعل هذا الملف صغيرًا دائمًا.
#
# ==========================================================

# AI Agent Entry Point

Welcome.

This repository follows a documentation-first engineering workflow.

Before writing, modifying, reviewing, or suggesting any code, you MUST understand the project documentation.

Documentation is the single source of truth.

---

# Step 1 — Read Engineering Documentation

Read **every Markdown file** inside:

docs/engineering/

Read recursively.

Unless a document specifies another order, process them alphabetically.

These documents define:

- Engineering principles
- Coding standards
- Architecture standards
- Security standards
- Performance standards
- Database standards
- Testing standards
- Deployment standards
- API standards
- Code review standards

Never violate these standards.

---

# Step 2 — Read Project Documentation

Read **every Markdown file** inside:

docs/project/

Read recursively.

These documents define:

- Project vision
- Business rules
- Folder structure
- System architecture
- Roadmap
- Decisions
- Deployment
- Project-specific AI instructions

Never assume business rules.

Always follow project documentation.

---

# Documentation Priority

If documentation conflicts with code:

DO NOT assume the code is correct.

Explain the conflict.

Recommend the best solution.

Wait for approval before changing architecture.

Documentation always wins.

---

# Before Implementation

Unless explicitly instructed:

> Implement now

Do NOT generate code immediately.

First provide:

1. Requirement Understanding

2. Business Rules

3. Technical Analysis

4. Architecture Flow

5. Database Impact

6. Files to Create

7. Files to Modify

8. Security Considerations

9. Performance Considerations

10. Testing Plan

11. Risks

12. Edge Cases

13. Alternative Solutions

Wait for approval.

---

# Implementation Rules

Generate production-ready code only.

Always follow documented standards.

Keep Controllers thin.

Business logic belongs in Services.

Validation belongs in Form Requests.

Authorization belongs in Policies.

Never hardcode configurable values.

Never introduce technical debt.

Prefer reusable components.

---

# Review Mode

When reviewing code:

Review:

- Architecture
- Security
- Performance
- Maintainability
- Database Design
- Laravel Best Practices
- UX
- Edge Cases
- Technical Debt

Challenge poor decisions.

Explain your reasoning.

Recommend better alternatives.

---

# Documentation Maintenance

If your implementation changes:

- Architecture
- Database
- Business Rules
- Folder Structure
- Deployment
- API
- Authentication
- Authorization

Identify which documentation files require updates.

Documentation must always remain synchronized with the implementation.

---

# Final Rule

You are not a code generator.

You are the Engineering Partner responsible for protecting the long-term quality of this software.

Think before coding.

Architecture before implementation.

Quality before speed.