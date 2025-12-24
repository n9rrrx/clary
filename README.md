# Clary - Multi-Tenant Agency Client Management Platform

Clary is a multi-tenant agency client management platform designed to help agencies, freelancers, and service-based teams manage clients, projects, tasks, and billing all from a single, organized dashboard.

Built with scalability and simplicity in mind, Clary allows each organization to operate in its own isolated workspace while sharing a secure, centralized system. From onboarding clients to tracking work and delivering invoices, Clary streamlines the entire client lifecycle.

## ✨ Features

### Core Functionality
- **Multi-Tenancy**: Isolated workspaces for each organization using Stancl/Tenancy
- **Client Management**: Comprehensive client profiles with contact information, notes, and status tracking
- **Project Tracking**: Organize work by projects with budgets, timelines, and status monitoring
- **Task Management**: Create, assign, and track tasks across projects with priorities and due dates
- **Billing & Invoicing**: Generate and manage invoices with automatic calculations and multiple statuses

### Technical Features
- RESTful API with full CRUD operations
- Laravel Sanctum authentication for secure API access
- Eloquent ORM relationships for seamless data management
- Comprehensive validation and error handling
- Database seeders for quick setup and testing
- PHPUnit test coverage

## 🏗️ Tech Stack

- **Backend**: Laravel 11 (PHP 8.3+)
- **Database**: MySQL/PostgreSQL/SQLite
- **Authentication**: Laravel Sanctum
- **Multi-Tenancy**: Stancl/Tenancy v3.9
- **Testing**: PHPUnit

## 📋 Requirements

- PHP >= 8.2
- Composer
- Database (MySQL, PostgreSQL, or SQLite)
- Node.js & NPM (for frontend assets, optional)

## 🚀 Installation

1. **Clone the repository**:
```bash
git clone https://github.com/n9rrrx/clary.git
cd clary
```

2. **Install PHP dependencies**:
```bash
composer install
```

3. **Copy the environment file**:
```bash
cp .env.example .env
```

4. **Generate application key**:
```bash
php artisan key:generate
```

5. **Configure your database** in `.env` file:
```env
DB_CONNECTION=sqlite
DB_DATABASE=/absolute/path/to/database.sqlite
```

For MySQL/PostgreSQL:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=clary
DB_USERNAME=root
DB_PASSWORD=
```

6. **Run migrations**:
```bash
php artisan migrate
```

7. **Seed the database** (optional, for testing):
```bash
php artisan db:seed
```

8. **Start the development server**:
```bash
php artisan serve
```

The application will be available at `http://localhost:8000`

## 📚 API Documentation

### Base URL
```
http://localhost:8000/api
```

### Endpoints

#### Clients
- `GET /api/clients` - List all clients (paginated)
- `POST /api/clients` - Create a new client
- `GET /api/clients/{id}` - Show a specific client
- `PUT /api/clients/{id}` - Update a client
- `DELETE /api/clients/{id}` - Delete a client

#### Projects
- `GET /api/projects` - List all projects (paginated)
- `POST /api/projects` - Create a new project
- `GET /api/projects/{id}` - Show a specific project
- `PUT /api/projects/{id}` - Update a project
- `DELETE /api/projects/{id}` - Delete a project

#### Tasks
- `GET /api/tasks` - List all tasks (paginated)
- `POST /api/tasks` - Create a new task
- `GET /api/tasks/{id}` - Show a specific task
- `PUT /api/tasks/{id}` - Update a task
- `DELETE /api/tasks/{id}` - Delete a task

#### Invoices
- `GET /api/invoices` - List all invoices (paginated)
- `POST /api/invoices` - Create a new invoice
- `GET /api/invoices/{id}` - Show a specific invoice
- `PUT /api/invoices/{id}` - Update an invoice
- `DELETE /api/invoices/{id}` - Delete an invoice

### Example Requests

