# Glow Beauty Salon Sales CRM

A Laravel-based relational database and CRM foundation designed for **Glow Beauty Salon**. The project focuses on building a well-structured data model, database migrations, Eloquent relationships, foreign-key constraints, lookup indexes, realistic seed data, and automated verification.

The CRM is designed to organize salon leads and their progression through a sales pipeline while maintaining customer contacts, scheduled follow-ups, reusable email templates, and a chronological activity history.

---

## 📌 Project Overview

The **Glow Beauty Salon Sales CRM** models the core data required for managing potential and existing salon customers throughout a sales and follow-up process.

The system provides a structured relational database containing:

* Sales pipeline stages
* Leads
* Contacts associated with leads
* Follow-up reminders
* Reusable email templates
* Lead activity logs
* Foreign-key relationships
* Referential integrity rules
* Database indexes for common CRM queries
* Unique constraints for reusable templates
* Representative salon seed data
* Automated tests for verifying the implementation

The primary goal of this project is to demonstrate how a real-world CRM database can be designed using **Laravel migrations and Eloquent models** while keeping the schema maintainable, relationally consistent, and efficient for common queries.

---

## ✨ Features

### 🔹 Sales Pipeline Management

Leads are organized into predefined pipeline stages.

Each lead is associated with a pipeline stage through:

```text
leads.pipeline_stage_id
```

This allows the CRM to represent a lead's current position in the sales process.

Example pipeline stages include:

* New
* Contacted
* Converted

The database also prevents an in-use pipeline stage from being deleted accidentally.

---

### 🔹 Lead Management

The `leads` entity represents potential salon customers.

Leads contain information necessary for:

* Identifying prospects
* Tracking their current pipeline stage
* Recording their acquisition source
* Storing email information
* Tracking status
* Recording the next planned follow-up

Indexes are provided for commonly queried lead information, including:

```text
pipeline_stage_id
status
source
email
next_follow_up
```

This makes common CRM filtering and follow-up queries more efficient.

---

### 🔹 Contact Management

A lead can have associated contact information.

The relationship is structured as:

```text
Lead
  └── Contacts
```

Contacts can be used to maintain additional customer communication information without putting every possible contact field directly into the lead record.

Contacts are associated with their parent lead and are automatically removed when the corresponding lead is deleted.

---

### 🔹 Follow-Up Reminders

The `follow_up_reminders` table is responsible for scheduled customer follow-ups.

A reminder records information such as:

* Follow-up type
* Due date/time
* Completion status
* Notes
* Associated lead
* Optional associated contact

Supported communication types include:

* Phone
* Email
* SMS

The reminder structure allows the CRM to support pending follow-up queues and track whether scheduled customer communication has been completed.

Indexes support common reminder queries using:

```text
lead_id
status
due_at
```

---

### 🔹 Reusable Email Templates

The CRM contains an `email_templates` table for storing reusable salon communication templates.

Templates can be:

* Active
* Inactive
* Categorized
* Reused for different leads

Templates can also contain merge tokens such as:

```text
{{first_name}}
{{appointment_date}}
```

These placeholders allow the same template to be adapted to individual customers.

Template names and slugs are protected by unique constraints to prevent duplicate template definitions.

---

### 🔹 Lead Activity Timeline

The `activity_logs` table provides a chronological record of activity associated with a lead.

This allows CRM history to be maintained for events such as:

* Communication
* Pipeline changes
* Follow-up actions
* Template usage
* Other relevant CRM events

The activity record includes JSON metadata so additional contextual information can be stored without changing the database structure for every new activity type.

For example, metadata can contain information about:

```text
Template used
Pipeline transition
Additional activity context
```

Activity records are designed as an append-oriented CRM history.

---

## 🗂️ Database Relationships

The core relational structure is:

```text
pipeline_stages
       │
       │ 1
       │
       ▼
     leads
       │
       ├───────────────< contacts
       │
       ├───────────────< follow_up_reminders
       │                         │
       │                         └── 0..1 contact
       │
       └───────────────< activity_logs
                                 │
                                 └── 0..1 contact


email_templates
      │
      └── Reusable template catalogue
```

### Relationship Summary

| Entity         | Relationship                  | Entity              |
| -------------- | ----------------------------- | ------------------- |
| Pipeline Stage | One-to-Many                   | Leads               |
| Lead           | One-to-Many                   | Contacts            |
| Lead           | One-to-Many                   | Follow-Up Reminders |
| Lead           | One-to-Many                   | Activity Logs       |
| Contact        | Optional relationship         | Follow-Up Reminder  |
| Contact        | Optional relationship         | Activity Log        |
| Email Template | Standalone reusable catalogue | —                   |

---

## 🔐 Referential Integrity

The database uses foreign keys to maintain consistency between related records.

### Pipeline Stages → Leads

A lead references its pipeline stage through:

```text
leads.pipeline_stage_id
```

An in-use pipeline stage cannot simply be deleted because doing so would leave existing leads without a valid stage.

---

### Lead → Contacts

