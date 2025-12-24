# Clary Setup Guide - How to Get Started

## The "/" Shows 404 - Here's Why and How to Fix It

Clary is a **multi-tenant platform**, which means it's designed to serve multiple isolated organizations. Because of this architecture, the root path "/" behaves differently than a typical Laravel application.

## Quick Solution - Use the API (Recommended)

The **easiest way** to get started is to use the API endpoints directly. They work perfectly on localhost!

### Step 1: Setup (First Time Only)

```bash
# Install dependencies
composer install

# Copy environment file
cp .env.example .env

# Generate application key
php artisan key:generate

# Create database and run migrations
touch database/database.sqlite
php artisan migrate --seed
```

### Step 2: Start the Server

```bash
php artisan serve
```

### Step 3: Access the API

The API works perfectly at `http://localhost:8000/api/*`:

```bash
# List all clients (you'll see 3 sample clients)
curl http://localhost:8000/api/clients

# List all projects
curl http://localhost:8000/api/projects

# List all tasks
curl http://localhost:8000/api/tasks

# List all invoices
curl http://localhost:8000/api/invoices
```

### Step 4: Create Your First Client

```bash
curl -X POST http://localhost:8000/api/clients \
  -H "Content-Type: application/json" \
  -d '{
    "name": "My First Client",
    "email": "client@example.com",
    "company": "Example Corp",
    "status": "active"
  }'
```

## Understanding Why "/" Shows 404

The root path "/" is configured for **tenant-specific access**. Here's what's happening:

1. The application has multi-tenancy enabled (Stancl/Tenancy)
2. Localhost (127.0.0.1) is configured as a "central domain"  
3. Tenant routes (including "/") require a tenant-specific domain
4. The API routes work fine because they're on the central domain

This is **by design** - it's how multi-tenant applications work!

## Option 1: Access a Tenant Domain

If you want to see the tenant routes (including the "/" path):

1. Create a tenant via Tinker:
```bash
php artisan tinker
```

```php
use Stancl\Tenancy\Database\Models\Tenant;

$tenant = Tenant::create(['id' => 'demo']);
$tenant->domains()->create(['domain' => 'demo.localhost']);
```

2. Access `http://demo.localhost:8000/` (this will work!)

## Option 2: Use the API (Recommended for Development)

Just use the API endpoints - they're fully functional:

- `GET /api/clients` - List clients
- `POST /api/clients` - Create client
- `GET /api/projects` - List projects
- `POST /api/projects` - Create project
- `GET /api/tasks` - List tasks
- `POST /api/tasks` - Create task
- `GET /api/invoices` - List invoices
- `POST /api/invoices` - Create invoice

## Complete API Example

```bash
# 1. List existing clients
curl http://localhost:8000/api/clients

# 2. Create a new client
curl -X POST http://localhost:8000/api/clients \
  -H "Content-Type: application/json" \
  -d '{
    "name": "New Company",
    "email": "contact@newcompany.com",
    "phone": "+1-555-9999",
    "company": "New Company Inc",
    "status": "active"
  }'

# 3. Create a project for the client (use client_id from step 2)
curl -X POST http://localhost:8000/api/projects \
  -H "Content-Type: application/json" \
  -d '{
    "client_id": 1,
    "name": "Website Project",
    "description": "New website development",
    "start_date": "2024-01-01",
    "budget": 10000,
    "status": "planning"
  }'

# 4. Create a task for the project
curl -X POST http://localhost:8000/api/tasks \
  -H "Content-Type: application/json" \
  -d '{
    "project_id": 1,
    "title": "Design Homepage",
    "description": "Create homepage mockups",
    "priority": "high",
    "status": "todo"
  }'
```

## Use an API Client

For a better experience, use an API client like:

- **Postman** - https://www.postman.com/
- **Insomnia** - https://insomnia.rest/
- **Thunder Client** (VS Code extension)
- **Bruno** - https://www.usebruno.com/

Import the base URL: `http://localhost:8000/api`

## What's Included Out of the Box?

The database is already seeded with sample data:
- ✅ 3 clients
- ✅ 3 projects  
- ✅ 4 tasks
- ✅ 3 invoices

You can view this data immediately via the API!

## View Data Directly

Use a SQLite browser to view the database:
- **DB Browser for SQLite** - https://sqlitebrowser.org/
- Open `database/database.sqlite`
- Browse the tables: clients, projects, tasks, invoices

## Troubleshooting

### "Call to undefined method Client::factory()"
Run: `composer dump-autoload`

### Database errors
```bash
touch database/database.sqlite
php artisan migrate:fresh --seed
```

### Routes not working
```bash
php artisan optimize:clear
php artisan serve
```

### Want to start fresh?
```bash
php artisan migrate:fresh --seed
```

## Summary

**TL;DR:**
1. Run `composer install`, `cp .env.example .env`, `php artisan key:generate`
2. Run `touch database/database.sqlite && php artisan migrate --seed`
3. Run `php artisan serve`
4. Use the API at `http://localhost:8000/api/*`
5. The "/" route requires tenant setup - use the API instead!

For full documentation, see [README.md](README.md)