**Create a Client**:
```bash
curl -X POST http://localhost:8000/api/clients \
  -H "Content-Type: application/json" \
  -d '{
    "name": "New Client",
    "email": "client@example.com",
    "phone": "+1-555-1234",
    "company": "Example Corp",
    "status": "active"
  }'
```

**List All Clients**:
```bash
curl http://localhost:8000/api/clients
```

**Create a Project**:
```bash
curl -X POST http://localhost:8000/api/projects \
  -H "Content-Type: application/json" \
  -d '{
    "client_id": 1,
    "name": "Website Redesign",
    "description": "Complete redesign of company website",
    "start_date": "2024-01-01",
    "end_date": "2024-03-01",
    "budget": 15000,
    "status": "in_progress"
  }'
```

## 🗂️ Database Schema

### Clients
- `id` - Primary key
- `name` - Client name (required)
- `email` - Client email
- `phone` - Client phone number
- `company` - Company name
- `address` - Physical address
- `notes` - Additional notes
- `status` - active/inactive

### Projects
- `id` - Primary key
- `client_id` - Foreign key to clients
- `name` - Project name (required)
- `description` - Project description
- `start_date` - Project start date
- `end_date` - Project end date
- `budget` - Project budget
- `status` - planning/in_progress/completed/on_hold/cancelled

### Tasks
- `id` - Primary key
- `project_id` - Foreign key to projects
- `assigned_to` - Foreign key to users
- `title` - Task title (required)
- `description` - Task description
- `due_date` - Task due date
- `priority` - low/medium/high/urgent
- `status` - todo/in_progress/review/completed

### Invoices
- `id` - Primary key
- `client_id` - Foreign key to clients
- `project_id` - Foreign key to projects
- `invoice_number` - Unique invoice number (required)
- `issue_date` - Invoice issue date
- `due_date` - Invoice due date
- `subtotal` - Invoice subtotal
- `tax` - Tax amount
- `total` - Total amount
- `notes` - Additional notes
- `status` - draft/sent/paid/overdue/cancelled

## 🧪 Testing

Run the test suite:
```bash
php artisan test
```

Run specific tests:
```bash
php artisan test --filter ClientApiTest
```

Run tests with coverage:
```bash
php artisan test --coverage
```

## 🔧 Development

### Code Style
This project follows PSR-12 coding standards. Use Laravel Pint for automatic formatting:
```bash
./vendor/bin/pint
```

### Migrations
Create a new migration:
```bash
php artisan make:migration create_example_table
```

### Models
Create a new model with migration:
```bash
php artisan make:model Example -m
```

### Controllers
Create a new API controller:
```bash
php artisan make:controller Api/ExampleController --api
```

## 🏢 Multi-Tenancy

Clary uses Stancl/Tenancy for multi-tenant functionality. Each organization operates in an isolated database or schema, ensuring complete data separation.

### Creating a Tenant
```php
use Stancl\Tenancy\Database\Models\Tenant;

$tenant = Tenant::create(['id' => 'acme']);
$tenant->domains()->create(['domain' => 'acme.example.com']);
```

### Running Tenant Migrations
```bash
php artisan tenants:migrate
```

## 📝 Sample Data

The application includes seeders with sample data:
- 3 sample clients
- 3 sample projects
- 4 sample tasks
- 3 sample invoices

This data is automatically created when running `php artisan db:seed`.

## 🔐 Security

- Laravel Sanctum for API authentication
- CSRF protection enabled
- SQL injection prevention via Eloquent ORM
- Input validation on all endpoints
- Secure password hashing

## 🤝 Contributing

Contributions are welcome! Please follow these steps:

1. Fork the repository
2. Create a feature branch (`git checkout -b feature/amazing-feature`)
3. Commit your changes (`git commit -m 'Add amazing feature'`)
4. Push to the branch (`git push origin feature/amazing-feature`)
5. Open a Pull Request

## 📄 License

The Clary platform is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).

## 📧 Support

For support, please open an issue in the GitHub repository or contact the maintainers.

---

Built with ❤️ using Laravel
