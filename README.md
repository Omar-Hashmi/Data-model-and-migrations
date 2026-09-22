# Glow Beauty Salon Sales CRM

This project implements a sales CRM for Glow Beauty Salon: pipeline stages, leads, contacts, follow-up reminders, reusable email templates, and a lead activity timeline. Every CRM entity has Eloquent relationships, foreign keys, practical lookup indexes, and representative salon seed data.

## ER diagram

```text
pipeline_stages 1 ---< leads 1 ---< contacts
                      |  \---< follow_up_reminders >--- 0..1 contacts
                      \----< activity_logs        >--- 0..1 contacts

email_templates (reusable catalogue)
```

`leads.pipeline_stage_id` restricts deletion of an in-use stage. Contacts, reminders, and activities cascade with their lead. A deleted contact is retained in CRM history by setting its optional `contact_id` on reminders and activities to `NULL`.

Lookup indexes support pipeline filtering (`leads.pipeline_stage_id/status`, source, email, next follow-up), pending reminder queues (`lead_id/status/due_at`), activity timelines (`lead_id/occurred_at`), contact activity lookup, and active templates by category. Email-template names and slugs are unique.

## Schema notes

- `follow_up_reminders` records a scheduled phone, email, or SMS follow-up, its due date, completion state, and notes.
- `email_templates` stores reusable active/inactive salon messaging with merge tokens such as `{{first_name}}` and `{{appointment_date}}`.
- `activity_logs` is an append-only-style CRM timeline record. Its JSON `metadata` captures contextual data such as the template used or a pipeline transition.

## Run locally

```bash
composer install
php artisan migrate:fresh --seed
php artisan test --compact
```

`SalonCrmSeeder` creates 3 pipeline stages, 10 salon leads, 3 primary contacts, 5 email templates, 3 contact-linked follow-up reminders, and 3 contact-linked activity records.
