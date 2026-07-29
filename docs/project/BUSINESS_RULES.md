# BUSINESS_RULES.md

# Business Rules

## Members

- A member must have a valid profile.
- A member may have one active subscription at a time unless business requirements change.
- Expired members cannot check in.
- Suspended members cannot access member services.

## Subscriptions

- Every subscription belongs to a package.
- Every subscription has a start date and end date.
- Renewal must create a clear financial and operational record.
- Freezing a subscription must be tracked.

## Trainers

- Trainers can be assigned to members or schedules.
- Trainer availability must be respected.

## Branches

- The system must support multiple branches even if the first release uses one branch.

## Attendance

- Duplicate check-ins for the same session should be prevented.
- Attendance must be reportable.

## Final Principle

Business rules belong in services and tests, not scattered inside controllers or Blade files.