Contacts belong to a lead.

When a lead is deleted, its associated contacts are removed as part of the relationship's cascade behavior.

---

### Lead → Follow-Up Reminders

Follow-up reminders belong to a lead.

Deleting a lead also removes its associated reminders.

---

### Lead → Activity Logs

Activity records belong to a lead.

When a lead is deleted, its related activity records are also removed.

---

### Contact → Historical Records

The relationship between contacts and reminders/activity records is optional.

If a contact is deleted, the corresponding:

```text
contact_id
```

can become:

```text
NULL
```

This preserves the CRM history while allowing the contact itself to be removed.

This is particularly useful for historical records because the activity remains available even when the associated contact is no longer present.

---

## ⚡ Database Indexing

The database includes indexes for frequently used CRM operations.

### Lead Queries

Indexes support:

```text
pipeline_stage_id
status
source
email
next_follow_up
```

These support operations such as:

* Filtering leads by pipeline stage
* Filtering leads by status
* Finding leads by source
* Looking up leads using email
* Finding upcoming follow-ups

---

### Follow-Up Queries

Indexes support:

```text
lead_id
status
due_at
```

This allows the application to efficiently retrieve pending reminders and scheduled follow-ups.

---

### Activity Timeline Queries

Indexes support:

```text
lead_id
occurred_at
```

This makes it easier to retrieve a lead's activity history in chronological order.

---

### Contact Activity Queries

Indexes are also provided for contact-related activity lookup.

---

### Email Template Queries

Active email templates can be efficiently filtered by category.

Template names and slugs additionally use uniqueness constraints.

---

## 🌱 Seed Data

The project includes a dedicated `SalonCrmSeeder` for creating representative salon CRM data.

The seed data includes:

| Data                               | Quantity |
| ---------------------------------- | -------: |
| Pipeline stages                    |        3 |
| Salon leads                        |       10 |
| Primary contacts                   |        3 |
| Email templates                    |        5 |
| Contact-linked follow-up reminders |        3 |
| Contact-linked activity records    |        3 |

This provides enough realistic data to verify the relationships and demonstrate how the CRM database behaves.

The seed data is particularly useful during development because the database can be recreated without manually entering records.

---

## 🛠️ Technology Stack

### Backend

* **PHP**
* **Laravel**
* **Eloquent ORM**

### Database

The project uses a relational database structure implemented through Laravel migrations.

The test setup also supports SQLite, which was important when implementing portable bulk seed data.

### Development Tools

* Composer
* Laravel Artisan
* PHPUnit / Laravel testing
* Git
* GitHub

---

## 📁 Project Structure

The project follows the standard Laravel application structure.

```text
Data-model-and-migrations/
│
├── app/
│   └── Models/
│       └── CRM Eloquent models
│
├── bootstrap/
│
├── config/
│
├── database/
│   ├── factories/
│   ├── migrations/
│   └── seeders/
│       └── SalonCrmSeeder.php
│
├── public/
│
├── resources/
│
├── routes/
│
├── storage/
│
├── tests/
│
├── artisan
├── composer.json
├── composer.lock
├── package.json
├── package-lock.json
├── phpunit.xml
├── vite.config.js
└── README.md
```

---

## 🚀 Getting Started

### Prerequisites

Make sure the following are installed:

* PHP
* Composer
* Laravel-compatible database
* Node.js and npm
* Git

---

## 📥 Installation

Clone the repository:

```bash
git clone https://github.com/Omar-Hashmi/Data-model-and-migrations.git
```

Navigate into the project:

```bash
cd Data-model-and-migrations
```

Install PHP dependencies:

```bash
composer install
```

Install frontend dependencies:

```bash
npm install
```

---

## ⚙️ Environment Configuration

Create your environment file:

```bash
cp .env.example .env
```

On Windows, you can also create the `.env` file manually from `.env.example`.

Generate the Laravel application key:

```bash
php artisan key:generate
```

Configure the database settings in `.env` according to your local environment.

For example:

```env
APP_NAME="Glow Beauty Salon CRM"
APP_ENV=local
APP_DEBUG=true

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=glow_beauty_salon
DB_USERNAME=root
DB_PASSWORD=
```

---

## 🗄️ Database Setup

To recreate the database from scratch and insert the sample CRM data:

```bash
php artisan migrate:fresh --seed
```

This command:

1. Removes existing tables
2. Runs all migrations
3. Rebuilds the relational schema
4. Executes the seeders
5. Inserts representative salon CRM data

If you only want to run the seeders:

```bash
php artisan db:seed
```

> **Warning:** `migrate:fresh` deletes existing database tables and their data. Use it only when resetting a development database or when you intentionally want a clean database.

---

## 🧪 Running Tests

Run the project's test suite using:

```bash
php artisan test --compact
```

The tests provide verification that the implemented schema and CRM functionality behave as expected.

For a more detailed test output:

```bash
php artisan test
```

---

## 🔄 Database Migration Workflow

The project uses Laravel migrations to version and manage database structure changes.

