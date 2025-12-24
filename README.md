# Clary - Multi-Tenant Agency Client Management Platform

Clary is a multi-tenant agency client management platform designed to help agencies, freelancers, and service-based teams manage clients, projects, tasks, and billing all from a single, organized dashboard.

Built with scalability and simplicity in mind, Clary allows each organization to operate in its own isolated workspace while sharing a secure, centralized system. From onboarding clients to tracking work and delivering invoices, Clary streamlines the entire client lifecycle.

## Features

- **Multi-Tenancy**: Isolated workspaces for each organization
- **Client Management**: Comprehensive client profiles and contact information
- **Project Tracking**: Organize work by projects with task management
- **Task Management**: Create, assign, and track tasks across projects
- **Billing & Invoicing**: Generate and manage invoices for clients
- **Secure & Scalable**: Built on Laravel 11 with modern PHP practices

## Tech Stack

- **Backend**: Laravel 11 (PHP 8.3+)
- **Database**: MySQL/PostgreSQL/SQLite
- **Authentication**: Laravel Breeze/Sanctum
- **Multi-Tenancy**: Stancl/Tenancy

## Installation

1. Clone the repository:
```bash
git clone https://github.com/n9rrrx/clary.git
cd clary
```

2. Install PHP dependencies:
```bash
composer install
```

3. Copy the environment file:
```bash
cp .env.example .env
```

4. Generate application key:
```bash
php artisan key:generate
```

5. Configure your database in `.env` file

6. Run migrations:
```bash
php artisan migrate
```

7. Start the development server:
```bash
php artisan serve
```

## Requirements

- PHP >= 8.2
- Composer
- Database (MySQL, PostgreSQL, or SQLite)
- Node.js & NPM (for frontend assets)

## License

The Clary platform is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
