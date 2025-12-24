# Getting Started with Clary

## Quick Start Guide

Clary is a **multi-tenant** application, which means it's designed to serve multiple organizations from the same codebase with complete data isolation.

### Option 1: Use the API (Recommended for Getting Started)

The easiest way to get started is to use the REST API directly:

1. **Start the server** (if not already running):
```bash
php artisan serve
```

2. **Access the API endpoints**:
```bash
# List all clients
curl http://localhost:8000/api/clients

# List all projects
curl http://localhost:8000/api/projects

# List all tasks
curl http://localhost:8000/api/tasks

# List all invoices
curl http://localhost:8000/api/invoices
```

3. **Create a new client**:
```bash
curl -X POST http://localhost:8000/api/clients \
  -H "Content-Type: application/json" \
  -d '{
    "name": "My First Client",
    "email": "client@example.com",
    "phone": "+1-555-0100",
    "company": "Example Corp",
    "status": "active"
  }'
```

### Option 2: Set Up Multi-Tenancy

For the full multi-tenant experience:

1. **Create your first tenant** via Tinker:
```bash
php artisan tinker
```

Then run:
```php
use Stancl\Tenancy\Database\Models\Tenant;

$tenant = Tenant::create(['id' => 'acme']);
$tenant->domains()->create(['domain' => 'acme.localhost']);
```

2. **Update your hosts file** (optional for local development):

**Windows**: `C:\Windows\System32\drivers\etc\hosts`
**Mac/Linux**: `/etc/hosts`

Add:
```
127.0.0.1 acme.localhost
```

3. **Access your tenant**:
```
http://acme.localhost:8000
```

### Option 3: Use SQLite Browser or API Client

1. **View your data** with a SQLite browser like DB Browser for SQLite
   - Open `database/database.sqlite`
   - Browse the clients, projects, tasks, and invoices tables

2. **Use an API client** like Postman, Insomnia, or Thunder Client (VS Code extension)
   - Import the API endpoints
   - Test CRUD operations

## What's Included?

The database is already seeded with sample data:
- ✅ 3 clients (Acme Corporation, Tech Innovators Ltd, Green Energy Solutions)
- ✅ 3 projects (Website Redesign, Mobile App Development, SEO Optimization)
- ✅ 4 tasks (Design Homepage Mockups, Implement Navigation, etc.)
- ✅ 3 invoices (with various statuses: paid, sent, draft)

## API Documentation

See the main [README.md](README.md) for complete API documentation.

## Why 404 on Root?

The root path `/` shows a 404 because:
- This is a **multi-tenant API platform**
- The web routes are protected by tenancy middleware
- Access is designed through tenant domains or the API

If you want a simple landing page on the root, you can access the API at `/api/*` endpoints or set up tenancy as described above.

## Troubleshooting

### Database not found?
```bash
touch database/database.sqlite
php artisan migrate --seed
```

### Want to reset the database?
```bash
php artisan migrate:fresh --seed
```

### Need to run tests?
```bash
php artisan test
```

## Next Steps

1. ✅ API is ready at `http://localhost:8000/api/*`
2. Explore the [README.md](README.md) for full documentation
3. Build a frontend (Vue.js, React, or any framework)
4. Set up proper tenancy with domains
5. Deploy to production!

## Need Help?

Check the [README.md](README.md) for:
- Complete API endpoint documentation
- Database schema details
- Example requests and responses
- Multi-tenancy setup guide