When the CRM schema changes, a new migration can be created using:

```bash
php artisan make:migration migration_name
```

After creating the migration, apply it using:

```bash
php artisan migrate
```

To see the migration status:

```bash
php artisan migrate:status
```

For development, the database can be rebuilt and reseeded with:

```bash
php artisan migrate:fresh --seed
```

This keeps the database structure reproducible across development environments.

---

## 🧩 Eloquent Models

Each major CRM entity is represented using an Eloquent model.

The models define relationships between database records so application code can work with the relational structure naturally.

Conceptually, the relationships include:

```php
PipelineStage
    └── hasMany(Lead)

Lead
    ├── belongsTo(PipelineStage)
    ├── hasMany(Contact)
    ├── hasMany(FollowUpReminder)
    └── hasMany(ActivityLog)
```

The optional contact relationships allow reminders and activity records to retain historical information even if the original contact is removed.

---

## 📊 Example CRM Workflow

A typical CRM workflow can be represented as:

```text
New Lead
   │
   ▼
Pipeline Stage
   │
   ▼
Contact Added
   │
   ▼
Follow-Up Scheduled
   │
   ├── Email
   ├── Phone
   └── SMS
   │
   ▼
Activity Recorded
   │
   ▼
Pipeline Stage Updated
   │
   ▼
Converted Lead
```

This structure allows the CRM to preserve both the **current state** of a lead and its **historical activity**.

---

## 📧 Email Template Example

A reusable email template can contain merge tokens:

```text
Hello {{first_name}},

Thank you for your interest in Glow Beauty Salon.

Your appointment is scheduled for {{appointment_date}}.

We look forward to seeing you!
```

The template can remain reusable while the placeholders are populated with customer-specific information by the application layer.

---

## 📝 Activity Metadata

Activity logs include JSON metadata for additional contextual information.

For example, an activity could store metadata representing:

```json
{
    "template": "appointment-reminder",
    "previous_stage": "contacted",
    "new_stage": "converted"
}
```

Using JSON metadata provides flexibility for activity-specific information without requiring a separate database column for every possible type of CRM event.

---

## 🎯 Project Objectives

This project demonstrates practical implementation of:

* Relational database design
* Database normalization
* Laravel migrations
* Eloquent ORM
* Model relationships
* Foreign-key constraints
* Cascading relationships
* Nullable relationships
* Unique constraints
* Database indexing
* JSON metadata
* Database seeding
* SQLite-compatible seed data
* Automated testing
* Reproducible database setup

---

## 💡 Key Implementation Challenge

One of the main implementation challenges was making bulk seed data portable to **SQLite**.

SQLite requires rows in a bulk insert to provide compatible column structures. The seed implementation therefore ensures that every inserted row supplies the required columns consistently.

This makes the seed process more reliable across development and testing environments.

---

## 🔍 Data Integrity Design

The schema was designed around maintaining reliable relationships between CRM entities.

Important integrity rules include:

* Leads must reference valid pipeline stages.
* Pipeline stages currently being used by leads cannot be deleted freely.
* Contacts belong to their corresponding leads.
* Lead deletion cascades to dependent CRM records where appropriate.
* Optional contact references can become `NULL` rather than destroying historical activity.
* Email template names and slugs must remain unique.
* Indexes support common CRM lookup and timeline operations.

These constraints help ensure that the database remains consistent as the application grows.

---

## 🧪 Verification

The project includes automated verification coverage for the implemented CRM schema and its supporting functionality.

The standard verification command is:

```bash
php artisan test --compact
```

A clean database can be prepared before testing with:

```bash
php artisan migrate:fresh --seed
```

Then:

```bash
php artisan test --compact
```

---

## 📌 Current Scope

The project primarily focuses on the **data model and database foundation** of the CRM.

The implemented scope includes:

* CRM database schema
* Laravel migrations
* Eloquent models
* Entity relationships
* Foreign keys
* Indexes
* Constraints
* Seed data
* Email template catalogue
* Follow-up reminder structure
* Activity history structure
* Automated verification

The database foundation is structured so that application-level CRM features can be built on top of it.

---

## 👨‍💻 Author

**Omar Hashmi**

Software Engineering Student & Full-Stack Developer

GitHub:
https://github.com/Omar-Hashmi

---

## 📄 License

This project is intended for educational and development purposes.

If a specific license is added to the repository, this section should be updated accordingly.

---

## ⭐ Project Summary

**Glow Beauty Salon Sales CRM** is a Laravel relational database project that models the core data requirements of a salon sales CRM.

It demonstrates how to design and implement a structured relational system using **Laravel migrations, Eloquent models, foreign keys, indexes, constraints, seeders, and automated tests**.

The resulting schema supports the complete lifecycle of a CRM lead — from entering a sales pipeline, through contact management and scheduled follow-ups, to maintaining a persistent activity history.

The project emphasizes **data integrity, query efficiency, maintainability, reproducibility, and realistic development data**, providing a solid database foundation for a larger CRM application.
