# Glow Beauty Salon Sales CRM

This first increment implements pipeline stages, leads, contacts, their Eloquent relationships, lookup indexes, and sample salon data. Follow-up reminders, email templates, and activity logs are intentionally deferred to the next increment.

## Current ER diagram

```text
pipeline_stages 1 ───< leads 1 ───< contacts
```

`leads.pipeline_stage_id` restricts deletion of an in-use stage. `contacts.lead_id` cascades when a lead is removed. Foreign-key, stage/status, source, email, and follow-up-date indexes support expected pipeline filters.

## Run locally

```bash
composer install
php artisan migrate:fresh --seed
php artisan db:seed
```

`SalonCrmSeeder` creates 3 pipeline stages, 10 salon leads, and 3 primary contacts. A subsequent increment will add reminder, email-template, and activity-log tables plus their seed data.

## Implementation note

I implemented the core lead pipeline, contacts, indexes, and sample salon data. The difficult part was recovering from an interrupted local Composer extraction; reminders, templates, and activity logs remain intentionally out of scope for this half-complete increment.
